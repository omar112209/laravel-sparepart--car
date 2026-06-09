<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Notifikasi;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReturController extends Controller
{
    // ================= CUSTOMER (FRONTEND) =================

    public function index()
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('beranda')->with('error', 'Data customer tidak ditemukan.');
        }

        $returOrders = Order::with(['orderItems.produk', 'returs'])
            ->where('customer_id', $customer->id)
            ->whereIn('status', ['paid', 'Kirim', 'Selesai'])
            ->orderBy('id', 'desc')
            ->get();

        return view('v_order.retur_index', compact('returOrders'));
    }

    public function create($orderItemId)
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('beranda')->with('error', 'Data customer tidak ditemukan.');
        }

        $orderItem = OrderItem::with('order', 'produk')
            ->whereHas('order', function ($q) use ($customer) {
                $q->where('customer_id', $customer->id)
                  ->whereIn('status', ['paid', 'Kirim', 'Selesai']);
            })
            ->findOrFail($orderItemId);

        $existingRetur = Retur::where('order_item_id', $orderItem->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($existingRetur) {
            return redirect()->route('order.retur.index')
                ->with('error', 'Barang ini sudah diajukan retur.');
        }

        return view('v_order.retur_form', compact('orderItem'));
    }

    public function store(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('beranda')->with('error', 'Data customer tidak ditemukan.');
        }

        $validated = $request->validate([
            'order_item_id' => 'required|exists:order_item,id',
            'quantity' => 'required|integer|min:1',
            'alasan' => 'required|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $orderItem = OrderItem::with('order', 'produk')
            ->whereHas('order', function ($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            })
            ->findOrFail($validated['order_item_id']);

        if ($validated['quantity'] > $orderItem->quantity) {
            return back()->with('error', 'Jumlah retur tidak boleh melebihi jumlah pembelian.');
        }

        $existingRetur = Retur::where('order_item_id', $orderItem->id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->first();

        if ($existingRetur) {
            return redirect()->route('order.retur.index')
                ->with('error', 'Barang ini sudah diajukan retur.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('img-retur', 'public');
        }

        $retur = Retur::create([
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'customer_id' => $customer->id,
            'produk_id' => $orderItem->produk_id,
            'quantity' => $validated['quantity'],
            'alasan' => $validated['alasan'],
            'foto' => $fotoPath,
            'status' => 'pending',
        ]);

        Notifikasi::buat(
            'retur',
            'Retur Baru',
            "Retur dari {$customer->user->nama} — {$orderItem->produk->nama_produk} ({$validated['quantity']} pcs)",
            route('retur.admin.detail', $retur->id)
        );

        return redirect()->route('order.retur.index')
            ->with('success', 'Pengajuan retur berhasil dikirim.');
    }

    // ================= ADMIN (BACKEND) =================

    public function adminIndex()
    {
        $returs = Retur::with('order', 'customer', 'produk');

        if (in_array(request('status'), ['pending', 'disetujui', 'selesai', 'ditolak'])) {
            $returs = $returs->where('status', request('status'));
        }

        $returs = $returs
            ->orderByRaw("FIELD(status, 'pending', 'disetujui', 'selesai', 'ditolak')")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.v_retur.index', [
            'returs' => $returs,
            'subJudul' => 'Daftar Retur',
        ]);
    }

    public function adminDetail($id)
    {
        $retur = Retur::with('order.orderItems.produk', 'orderItem', 'customer', 'produk')
            ->findOrFail($id);

        return view('backend.v_retur.detail', [
            'retur' => $retur,
            'subJudul' => 'Detail Retur',
        ]);
    }

    public function adminUpdate(Request $request, $id)
    {
        $retur = Retur::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,selesai',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        if (in_array($retur->status, ['selesai', 'ditolak'])) {
            return redirect()->route('retur.admin.detail', $retur->id)
                ->with('error', 'Retur dengan status ' . $retur->status . ' tidak dapat diubah.');
        }

        $retur->status = $validated['status'];
        if (isset($validated['catatan_admin'])) {
            $retur->catatan_admin = $validated['catatan_admin'];
        }
        $retur->save();

        if (in_array($validated['status'], ['disetujui', 'selesai'])) {
            $produk = Produk::find($retur->produk_id);
            if ($produk) {
                $produk->stok += $retur->quantity;
                $produk->save();
            }
        }

        $statusLabel = match ($validated['status']) {
            'disetujui' => 'disetujui',
            'ditolak' => 'ditolak',
            'selesai' => 'selesai',
            default => $validated['status'],
        };

        Notifikasi::buat(
            'retur',
            'Status Retur',
            "Retur {$retur->produk->nama_produk} telah {$statusLabel} oleh admin.",
            route('retur.admin.detail', $retur->id)
        );

        return redirect()->route('retur.admin.index')
            ->with('success', 'Status retur berhasil diperbarui.');
    }
}
