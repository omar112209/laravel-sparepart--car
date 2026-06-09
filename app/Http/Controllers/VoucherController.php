<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    // ================= ADMIN CRUD =================

    public function index()
    {
        $vouchers = Voucher::orderBy('id', 'desc')->get();
        return view('backend.v_voucher.index', [
            'judul' => 'Voucher',
            'subJudul' => 'Kelola Voucher Diskon',
            'index' => $vouchers,
        ]);
    }

    public function create()
    {
        return view('backend.v_voucher.create', [
            'judul' => 'Voucher',
            'subJudul' => 'Tambah Voucher',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:50|unique:vouchers,kode',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'min_belanja' => 'nullable|numeric|min:0',
            'maks_diskon' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'batas_pakai' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|max:500',
        ]);

        Voucher::create([
            'kode' => strtoupper($request->kode),
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'min_belanja' => $request->min_belanja ?? 0,
            'maks_diskon' => $request->maks_diskon,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'batas_pakai' => $request->batas_pakai ?? 0,
            'status' => $request->status ?? 'aktif',
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('backend.voucher.index')->with('success', 'Voucher berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('backend.v_voucher.edit', [
            'judul' => 'Voucher',
            'subJudul' => 'Edit Voucher',
            'edit' => $voucher,
        ]);
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'kode' => 'required|max:50|unique:vouchers,kode,' . $id,
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required|numeric|min:0',
            'min_belanja' => 'nullable|numeric|min:0',
            'maks_diskon' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'batas_pakai' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|max:500',
        ]);

        $voucher->update([
            'kode' => strtoupper($request->kode),
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'min_belanja' => $request->min_belanja ?? 0,
            'maks_diskon' => $request->maks_diskon,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'batas_pakai' => $request->batas_pakai ?? 0,
            'status' => $request->status ?? 'aktif',
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('backend.voucher.index')->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->usage()->delete();
        $voucher->delete();
        return redirect()->route('backend.voucher.index')->with('success', 'Voucher berhasil dihapus.');
    }

    // ================= CUSTOMER APPLY =================

    public function apply(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:50',
        ]);

        $kode = strtoupper($request->kode);
        $voucher = Voucher::where('kode', $kode)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak ditemukan.',
            ]);
        }

        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'unpaid')
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pesanan aktif.',
            ]);
        }

        $order->load('orderItems');
        $subtotal = 0;
        foreach ($order->orderItems as $item) {
            $subtotal += $item->harga * $item->quantity;
        }

        if (!$voucher->isValid($subtotal)) {
            if ($subtotal < $voucher->min_belanja) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal belanja Rp ' . number_format($voucher->min_belanja, 0, ',', '.') . ' untuk menggunakan voucher ini.',
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak valid atau sudah expired.',
            ]);
        }

        // Cek apakah user sudah pernah pakai voucher ini di order lain
        $alreadyUsed = VoucherUsage::where('voucher_id', $voucher->id)
            ->where('user_id', Auth::id())
            ->whereHas('order', function ($q) {
                $q->where('status', '!=', 'unpaid');
            })
            ->exists();

        // Hitung diskon
        $diskon = $voucher->calculateDiscount($subtotal);

        // Simpan ke session untuk ditampilkan di halaman checkout
        session([
            'voucher_applied' => [
                'kode' => $voucher->kode,
                'diskon' => $diskon,
                'voucher_id' => $voucher->id,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil digunakan! Diskon Rp ' . number_format($diskon, 0, ',', '.'),
            'diskon' => $diskon,
            'subtotal' => $subtotal,
            'total_bayar' => ($subtotal + (int) $order->biaya_ongkir) - $diskon,
            'diskon_formatted' => 'Rp ' . number_format($diskon, 0, ',', '.'),
            'total_formatted' => 'Rp ' . number_format(($subtotal + (int) $order->biaya_ongkir) - $diskon, 0, ',', '.'),
        ]);
    }

    public function remove(Request $request)
    {
        session()->forget('voucher_applied');

        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'unpaid')
            ->first();

        $subtotal = $order ? $order->total_harga : 0;
        $ongkir = $order ? (int) $order->biaya_ongkir : 0;

        return response()->json([
            'success' => true,
            'message' => 'Voucher dibatalkan.',
            'subtotal' => $subtotal,
            'total_bayar' => $subtotal + $ongkir,
            'total_formatted' => 'Rp ' . number_format($subtotal + $ongkir, 0, ',', '.'),
        ]);
    }
}
