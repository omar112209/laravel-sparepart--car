<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Kategori;
use App\Models\Notifikasi;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        $hariIni = now()->format('Y-m-d');
        $bulanIni = now()->format('Y-m');

        $pesananHariIni = Order::whereDate('created_at', $hariIni)->count();
        $totalProduk = Produk::count();
        $pendapatanBulanIni = Order::whereIn('status', ['paid', 'Kirim', 'Selesai'])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');
        $stokMenipis = Produk::where('stok', '<=', 5)->count();
        $totalKategori = Kategori::count();

        // seed stok menipis notifications for all low stock products
        $lowStockProducts = Produk::where('stok', '<=', 5)->get();
        foreach ($lowStockProducts as $p) {
            $exists = Notifikasi::where('type', 'stok')
                ->where('judul', 'Stok Menipis')
                ->where('url', route('backend.produk.edit', $p->id))
                ->whereDate('created_at', today())
                ->exists();
            if (!$exists) {
                Notifikasi::buat(
                    'stok',
                    'Stok Menipis',
                    "Stok {$p->nama_produk} tersisa {$p->stok} — segera lakukan restock.",
                    route('backend.produk.edit', $p->id)
                );
            }
        }

        $recentOrders = Order::with('customer.user')
            ->whereIn('status', ['paid', 'Kirim', 'Selesai'])
            ->latest()
            ->take(5)
            ->get();

        return view('backend.v_beranda.index', [
            'judul' => 'Beranda',
            'sub' => 'Halaman Beranda',
            'pesananHariIni' => $pesananHariIni,
            'totalProduk' => $totalProduk,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'stokMenipis' => $stokMenipis,
            'totalKategori' => $totalKategori,
            'recentOrders' => $recentOrders,
        ]);
    }
    public function index()
    {
        $produk = Produk::where('status', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_beranda.index', [
            'judul' => 'Halaman Beranda',
            'produk' => $produk,
        ]);
    }
}
