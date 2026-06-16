# Manajemen Risiko — Tokosparepart Mobil

> Dokumen ini berisi daftar risiko, dampaknya, dan apa yang harus dilakukan.

---

## 📊 Cara Membaca

Setiap risiko punya nilai **Probabilitas** (seberapa sering terjadi) dan **Dampak** (seberapa parah akibatnya):

| Level | Warna | Artinya |
|-------|-------|---------|
| **Critical** | 🔴 | **BAHAYA!** Harus diperbaiki sekarang (0-7 hari) |
| **High** | 🟠 | **Penting** — perbaiki minggu ini |
| **Medium** | 🟡 | **Sedang** — jadwalkan bulan ini |
| **Low** | 🟢 | **Ringan** — pantau, perbaiki kalau sempat |

---

## 🔴 CRITICAL — Harus Sekarang!

| # | Risiko | Masalahnya | Solusi | Estimasi |
|---|--------|-----------|--------|----------|
| 1 | **Pembayaran Bisa Dibajak** | Customer bisa akses order orang lain & dapat barang gratis | Tambah pengecekan `customer_id` di controller | ⏱ 1 jam |
| 2 | **Akun Customer Bisa Diambil Alih** | Siapa saja bisa edit profil orang lain | Tambah verifikasi kepemilikan akun | ⏱ 30 menit |
| 3 | **Debug Mode Nyala** | Semua data & password bocor kalau error | Matikan `APP_DEBUG` di production | ⏱ 15 menit |
| 4 | **HTTPS Tidak Aktif** | Data pelanggan bisa diintip orang | Paksa HTTPS di seluruh halaman | ⏱ 1 jam |
| 5 | **Login Admin Bruteforce** | Hacker bisa coba password berkali-kali tanpa batas | Batasi percobaan login admin (5x, lalu blokir 1 menit) | ⏱ 30 menit |
| 6 | **Tidak Ada Sitemap** | Google tidak tahu halaman kita, website tidak muncul di pencarian | Buat sitemap.xml otomatis | ⏱ 3 jam |
| 7 | **Tidak Ada Backup** | Kalau server mati, data hilang total | Backup database + file otomatis tiap hari | ⏱ 4 jam |
| 8 | **API Pihak Ketiga Error** | Kalau API RajaOngkir/Midtrans down, website error total | Tambah timeout + pesan cadangan | ⏱ 4 jam |

---

## 🟠 HIGH — Perbaiki Minggu Ini

### Keuangan

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 1 | **Refund Tidak Terkelola** | Retur disetujui tapi uang tidak pernah dikembalikan | Buat alur refund bertahap (approve → transfer → selesai) |
| 2 | **Biaya API Membengkak** | API RajaOngkir dipanggil terus, biaya membesar | Cache hasil ongkir + batasi pemanggilan |
| 3 | **Kerugian dari Keranjang Ditinggalkan** | Pelanggan sudah masukin barang ke cart tapi tidak jadi beli | Kirim email pengingat otomatis |
| 4 | **Kehilangan Penjualan Tambahan** | Tidak ada rekomendasi produk terkait | Tampilkan "Produk Terkait" di halaman detail |

### Keamanan

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 5 | **CORS Kebuka Semua** | Website lain bisa akses API kita | Batasi ke domain kita saja |
| 6 | **Tidak Ada 2FA Admin** | Cukup tahu password = bisa masuk | Tambah kode verifikasi dari Google Authenticator |
| 7 | **Header Keamanan Hilang** | Website rentan clickjacking & XSS | Pasang security header standar (CSP, HSTS, dll) |

### Operasional

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 8 | **Deploy Manual — Sering Error** | Kopi file via FTP, riskan salah | Buat GitHub Actions auto-deploy |
| 9 | **Email Tidak Terkirim** | Status order berubah tapi customer tidak dikasih tahu | Tambah queue + mailable |
| 10 | **Cart Menumpuk** | Data cart sampah tidak pernah dibersihkan | Cronjob hapus cart > 1 hari |
| 11 | **Proses Lambat** | Semua jalan urut, tidak bisa paralel | Aktifkan queue (database/redis) |

### Reputasi

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 12 | **COD Dipasang Tapi Tidak Bisa Dipakai** | Iklan COD, pas bayar tidak ada pilihan COD | Implementasi COD atau hapus dari website |
| 13 | **Wajib Daftar Dulu Baru Bisa Beli** | Pelanggan malas daftar, langsung pergi | Tambah opsi checkout tanpa daftar |
| 14 | **Tidak Ada Review Produk** | Pembeli tidak tahu kualitas barang | Tambah fitur bintang + komentar |
| 15 | **Tidak Ada Varian Produk** | Kampas rem untuk Mazda 2 vs Mazda 3 sama semua | Tambah pilihan tipe/ukuran produk |
| 16 | **Tidak Bisa Lacak Paket** | Field resi ada tapi tidak bisa dilacak otomatis | Integrasi API tracking (BinderByte) |

