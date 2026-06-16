<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Notifikasi;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    public function addToCart($id)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $produk = Produk::findOrFail($id);
        if ($produk->stok <= 0) {
            return redirect()->route('order.cart')->with('error', 'Stok produk habis');
        }
        $order = Order::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => 'unpaid'],
            ['total_harga' => 0]
        );
        $existingItem = $order->orderItems()->where('produk_id', $produk->id)->first();
        if ($existingItem) {
            if ($existingItem->quantity + 1 > $produk->stok) {
                return redirect()->route('order.cart')->with('error', 'Jumlah produk melebihi stok yang tersedia');
            }
            $existingItem->quantity++;
            $existingItem->save();
            $order->total_harga += $existingItem->harga;
            $produk->decrement('stok', 1);
        } else {
            $item = new OrderItem();
            $item->order_id = $order->id;
            $item->produk_id = $produk->id;
            $item->quantity = 1;
            $item->harga = $produk->harga;
            $item->save();
            $order->total_harga += $produk->harga;
            $produk->decrement('stok', 1);
        }
        $order->save();
        return redirect()->route('order.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function viewCart()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'unpaid')
            ->first();
        if ($order) {
            $order->load('orderItems.produk');
        }
        return view('v_order.cart', compact('order'));
    }

    public function updateCart(Request $request, $id)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)->where('status', 'unpaid')->first();
        if ($order) {
            $orderItem = $order->orderItems()->where('id', $id)->first();
            if ($orderItem) {
                $produk = $orderItem->produk;
                $quantity = $request->input('quantity');
                $oldQty = $orderItem->quantity;
                if ($quantity > $oldQty) {
                    $additional = $quantity - $oldQty;
                    if ($additional > $produk->stok) {
                        return redirect()->route('order.cart')->with('error', 'Jumlah produk melebihi stok yang tersedia');
                    }
                    $produk->decrement('stok', $additional);
                } elseif ($quantity < $oldQty) {
                    $produk->increment('stok', $oldQty - $quantity);
                }
                $order->total_harga -= $orderItem->harga * $oldQty;
                $orderItem->quantity = $quantity;
                $orderItem->save();
                $order->total_harga += $orderItem->harga * $quantity;
                $order->save();
            }
        }
        return redirect()->route('order.cart')->with('success', 'Jumlah produk berhasil diperbarui');
    }

    public function removeFromCart(Request $request, $id)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)->where('status', 'unpaid')->first();
        if ($order) {
            $orderItem = OrderItem::where('order_id', $order->id)->where('produk_id', $id)->first();
            if ($orderItem) {
                $produk = Produk::find($orderItem->produk_id);
                if ($produk) {
                    $produk->increment('stok', $orderItem->quantity);
                }
                $order->total_harga -= $orderItem->harga * $orderItem->quantity;
                $orderItem->delete();
                if ($order->total_harga <= 0) {
                    $order->delete();
                } else {
                    $order->save();
                }
            }
        }
        return redirect()->route('order.cart')->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function selectShipping(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)->where('status', 'unpaid')->first();
        if (!$order || $order->orderItems->count() == 0) {
            return redirect()->route('order.cart')->with('error', 'Keranjang belanja kosong.');
        }

        $order->load('orderItems.produk');
        $totalBerat = $order->orderItems->sum(fn($i) => ($i->produk->berat ?? 0) * $i->quantity);

        return view('v_order.select_shipping', compact('order', 'customer', 'totalBerat'));
    }

    public function updateongkir(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)->where('status', 'unpaid')->first();

        if (!$order) {
            return back()->with('error', 'Order tidak ditemukan.');
        }

        $parsed = explode('|', $request->input('courier', '|||'));
        $layanan = $parsed[0] ?? '';
        $biaya   = (int) ($parsed[1] ?? 0);
        $etd     = $parsed[2] ?? '';

        $kurir = explode(' - ', $layanan);
        $kurirCode = strtolower(trim($kurir[0] ?? ''));
        $layananName = trim($kurir[1] ?? $layanan);

        $order->load('orderItems.produk');
        $totalBerat = $order->orderItems->sum(fn($i) => ($i->produk->berat ?? 0) * $i->quantity);

        $detailAlamat = $request->input('detail_alamat', '');
        $provinsi     = $request->input('provinsi', '');
        $kota         = $request->input('kota_kabupaten', '');
        $kecamatan    = $request->input('kecamatan', '');
        $pos          = $request->input('pos', '');

        $alamatLengkap = trim("$detailAlamat, $kecamatan, $kota, $provinsi", ', ');

        $order->kurir           = $kurirCode;
        $order->layanan_ongkir  = $layananName;
        $order->biaya_ongkir    = $biaya;
        $order->estimasi_ongkir = $etd;
        $order->total_berat     = (string) $totalBerat;
        $order->alamat          = $alamatLengkap;
        $order->pos             = $pos;
        $order->save();

        $customer->update([
            'detail_alamat' => $detailAlamat,
            'provinsi'      => $provinsi,
            'provinsi_id'   => $request->input('provinsi_id'),
            'kota_kabupaten'=> $kota,
            'kota_id'       => $request->input('kota_id'),
            'kecamatan'     => $kecamatan,
            'kecamatan_id'  => $request->input('kecamatan_id'),
            'pos'           => $pos,
        ]);

        return redirect()->route('order.selectpayment');
    }

    public function selectPayment()
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('beranda')->with('error', 'Data customer tidak ditemukan.');
        }

        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'unpaid')
            ->first();

        if (!$order) {
            return redirect()->route('order.cart')->with('error', 'Order tidak ditemukan.');
        }

        $order->load('orderItems.produk');

        if ($order->orderItems->count() == 0) {
            return redirect()->route('order.cart')->with('error', 'Keranjang belanja kosong.');
        }

        $totalHarga = 0;
        foreach ($order->orderItems as $item) {
            $totalHarga += $item->harga * $item->quantity;
        }

        $biaya_ongkir = (int) $order->biaya_ongkir;

        // Apply voucher discount (from order or session fallback)
        $diskon = (int) $order->voucher_discount;
        if (!$diskon) {
            $voucherApplied = session('voucher_applied');
            if ($voucherApplied) {
                $diskon = $voucherApplied['diskon'];
            }
        }

        $totalBayar = ($totalHarga + $biaya_ongkir) - $diskon;

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $orderId = $order->id . '-' . time();

        $user = \App\Models\User::find($customer->user_id);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => (string) ($user->nama ?? 'Customer'),
                'email'      => (string) ($user->email ?? 'customer@email.com'),
                'phone'      => (string) ($user->hp ?? '08000000000'),
            ],
        ];
        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghubungi Midtrans: ' . $e->getMessage());
        }

        return view('v_order.selectpayment', compact('order', 'snapToken', 'totalHarga', 'biaya_ongkir', 'diskon', 'totalBayar'));
    }

    public function orderHistory()
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('beranda')->with('error', 'Data customer tidak ditemukan.');
        }

        $orders = Order::where('customer_id', $customer->id)
            ->whereIn('status', ['unpaid', 'paid', 'Kirim', 'Selesai'])
            ->with('orderItems.produk')
            ->orderBy('id', 'desc')
            ->get();

        // Untuk fallback jika produk sudah dihapus
        $allProduk = Produk::all()->keyBy('id');

        // Map items per order agar view tetap konsisten
        $rawItems = [];
        foreach ($orders as $order) {
            $rawItems[$order->id] = $order->orderItems;
        }

        return view('v_order.history', compact('orders', 'rawItems', 'allProduk'));
    }

    public function complete(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('beranda');
        }

        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');
        $statusCode = $request->query('status_code');
        $grossAmount = $request->query('gross_amount');
        $signatureKey = $request->query('signature_key');

        $signatureValid = false;
        if ($orderId && $signatureKey && $statusCode && $grossAmount) {
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
            if ($hashed === $signatureKey) {
                $signatureValid = true;
            }
        }

        if ($orderId) {
            $realOrderId = explode('-', $orderId)[0];
            $order = Order::where('customer_id', $customer->id)->find($realOrderId);
        } else {
            $order = Order::where('customer_id', $customer->id)
                ->where('status', 'unpaid')
                ->latest()
                ->first();
        }

        if (!$order) {
            return redirect()->route('order.history')->with('error', 'Pesanan tidak ditemukan.');
        }

        $allProduk = Produk::all()->keyBy('id');

        $dbItems = DB::table('order_item')->where('order_id', $order->id)->get();

        $recalculatedTotal = 0;
        foreach ($dbItems as $dbitem) {
            $recalculatedTotal += $dbitem->harga * $dbitem->quantity;
        }

        if ($order->status === 'unpaid') {
            $isPaid = false;
            if ($signatureValid) {
                $isPaid = in_array($transactionStatus, ['settlement', 'capture']);
            } elseif (!$signatureKey) {
                $isPaid = true;
            }
            if ($isPaid) {
                $order->update(['total_harga' => $recalculatedTotal]);
                $order->update(['status' => 'paid']);
            }
        }

        // Persist voucher usage (from order's saved fields or session fallback)
        $voucherCode = $order->voucher_code;
        $voucherDiscount = (int) $order->voucher_discount;

        if (!$voucherCode) {
            $voucherApplied = session('voucher_applied');
            if ($voucherApplied) {
                $voucherCode = $voucherApplied['kode'];
                $voucherDiscount = (int) $voucherApplied['diskon'];
                $order->update([
                    'voucher_code' => $voucherCode,
                    'voucher_discount' => $voucherDiscount,
                ]);
            }
        }

        if ($voucherCode && $voucherDiscount > 0) {
            $alreadyRecorded = \App\Models\VoucherUsage::where('order_id', $order->id)->exists();
            if (!$alreadyRecorded) {
                $voucher = \App\Models\Voucher::where('kode', $voucherCode)->first();
                if ($voucher) {
                    \App\Models\VoucherUsage::create([
                        'voucher_id' => $voucher->id,
                        'order_id' => $order->id,
                        'user_id' => Auth::id(),
                        'diskon' => $voucherDiscount,
                    ]);
                    $voucher->increment('dipakai');
                }
            }
            session()->forget('voucher_applied');
        }

        if ($order->status === 'paid') {
            $total_bayar = (int) $order->total_harga + (int) $order->biaya_ongkir - (int) $order->voucher_discount;
            return view('v_order.success', compact('order', 'total_bayar', 'dbItems', 'allProduk'));
        }

        return redirect()->route('order.history')->with('error', 'Pembayaran belum terverifikasi. Silakan cek riwayat pesanan secara berkala.');
    }

    // ================= MIDTRANS CALLBACK =================
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash(
            "sha512",
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($hashed == $request->signature_key) {
            // order_id format: "1-timestamp", ambil angka pertama
            $orderId = explode('-', $request->order_id)[0];
            $order = Order::find($orderId);

            if ($order) {
                if (
                    $request->transaction_status == 'settlement' ||
                    $request->transaction_status == 'capture'
                ) {
                    if ($order->status === 'unpaid') {
                        $order->load('orderItems');

                        // Recalculate total_harga from items for consistency
                        $recalculatedTotal = 0;
                        foreach ($order->orderItems as $item) {
                            $recalculatedTotal += $item->harga * $item->quantity;
                        }
                        $order->update(['total_harga' => $recalculatedTotal]);

                        // Persist voucher usage from order's saved fields
                        $voucherCode = $order->voucher_code;
                        $voucherDiscount = (int) $order->voucher_discount;
                        if ($voucherCode && $voucherDiscount > 0) {
                            $alreadyRecorded = \App\Models\VoucherUsage::where('order_id', $order->id)->exists();
                            if (!$alreadyRecorded) {
                                $voucher = \App\Models\Voucher::where('kode', $voucherCode)->first();
                                if ($voucher) {
                                    \App\Models\VoucherUsage::create([
                                        'voucher_id' => $voucher->id,
                                        'order_id' => $order->id,
                                        'user_id' => $order->customer->user_id,
                                        'diskon' => $voucherDiscount,
                                    ]);
                                    $voucher->increment('dipakai');
                                }
                            }
                        }
                    }
                    $order->update(['status' => 'paid']);

                    Notifikasi::buat(
                        'pesanan',
                        'Pesanan Baru',
                        "Pesanan #" . str_pad($order->id, 4, '0', STR_PAD_LEFT) . " telah dibayar — Rp " . number_format($order->total_harga, 0, ',', '.'),
                        route('pesanan.detail', $order->id)
                    );
                } elseif (
                    $request->transaction_status == 'cancel' ||
                    $request->transaction_status == 'deny' ||
                    $request->transaction_status == 'expire'
                ) {
                    if ($order->status === 'paid' || $order->status === 'unpaid') {
                        $this->incrementStock($order);
                    }
                    $order->update(['status' => 'cancel']);
                }
            }
        }

        return response()->json(['message' => 'OK']);
    }

    // ================= BACKEND PESANAN =================
    public function statusProses()
    {
        $order = Order::whereIn('status', ['unpaid', 'paid', 'Kirim'])->orderBy('id', 'desc')->get();
        return view('backend.v_pesanan.proses', [
            'judul'    => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
            'index'    => $order,
        ]);
    }

    public function statusSelesai()
    {
        $order = Order::where('status', 'Selesai')->orderBy('id', 'desc')->get();
        return view('backend.v_pesanan.selesai', [
            'judul'    => 'Data Transaksi',
            'subJudul' => 'Pesanan Selesai',
            'index'    => $order,
        ]);
    }

    public function statusDetail($id)
    {
        $order = Order::with('orderItems.produk', 'customer')->findOrFail($id);
        return view('backend.v_pesanan.detail', [
            'judul'    => 'Data Transaksi',
            'subJudul' => 'Detail Pesanan',
            'order'    => $order,
        ]);
    }

    public function statusUpdate(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $rules = ['alamat' => 'required'];
        if ($request->status != $order->status) {
            $rules['status'] = 'required';
        }
        if ($request->noresi != $order->noresi) {
            $rules['noresi'] = 'required';
        }
        if ($request->pos != $order->pos) {
            $rules['pos'] = 'required';
        }
        $validatedData = $request->validate($rules);
        Order::where('id', $id)->update($validatedData);

        if ($request->has('status') && $request->status != $oldStatus) {
            $newOrder = Order::find($id);
            if ($request->status === 'cancel' && ($oldStatus === 'paid' || $oldStatus === 'unpaid')) {
                $this->incrementStock($newOrder);
            }

            if ($request->status === 'Kirim') {
                Notifikasi::buat(
                    'pesanan',
                    'Pesanan Dikirim',
                    "Pesanan #" . str_pad($newOrder->id, 4, '0', STR_PAD_LEFT) . " sedang dalam pengiriman — No. Resi: " . ($request->noresi ?? '-'),
                    route('pesanan.detail', $newOrder->id)
                );
            } elseif ($request->status === 'Selesai') {
                Notifikasi::buat(
                    'pesanan',
                    'Pesanan Selesai',
                    "Pesanan #" . str_pad($newOrder->id, 4, '0', STR_PAD_LEFT) . " telah selesai.",
                    route('pesanan.detail', $newOrder->id)
                );
            } elseif ($request->status === 'cancel') {
                Notifikasi::buat(
                    'pesanan',
                    'Pesanan Dibatalkan',
                    "Pesanan #" . str_pad($newOrder->id, 4, '0', STR_PAD_LEFT) . " telah dibatalkan.",
                    route('pesanan.detail', $newOrder->id)
                );
            }
        }

        return redirect()->route('pesanan.proses')->with('success', 'Data berhasil diperbaharui');
    }

    // ================= BACKEND LAPORAN =================
    public function formOrderProses()
    {
        return view('backend.v_pesanan.formproses', [
            'judul'    => 'Laporan',
            'subJudul' => 'Laporan Pesanan Proses',
        ]);
    }

    public function cetakOrderProses(Request $request)
    {
        $request->validate([
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal  = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $order = Order::with('orderItems.produk', 'customer')
            ->whereIn('status', ['paid', 'Kirim'])
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir . ' 23:59:59'])
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.v_pesanan.cetakproses', [
            'judul'        => 'Laporan',
            'subJudul'     => 'Laporan Pesanan Proses',
            'tanggalAwal'  => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak'        => $order,
        ]);
    }

    public function formOrderSelesai()
    {
        return view('backend.v_pesanan.formselesai', [
            'judul'    => 'Laporan',
            'subJudul' => 'Laporan Pesanan Selesai',
        ]);
    }

    public function cetakOrderSelesai(Request $request)
    {
        $request->validate([
            'tanggal_awal'  => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        $tanggalAwal  = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $order = Order::with('orderItems.produk', 'customer')
            ->where('status', 'Selesai')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir . ' 23:59:59'])
            ->orderBy('id', 'desc')
            ->get();
        $totalPendapatan = $order->sum(fn($row) => $row->total_harga + $row->biaya_ongkir);
        return view('backend.v_pesanan.cetakselesai', [
            'judul'           => 'Laporan',
            'subJudul'        => 'Laporan Pesanan Selesai',
            'tanggalAwal'     => $tanggalAwal,
            'tanggalAkhir'    => $tanggalAkhir,
            'cetak'           => $order,
            'totalPendapatan' => $totalPendapatan,
        ]);
    }

    // ================= INVOICE =================
    public function invoiceBackend($id)
    {
        $order = Order::with('orderItems.produk', 'customer')->findOrFail($id);
        return view('backend.v_pesanan.invoice', [
            'judul'    => 'Data Transaksi',
            'subJudul' => 'Invoice Pesanan',
            'order'    => $order,
        ]);
    }

    public function invoiceFrontend($id)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::with('orderItems.produk', 'customer')
            ->where('customer_id', $customer->id)
            ->findOrFail($id);
        return view('backend.v_pesanan.invoice', [
            'judul'    => 'Invoice',
            'subJudul' => 'Invoice Pesanan',
            'order'    => $order,
        ]);
    }

    // ================= ONGKIR =================
    public function getCost(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->post(env('RAJAONGKIR_BASE_URL') . '/cost', [
            'origin'      => $request->input('origin'),
            'destination' => $request->input('destination'),
            'weight'      => $request->input('weight'),
            'courier'     => $request->input('courier'),
        ]);
        return response()->json($response->json());
    }

    private function decrementStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $produk = Produk::find($item->produk_id);
            if ($produk) {
                $produk->decrement('stok', $item->quantity);
            }
        }
    }

    private function incrementStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $produk = Produk::find($item->produk_id);
            if ($produk) {
                $produk->increment('stok', $item->quantity);
            }
        }
    }
}
