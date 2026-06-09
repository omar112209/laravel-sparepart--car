<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\FotoProduk;
use App\Models\Notifikasi;
use App\Helpers\ImageHelper;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::orderBy('updated_at', 'desc');
        if (request('stok_menipis')) {
            $produk = $produk->where('stok', '<=', 5);
        }
        $produk = $produk->get();
        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'index' => $produk
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|max:255|unique:produk',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png,

            atau gif.',

            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ]);
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 0;
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);
            $validatedData['foto'] = $fileName;
        }
        $produk = Produk::create($validatedData);
        if ($produk->stok <= 5) {
            Notifikasi::buat(
                'stok',
                'Stok Menipis',
                "Stok {$produk->nama_produk} tersisa {$produk->stok} — segera lakukan restock.",
                route('backend.produk.edit', $produk->id)
            );
        }
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil
            tersimpan');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with('fotoProduk')->findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.show', [
            'judul' => 'Detail Produk',
            'show' => $produk,
            'kategori' => $kategori
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.edit', [
            'judul' => 'Ubah Produk',
            'edit' => $produk,
            'kategori' => $kategori
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request);
        $produk = Produk::findOrFail($id);
        $rules = [
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $id,
            'kategori_id' => 'required',
            'status' => 'required',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png,

            atau gif.',

            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ];
        $validatedData['user_id'] = auth()->id();
        $validatedData = $request->validate($rules, $messages);
        if ($request->file('foto')) {
            if ($produk->foto) {
                $oldImagePath = public_path('storage/img-produk/') . $produk->foto;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                foreach (['thumb_lg_', 'thumb_md_', 'thumb_sm_'] as $prefix) {
                    $thumbPath = public_path('storage/img-produk/') . $prefix . $produk->foto;
                    if (file_exists($thumbPath)) {
                        unlink($thumbPath);
                    }
                }
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);
            $validatedData['foto'] = $fileName;
        }
        $produk->update($validatedData);
        if ($produk->stok <= 5) {
            Notifikasi::buat(
                'stok',
                'Stok Menipis',
                "Stok {$produk->nama_produk} tersisa {$produk->stok} — segera lakukan restock.",
                route('backend.produk.edit', $produk->id)
            );
        }
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil
            diperbaharui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $directory = public_path('storage/img-produk/');
        if ($produk->foto) {
            // Hapus gambar asli
            $oldImagePath = $directory . $produk->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            // Hapus thumbnail lg
            $thumbnailLg = $directory . 'thumb_lg_' . $produk->foto;
            if (file_exists($thumbnailLg)) {
                unlink($thumbnailLg);
            }
            // Hapus thumbnail md
            $thumbnailMd = $directory . 'thumb_md_' . $produk->foto;
            if (file_exists($thumbnailMd)) {
                unlink($thumbnailMd);
            }
            // Hapus thumbnail sm
            $thumbnailSm = $directory . 'thumb_sm_' . $produk->foto;
            if (file_exists($thumbnailSm)) {
                unlink($thumbnailSm);
            }
        }
        // Hapus foto produk lainnya di tabel foto_produk
        $fotoProduks = FotoProduk::where('produk_id', $id)->get();
        foreach ($fotoProduks as $fotoProduk) {
            $fotoPath = $directory . $fotoProduk->foto;
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
            $fotoProduk->delete();
        }
        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil
            dihapus');
    }
    // Method untuk menyimpan foto tambahan
    public function storeFoto(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'foto_produk.*' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ]);
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                // Buat nama file yang unik
                $extension = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
                $directory = 'storage/img-produk/';
                // Simpan dan resize gambar menggunakan ImageHelper
                ImageHelper::uploadAndResize($file, $directory, $filename, 800, null);
                // Simpan data ke database
                FotoProduk::create([
                    'produk_id' => $request->produk_id,
                    'foto' => $filename,
                ]);
            }
        }
        return redirect()->route('backend.produk.show', $request->produk_id)
            ->with('success', 'Foto berhasil ditambahkan.');
    }
    // Method untuk menghapus foto
    public function destroyFoto(string $id)
    {
        $foto = FotoProduk::findOrFail($id);
        $produkId = $foto->produk_id;
        // Hapus file gambar dari storage
        $imagePath = public_path('storage/img-produk/') . $foto->foto;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        // Hapus record dari database
        $foto->delete();
        return redirect()->route('backend.produk.show', $produkId)
            ->with('success', 'Foto berhasil dihapus.');
    }
    // Method untuk Form Laporan Produk
    public function formProduk()
    {
        return view('backend.v_produk.form', [
            'judul' => 'Laporan Data Produk',
        ]);
    }
    // Method untuk Cetak Laporan Produk
    public function cetakProduk(Request $request)
    {
        // Menambahkan aturan validasi
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ], [
            'tanggal_awal.required' => 'Tanggal Awal harus diisi.',
            'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.',
            'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama

        dengan Tanggal Awal.',
        ]);
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $query = Produk::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('id', 'desc');
        $produk = $query->get();
        return view('backend.v_produk.cetak', [
            'judul' => 'Laporan Produk',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $produk
        ]);
    }
    public function detail(string $id)
    {
        $fotoProdukTambahan = FotoProduk::where('produk_id', $id)->get();
        $detail = Produk::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'desc')->get();
        return view('v_produk.detail', [
            'judul' => 'Detail Produk',
            'kategori' => $kategori,
            'row' => $detail,
            'fotoProdukTambahan' => $fotoProdukTambahan
        ]);
    }
    public function produkKategori(string $id)
    {
        $kategori = Kategori::orderBy('nama_kategori', 'desc')->get();
        $produk = Produk::where('kategori_id', $id)->where('status', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_produk.produkkategori', [
            'judul' => 'Filter Kategori',
            'kategori' => $kategori,
            'produk' => $produk,
        ]);
    }
    public function produkAll()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'desc')->get();
        $produk = Produk::where('status', 1)->orderBy('updated_at', 'desc')->paginate(6);
        return view('v_produk.index', [
            'judul' => 'Semua Produk',
            'kategori' => $kategori,
            'produk' => $produk,
        ]);
    }
    public function search(Request $request)
    {
        $q = $request->input('q');
        $kategori = Kategori::orderBy('nama_kategori', 'desc')->get();
        $produk = Produk::where('status', 1)
            ->where(function ($query) use ($q) {
                $query->where('nama_produk', 'like', '%' . $q . '%')
                      ->orWhere('detail', 'like', '%' . $q . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(6)
            ->appends(['q' => $q]);
        return view('v_produk.index', [
            'judul' => 'Pencarian: "' . $q . '"',
            'kategori' => $kategori,
            'produk' => $produk,
        ]);
    }
}