### Teknis

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 17 | **Test Kurang — Bug Tidak Terdeteksi** | Cuma 39 test, 0 test untuk checkout & bayar | Tambah test untuk flow paling penting |
| 18 | **Tidak Bisa Ukur Traffic** | Tidak tahu berapa pengunjung, dari mana | Pasang Google Analytics |

### SEO & Marketing

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 19 | **Share ke Facebook/WA Tampil Jelek** | Cuma link doang, tanpa gambar & deskripsi | Tambah meta tag (OG tag) |
| 20 | **Tidak Muncul di Google Rich Result** | Hasil pencarian biasa aja, tanpa bintang | Tambah JSON-LD structured data |
| 21 | **Tidak Ada Blog** | Google suka konten baru, website sepi | Buat halaman blog/artikel |

---

## 🟡 MEDIUM — Jadwalkan Bulan Ini

### Keuangan

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 1 | **Voucher Bisa Disalahgunakan** | Tidak ada laporan siapa pakai voucher | Tambah tracking + batas pakai per user |
| 2 | **Tidak Ada Harga Grosir** | Harga 1 pc sama dengan 100 pc | Tambah harga khusus quantity banyak |
| 3 | **File Duplikat Boros Storage** | Ada folder `frontend/eshop/` duplikat tak terpakai | Hapus folder duplikat |

### Keamanan

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 4 | **Session Tidak Di-encrypt** | Data session bisa dibaca dari file | Aktifkan encrypt session |
| 5 | **Nama File Bisa Ditebak** | File upload pakai timestamp, orang bisa akses file orang lain | Pakai nama acak (UUID) |
| 6 | **API Rawan Eksploitasi** | Route API tanpa proteksi CSRF | Tambah token authentication |
| 7 | **Logout Admin Ganggu Customer** | Admin logout, customer ikut logout | Pakai guard berbeda untuk admin & customer |
| 8 | **Aksi Sensitif Tanpa Konfirmasi** | Approve retur tanpa konfirmasi password | Tambah input password untuk aksi penting |

### Operasional

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 9 | **Log File Besar Banget** | 1 file log terus membesar sampai GB | Rotasi log per hari |
| 10 | **Website Sakit Tidak Ketahuan** | Tidak ada yang monitor kesehatan server | Tambah endpoint `/health` |
| 11 | **Database Lemot** | Query lama karena tidak ada index | Tambah index di kolom pencarian |

### Teknis

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 12 | **Data Kotor Bisa Masuk** | Harga diisi huruf, stok minus | Validasi numeric & min value |
| 13 | **Kode Sulit Diubah** | Semua aturan nempel di controller, bingung kalau mau ganti | Pisahkan validasi ke Form Request |
| 14 | **Kode Berantakan** | Tab vs spasi campur, gaya beda tiap file | Pakai Laravel Pint untuk format otomatis |
| 15 | **Error Tampil Jelek** | Error cuma teks putih polos | Buat halaman error keren (404, 500) |
| 16 | **Tidak Ada Dokumentasi API** | Developer lain bingung cara pake API | Pasang Scribe/Swagger |
| 17 | **Developer Manual Muluk** | Input data test satu-satu | Buat Factory + Seeder |

### Reputasi

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 18 | **Mobile Checkout Berantakan** | Form panjang, tombol kecium | Rombak layout mobile-friendly |
| 19 | **Pelanggan Tersesat** | Tidak tahu lagi di halaman mana | Tambah breadcrumb |

### SEO

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 20 | **Konten Duplikat — Ranking Turun** | Google bingung halaman mana yang asli | Tambah tag canonical |
| 21 | **Form Newsletter Cuma Hiasan** | Pelanggan isi email, tidak tersimpan | Simpan ke database + kirim email promo |

---

## 🟢 LOW — Pantau Saja

| # | Risiko | Masalahnya | Solusi |
|---|--------|-----------|--------|
| 1 | **Tidak Ada Syarat & Ketentuan** | Tidak ada halaman Terms of Service | Buat halaman ToS sederhana |

---

## 📈 Ringkasan

| Level | Jumlah | Target Selesai |
|-------|--------|----------------|
| 🔴 **Critical** | **8** | **1 minggu** |
| 🟠 **High** | **21** | **1 bulan** |
| 🟡 **Medium** | **21** | **3 bulan** |
| 🟢 **Low** | **1** | **Kapan saja** |
| **Total** | **51** | |

### Yang Paling Penting Dilakukan **HARI INI**:

```
1. 🔴 Tambah pengecekan kepemilikan di pembayaran   (30 menit)
2. 🔴 Tambah pengecekan kepemilikan di profil        (30 menit)
3. 🔴 Matikan debug mode                              (15 menit)
4. 🔴 Batasi percobaan login admin                    (30 menit)
```

> Dokumen ini bisa diupdate kapan saja. Kalau ada risiko baru yang ditemukan, langsung tambahkan.
