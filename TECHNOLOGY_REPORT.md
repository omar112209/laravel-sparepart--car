# Laporan Teknologi — Tokosparepart Mobil

**Tanggal:** 3 Juni 2026
**Versi Aplikasi:** 1.0.0
**Framework:** Laravel 10.50.2 / PHP 8.3.22 / MySQL / Tailwind CSS v4.3.0

---

## Daftar Isi

1. [Arsitektur Aplikasi](#1-arsitektur-aplikasi)
2. [Stack Teknologi](#2-stack-teknologi)
3. [Frontend & Tema](#3-frontend--tema)
4. [Sistem Autentikasi & Role](#4-sistem-autentikasi--role)
5. [Sistem E-commerce](#5-sistem-e-commerce)
6. [Payment Gateway — Midtrans](#6-payment-gateway--midtrans)
7. [Shipping API — RajaOngkir](#7-shipping-api--rajaongkir)
8. [Google OAuth](#8-google-oauth)
9. [Sistem Voucher & Diskon](#9-sistem-voucher--diskon)
10. [Sistem Retur](#10-sistem-retur)
11. [Sistem Notifikasi](#11-sistem-notifikasi)
12. [Upload & Proses Gambar](#12-upload--proses-gambar)
13. [Database Schema](#13-database-schema)
14. [Struktur Routes](#14-struktur-routes)
15. [Struktur Proyek](#15-struktur-proyek)
16. [Daftar Dependencies](#16-daftar-dependencies)

---

## 1. Arsitektur Aplikasi

```
┌─────────────────────────────────────────────────┐
│                    Frontend                      │
│  (Tailwind CSS v4 + Vite 8 + Blade Template)     │
├─────────────────────────────────────────────────┤
│               Laravel 10 MVC                     │
│  ┌─────────┐ ┌──────────┐ ┌──────────────────┐  │
│  │  Routes  │ │Controller│ │  Blade Views     │  │
│  │ (web.php)│ │  (13 pc) │ │  (52 file)       │  │
│  └─────────┘ └──────────┘ └──────────────────┘  │
│  ┌─────────┐ ┌──────────┐ ┌──────────────────┐  │
│  │ Model   │ │ Migrate  │ │  Middleware       │  │
│  │ (11 pc) │ │ (18 file)│ │  (10 pc)          │  │
│  └─────────┘ └──────────┘ └──────────────────┘  │
├─────────────────────────────────────────────────┤
│              External Services                   │
│  Midtrans (Payment) | RajaOngkir (Shipping)      │
│  Google OAuth | Komerce API                      │
└─────────────────────────────────────────────────┘
```

### Arsitektur Sistem

- **Pola**: MVC (Model-View-Controller) klasik Laravel
- **Database**: MySQL dengan 14 tabel relasional
- **Frontend**: Server-rendered Blade dengan Vite untuk asset bundling
- **API**: RESTful endpoints untuk RajaOngkir, AJAX notifikasi, dan Midtrans callback
- **Auth**: Dual-guard authentication (`admin` untuk backend, `web` untuk customer)

---

## 2. Stack Teknologi

### Backend

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | ^8.1 | Bahasa pemrograman |
| **Laravel** | 10.50.2 | Framework MVC |
| **MySQL** | — | Database relasional |
| **Midtrans PHP SDK** | ^2.6 | Payment gateway Snap API |
| **Laravel Socialite** | ^5.26 | Google OAuth |
| **GuzzleHTTP** | ^7.10 | HTTP client (RajaOngkir API) |
| **Doctrine DBAL** | ^3.10 | Schema alterations |

### Frontend

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **Tailwind CSS** | ^4.3.0 | Utility-first CSS framework (CSS-first config) |
| **Vite** | ^8.0.16 | Build tool & HMR |
| **@tailwindcss/vite** | ^4.3.0 | Tailwind v4 Vite plugin |
| **Axios** | ^1.1.2 | HTTP client (AJAX) |
| **Google Fonts** | — | Barlow, Barlow Condensed, Roboto Mono |
| **Font Awesome** | 4.7 | Icons |
| **Bootstrap** | 3/4 | Backend layout (legacy) |
| **Slick Carousel** | — | Hero banner slider |
| **jQuery** | — | Backend UI (legacy) |

### Development

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHPUnit** | ^10.0 | Unit & feature testing |
| **Laravel Pint** | ^1.0 | Code style fixer |
| **Laravel Sail** | ^1.18 | Docker dev environment |
| **Spatie Ignition** | ^2.0 | Error page debugger |

---

## 3. Frontend & Tema

### Tema Dark Automotive

Aplikasi menggunakan tema gelap bertema otomotif dengan warna utama merah khas (`#C8102E`).

```css
/* Tailwind v4 CSS-first config (NO tailwind.config.js) */
@import "tailwindcss";

@theme {
    --color-red-primary: #C8102E;
    --color-dark-base: #0F0F12;
    --color-dark-2: #141416;
    --color-dark-3: #1A1A1E;
    --color-steel: #232329;
    --color-text: #E8E8E8;
    --font-display: 'Barlow Condensed', sans-serif;
    --font-mono: 'Roboto Mono', monospace;
}
```

### Animasi CSS

5 keyframe animations didefinisikan di `app.css`:

| Animasi | Fungsi |
|---------|--------|
| `fadeUp` | Muncul perlahan dari bawah (product cards) |
| `slideUp` | Slide naik (section) |
| `float` | Melayang (decorative elements) |
| `shimmer` | Efek loading shimmer |
| `spin-slow` | Loading spinner lambat |

### JavaScript Features (`resources/js/app.js`)

| Fitur | Implementasi |
|-------|--------------|
| **Loading Overlay** | Hilang otomatis setelah halaman load |
| **Button Loading** | Class `.btn-loading` mencegah double-click |
| **Lazy Load Image** | IntersectionObserver, 200px threshold |
| **Scroll Reveal** | Elemen muncul saat scroll (IntersectionObserver) |
| **Toast Notifications** | `window.showToast(msg, type)` — auto dismiss 4 detik |
| **Image Skeleton** | Placeholder shimmer sampai gambar selesai load |

### Layout Pages (52 Blade Files)

| Section | Jumlah View | Halaman |
|---------|-------------|---------|
| Frontend Layout | 1 | `v_layouts/app.blade.php` |
| Backend Layout | 2 | `app.blade.php` + `app-old.blade.php` |
| Frontend Pages | 17 | Beranda, Produk, Cart, Checkout, dll |
| Backend Pages | 31 | CRUD tables, forms, reports, invoices |
| Vendor | 1 | Custom pagination |

---

## 4. Sistem Autentikasi & Role

### Dual-Guard Authentication

Aplikasi menggunakan **satu tabel user** (`user`) dengan **dua guard** berbeda:

```
User Table: id | nama | email | role (0/1/2) | status (0/1) | password
```

| Guard | Driver | Role | Untuk |
|-------|--------|------|-------|
| `admin` | session | 0 = Admin, 1 = SuperAdmin | Backend (`auth:admin` middleware) |
| `web` | session | 2 = Customer | Frontend (`is.customer` middleware) |

### Role & Level Akses

| Level | Role | Akses |
|-------|------|-------|
| **Super Admin** | role=1 | Full akses backend |
| **Admin** | role=0 | Full akses backend (terbatas dari segi kode) |
| **Customer** | role=2 | Frontend: belanja, profil, riwayat |

### Middleware Authentication

| Middleware | Fungsi |
|------------|--------|
| `auth:admin` | Cek login sebagai admin/superadmin untuk backend |
| `is.customer` | Cek login + role=2 untuk frontend customer |
| `guest` | Redirect jika sudah login |
| `throttle:5,1` | Batasi login 5x per menit |

### Alur Login Backend

```
POST /backend/login
  → LoginController@authenticateBackend
  → Validasi email + password
  → Cek guard('admin')->attempt()
  → Cek status user = 1 (aktif)
  → Regenerasi session
  → Redirect ke backend.beranda
```

### Alur Login Customer

```
POST /login (throttle: 5,1)
  → CustomerController@login
  → Validasi email + password
  → Guard('web')->attempt()
  → Cek role = 2 (customer)
  → Regenerasi session
  → Redirect ke /beranda
```

---

## 5. Sistem E-commerce

### Alur Belanja Lengkap

```
Beranda/Produk
    │
    ├── Pilih Produk → Detail Produk
    │
    ├── [Tambah ke Keranjang]
    │       → POST /cart/add/{id}
    │       → Cek stok → Buat/find unpaid order
    │       → Increment qty or create order_item
    │       → Decrement stok
    │
    ├── Keranjang (GET /cart)
    │       → View cart dengan quantity, subtotal
    │       → Update/remove items
    │
    ├── Pilih Pengiriman (GET /select-shipping)
    │       → Hitung total berat dari semua item
    │       → Pilih provinsi/kota/kecamatan
    │       → Hitung ongkir via RajaOngkir API
    │
    ├── Voucher (Opsional)
    │       → Apply kode voucher
    │       → Validasi: tanggal, minimal belanja, batas pakai
    │       → Simpan diskon di session
    │
    ├── Pilih Pembayaran (GET /select-payment)
    │       → Generate Midtrans Snap Token
    │       → Tampilkan halaman pembayaran
    │
    ├── [Bayar via Midtrans Snap]
    │       → Redirect ke Midtrans / Bayar langsung
    │
    ├── Callback / Complete
    │       → Validasi signature Midtrans
    │       → Update status order = paid
    │       → Simpan voucher usage
    │       → Buat notifikasi "Pesanan Baru"
    │
    └── Riwayat Pesanan (GET /history)
            → Lihat semua order (unpaid/paid/Kirim/Selesai)
            → Download invoice
            → Buat retur (jika sudah paid/selesai)
```

### Status Order Flow

```
unpaid → paid → Kirim → Selesai
  │        │                 │
  └─cancel  └─cancel         └─(selesai akhir)
```

### Manajemen Stok

| Aksi | Efek Stok |
|------|-----------|
| Add to cart | `stok -= quantity` |
| Update quantity (naik) | `stok -= selisih` |
| Update quantity (turun) | `stok += selisih` |
| Remove from cart | `stok += quantity` |
| Order cancel | `stok += quantity` (via incrementStock) |
| Order paid/selesai | Stok tetap berkurang (sudah dibeli) |

---

## 6. Payment Gateway — Midtrans

### Konfigurasi

File: `config/midtrans.php`

```php
'server_key'    => env('MIDTRANS_SERVER_KEY'),
'client_key'    => env('MIDTRANS_CLIENT_KEY'),
'is_production' => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN),
```

Mode: **Sandbox** (`MIDTRANS_IS_PRODUCTION=false`)

### Alur Integrasi Midtrans

**1. Generate Snap Token** (`OrderController@selectPayment`)

```php
\Midtrans\Config::$serverKey    = config('midtrans.server_key');
\Midtrans\Config::$isProduction = config('midtrans.is_production');
\Midtrans\Config::$isSanitized  = true;
\Midtrans\Config::$is3ds        = true;

$params = [
    'transaction_details' => [
        'order_id' => $order->id . '-' . time(),
        'gross_amount' => $totalBayar,
    ],
    'customer_details' => [
        'first_name' => $customer->user->nama,
        'email' => $customer->user->email,
    ],
];

$snapToken = \Midtrans\Snap::getSnapToken($params);
```

**2. Frontend**: Snap popup menggunakan `snapToken` yang dikirim ke view.

**3. Callback / Webhook** (`OrderController@callback`)

Midtrans mengirim POST ke `/midtrans/callback` (CSRF excluded).

Validasi signature:
```php
$hashed = hash("sha512", $order_id . $status_code . $gross_amount . $serverKey);
if ($hashed === $signatureKey) { /* valid */ }
```

**4. Redirect Complete** (`OrderController@complete`)

Setelah bayar, user diarahkan ke `/complete?order_id={id}&transaction_status=settlement&...`
Validasi signature dari query parameter.

---

## 7. Shipping API — RajaOngkir

### Provider: Komerce RajaOngkir API

Base URL: `https://rajaongkir.komerce.id/api/v1/destination/`

### Endpoints

| Method | Endpoint | Parameter | Cache | Deskripsi |
|--------|----------|-----------|-------|-----------|
| `GET` | `/destination/province` | — | 24 jam | Daftar provinsi |
| `GET` | `/destination/city/{province_id}` | province_id | 24 jam | Kota per provinsi |
| `GET` | `/destination/district/{city_id}` | city_id | 24 jam | Kecamatan per kota |
| `POST` | `/calculate/domestic-cost` | origin, destination, weight, courier | No | Hitung ongkir |

### Implementasi Caching

```php
$provinces = Cache::remember('provinces', 60 * 24, function () {
    $response = Http::withHeaders([
        'x-api-key' => config('services.rajaongkir.api_key')
    ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');
    return $response->json();
});
```

### Ongkir Checkout Flow

```
1. Pilih Provinsi → GET /provinces (AJAX)
2. Pilih Kota → GET /cities?province_id=X (AJAX)
3. Pilih Kecamatan → GET /districts/{city_id} (AJAX)
4. Pilih Kurir (JNE/TIKI/POS/SiCepat/dll)
5. Hitung Ongkir → POST /cost
6. Pilih layanan → Submit
7. Simpan ke order: kurir, layanan, biaya, estimasi
```

---

## 8. Google OAuth

### Library: Laravel Socialite ^5.26

### Konfigurasi

```php
// config/services.php
'google' => [
    'client_id'     => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect'      => env('GOOGLE_REDIRECT_URI'),
],
```

Redirect URI: `http://127.0.0.1:8000/auth/google/callback`

### Alur Login Google

```
1. User klik "Masuk dengan Google"
2. → GET /auth/redirect → Socialite::driver('google')->redirect()
3. User login di Google, setuju permissions
4. Google redirect ke /auth/google/callback
5. Socialite ambil data user Google
6. Cek email sudah terdaftar?
   - Baru: Buat User (role=2) + Customer (simpan google_id, google_token)
   - Sudah: Login langsung
7. Redirect ke beranda
```

### Data yang Disimpan

| Field | Nilai |
|-------|-------|
| `user.email` | Email dari Google |
| `user.password` | `Hash::make(Str::random(32))` (tidak bisa login manual) |
| `customer.google_id` | Google user ID |
| `customer.google_token` | Google access token |

---

## 9. Sistem Voucher & Diskon

### Tabel `vouchers`

| Kolom | Type | Contoh |
|-------|------|--------|
| `kode` | varchar(50) UNIQUE | `DISKON50`, `GRATIS_ONGKIR` |
| `tipe` | enum('persen','nominal') | Persen atau nominal Rp |
| `nilai` | decimal(12,2) | 50.00 (50%) atau 10000 (Rp 10rb) |
| `min_belanja` | decimal(12,2) | Minimal belanja 50000 |
| `maks_diskon` | decimal(12,2) nullable | Maks diskon 20000 |
| `tanggal_mulai` | date | 2026-06-01 |
| `tanggal_berakhir` | date | 2026-06-30 |
| `batas_pakai` | int | 100 (max penggunaan) |
| `dipakai` | int | Counter otomatis |
| `status` | enum('aktif','nonaktif') | Aktif atau tidak |

### Logic Validasi Voucher

```
isValid($subtotal):
  1. Cek status = aktif
  2. Cek tanggal mulai ≤ sekarang ≤ tanggal berakhir
  3. Cek batas_pakai > dipakai
  4. Cek subtotal ≥ min_belanja
  5. Cek user belum pernah pakai voucher ini (di order non-unpaid)

calculateDiscount($subtotal):
  if tipe == 'persen':
      diskon = subtotal * nilai / 100
      if diskon > maks_diskon → diskon = maks_diskon
  if tipe == 'nominal':
      diskon = min(nilai, subtotal)
  return diskon
```

### Alur Penggunaan Voucher

```
1. Customer masukkan kode → POST /voucher/apply
2. Validasi server-side
3. Simpan ke session: voucher_applied = {kode, diskon, voucher_id}
4. Halaman payment: tampilkan diskon
5. Saat payment callback/complete: simpan ke order + voucher_usage
```

---

## 10. Sistem Retur

### Alur Retur Customer

```
Customer:
  1. Buka riwayat pesanan → Pilih pesanan yang sudah paid/Kirim/Selesai
  2. Klik "Retur" pada item tertentu → GET /retur/create/{orderItemId}
  3. Isi alasan retur + upload foto (opsional) → POST /retur/store
  4. Sistem buat notifikasi untuk admin
  5. Tunggu persetujuan admin

Admin:
  1. Lihat daftar retur di backend (prioritas: pending dulu)
  2. Klik detail → Lihat foto retur, alasan
  3. Set status: disetujui / ditolak / selesai
  4. Tambah catatan admin
  5. Sistem kirim notifikasi ke customer
```

### Status Retur

```
pending → disetujui → selesai
    └──→ ditolak
```

### Validasi Retur

- Hanya item dari order dengan status `paid`, `Kirim`, atau `Selesai`
- Satu item hanya bisa diretur sekali (cek duplicate)
- Foto retur max 2MB, format jpeg/png/jpg
- Alasan retur max 1000 karakter

---

## 11. Sistem Notifikasi

### Model `Notifikasi`

| Kolom | Type | Contoh |
|-------|------|--------|
| `type` | varchar | `stok`, `pesanan`, `retur` |
| `judul` | varchar | "Stok Menipis" |
| `pesan` | text | "Stok produk Kampas Rem tinggal 3" |
| `url` | varchar nullable | `/backend/pesanan/detail/5` |
| `is_read` | boolean | false |

### Trigger Notifikasi

| Event | Type | Dikirim ke |
|-------|------|------------|
| Produk stok ≤ 5 | `stok` | Admin (via dashboard) |
| Pesanan baru (paid) | `pesanan` | Admin |
| Pengiriman diperbarui | `pesanan` | Admin |
| Pesanan selesai | `pesanan` | Admin |
| Pesanan dibatalkan | `pesanan` | Admin |
| Retur baru | `retur` | Admin |
| Status retur berubah | `retur` | Admin & Customer |

### Polling Backend

Backend layout melakukan polling setiap 30 detik:
```javascript
function loadNotifikasi() {
    fetch('/backend/notifikasi')
        .then(r => r.json())
        .then(data => { /* update badge + dropdown */ });
}
setInterval(loadNotifikasi, 30000);
```

---

## 12. Upload & Proses Gambar

### ImageHelper (GD Library)

Aplikasi menggunakan **GD library bawaan PHP** untuk resize gambar (TANPA package Intervention/Image).

```php
ImageHelper::uploadAndResize($file, $directory, $fileName, $width, $height);
```

### Flow Upload

```
1. Validasi: mimes:jpeg,jpg,png,gif, max:1024KB
2. Generate nama file: date('YmdHis') . '_' . uniqid() . '.' . ext
3. Baca gambar asli via GD (imagecreatefromjpeg/png/gif)
4. Resize pertahankan aspect ratio (imagecopyresampled)
5. Simpan ke public_path(storage/img-{jenis}/)
6. Hapus resource GD
```

### Storage Directories

| Folder | Untuk | Ukuran |
|--------|-------|--------|
| `storage/img-user/` | Foto user/admin | 385x400 |
| `storage/img-customer/` | Foto customer | 385x400 |
| `storage/img-produk/` | Foto produk (original) | Original |
| `storage/img-produk/thumb_lg_` | Large thumbnail | 800px width |
| `storage/img-produk/thumb_md_` | Medium thumbnail | 500x519 |
| `storage/img-produk/thumb_sm_` | Small thumbnail | 100x110 |
| `storage/app/public/img-retur/` | Foto retur | Original |

### Storage Symlink

Menggunakan Laravel storage link: `public/storage/` → `storage/app/public/`

---

## 13. Database Schema

### Entity Relationship Diagram (Ringkasan)

```
user ──── customer ──── order ──── order_item ──── produk ──── kategori
 │                                                      │
 │                                                     foto_produk
 │
 └─── voucher_usage ──── voucher

retur ─── order ─── order_item ─── produk ─── customer

notifikasis (standalone)
```

### 14 Tables

| Tabel | Records (est) | Primary Key | Foreign Keys |
|-------|---------------|-------------|--------------|
| `user` | ~10-50 | `id` | — |
| `customer` | ~10-50 | `id` | `user_id` → user |
| `kategori` | ~10-30 | `id` | — |
| `produk` | ~20-100 | `id` | `kategori_id`, `user_id` |
| `foto_produk` | ~20-200 | `id` | `produk_id` (cascade) |
| `order` | ~50-500 | `id` | `customer_id` (cascade), `user_id` |
| `order_item` | ~100-2000 | `id` | `order_id` (cascade), `produk_id` |
| `vouchers` | ~5-20 | `id` | — |
| `voucher_usage` | ~10-100 | `id` | `voucher_id`, `order_id`, `user_id` |
| `retur` | ~5-50 | `id` | `order_id`, `order_item_id`, `customer_id`, `produk_id` |
| `notifikasis` | ~50-500 | `id` | — |
| `password_reset_tokens` | ~0-10 | `email` | — |
| `failed_jobs` | ~0-5 | `id` | — |
| `personal_access_tokens` | ~0-10 | `id` | — |

---

## 14. Struktur Routes

### Total Routes: ~65

### Backend (auth:admin) — 32 routes

```
/backend/
├── /beranda                    → GET    Dashboard
├── /user                       → CRUD (Resource)
├── /kategori                   → CRUD (Resource)
├── /produk                     → CRUD (Resource)
├── /foto-produk/*              → POST/DELETE
├── /customer                   → CRUD (Resource)
├── /voucher                    → CRUD (Resource)
├── /pesanan/*                  → Proses/Selesai/Detail/Update/Invoice
├── /laporan/*                  → Laporan User, Produk, Pesanan
├── /retur/*                    → Admin index/detail/update
└── /notifikasi/*               → AJAX: index/unread/read
```

### Frontend (public) — 13 routes

```
/                               → Redirect ke /beranda
/beranda                        → Homepage
/produk/*                       → Search/Detail/Kategori/All
/auth/*                         → Google OAuth redirect/callback
/provinces, /cities, etc.       → RajaOngkir AJAX
/midtrans/callback              → Midtrans webhook
```

### Frontend (is.customer) — 15 routes

```
/customer/akun/{id}             → Lihat/Ubah profil
/cart/*                         → Add/View/Update/Remove
/select-shipping                → Pilih ongkir
/select-payment                 → Midtrans payment
/complete                       → Payment completion
/history                        → Riwayat order
/invoice/{id}                   → Invoice
/voucher/*                      → Apply/Remove
/retur/*                        → Index/Create/Store
```

---

## 15. Struktur Proyek

```
C:\laravel10\tokosparepart_mobil\
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BerandaController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── KategoriController.php
│   │   │   ├── LoginController.php
│   │   │   ├── MidtransController.php
│   │   │   ├── NotifikasiController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProdukController.php
│   │   │   ├── RajaOngkirController.php
│   │   │   ├── ReturController.php
│   │   │   ├── UserController.php
│   │   │   └── VoucherController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── IsCustomer.php
│   │   │   ├── RedirectIfAuthenticated.php
│   │   │   ├── TrimStrings.php
│   │   │   ├── TrustProxies.php
│   │   │   ├── VerifyCsrfToken.php
│   │   │   └── ... (standard)
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── Customer.php
│   │   ├── FotoProduk.php
│   │   ├── Kategori.php
│   │   ├── Notifikasi.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Produk.php
│   │   ├── Retur.php
│   │   ├── User.php
│   │   ├── Voucher.php
│   │   └── VoucherUsage.php
│   ├── Helpers/
│   │   └── ImageHelper.php
│   └── Providers/...
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cors.php
│   ├── database.php
│   ├── midtrans.php
│   ├── services.php
│   └── session.php
├── database/
│   └── migrations/ (18 files)
├── resources/
│   ├── css/app.css (Tailwind v4)
│   ├── js/app.js
│   ├── views/
│   │   ├── v_layouts/ (frontend + backend)
│   │   ├── v_beranda/
│   │   ├── v_produk/
│   │   ├── v_customer/
│   │   ├── v_order/
│   │   └── backend/
│   │       ├── v_layouts/
│   │       ├── v_login/
│   │       ├── v_beranda/
│   │       ├── v_user/
│   │       ├── v_kategori/
│   │       ├── v_produk/
│   │       ├── v_customer/
│   │       ├── v_voucher/
│   │       ├── v_pesanan/
│   │       └── v_retur/
├── routes/
│   ├── web.php
│   └── api.php
├── public/
│   └── frontend/ (legacy Bootstrap assets)
├── tests/
│   ├── Feature/ (7 files)
│   └── Unit/ (2 files)
└── QA_REPORT.md
```

---

## 16. Daftar Dependencies

### Composer (Production)

| Package | Version | Kegunaan |
|---------|---------|----------|
| `php` | ^8.1 | Runtime |
| `laravel/framework` | ^10.0 | Framework utama |
| `midtrans/midtrans-php` | ^2.6 | Midtrans Snap Payment API |
| `laravel/socialite` | ^5.26 | Google OAuth login |
| `guzzlehttp/guzzle` | ^7.10 | HTTP Client (RajaOngkir) |
| `laravel/sanctum` | ^3.2 | API token auth |
| `doctrine/dbal` | ^3.10 | Schema alterations |
| `laravel/tinker` | ^2.8 | Artisan REPL |

### Composer (Dev)

| Package | Kegunaan |
|---------|----------|
| `phpunit/phpunit` | Testing framework |
| `nunomaduro/collision` | CLI error handling |
| `spatie/laravel-ignition` | Error page debug |
| `laravel/pint` | Code style fixer |
| `mockery/mockery` | Mocking framework |
| `fakerphp/faker` | Fake data generator |
| `laravel/sail` | Docker dev environment |

### NPM

| Package | Versi | Kegunaan |
|---------|-------|----------|
| `tailwindcss` | ^4.3.0 | CSS framework |
| `@tailwindcss/vite` | ^4.3.0 | Vite plugin |
| `vite` | ^8.0.16 | Build tool |
| `laravel-vite-plugin` | ^3.1.0 | Laravel integration |
| `axios` | ^1.1.2 | HTTP client |

### External Services

| Service | Integrasi | Tipe |
|---------|-----------|------|
| **Midtrans** | Snap API (sandbox) | Payment gateway |
| **Komerce RajaOngkir** | REST API | Shipping cost calculator |
| **Google OAuth** | Socialite OAuth 2.0 | Social login |
| **Google Fonts** | CSS @import | Typography |

---

## Lampiran: Fitur Lengkap

### Customer-Facing Features
- ✅ Homepage dengan hero slider & produk unggulan
- ✅ Katalog produk dengan pencarian & filter kategori
- ✅ Detail produk (gambar utama + tambahan, deskripsi, stok, berat)
- ✅ Shopping cart
- ✅ Checkout dengan pilihan ongkir (RajaOngkir)
- ✅ Pembayaran via Midtrans (CC, bank transfer, e-wallet, Indomaret)
- ✅ Voucher diskon (persen & nominal)
- ✅ Riwayat pesanan
- ✅ Invoice
- ✅ Retur barang
- ✅ Google OAuth login
- ✅ Edit profil (foto, alamat lengkap)
- ✅ Dark theme

### Admin Features
- ✅ Dashboard with stats (order hari ini, revenue, produk, notifikasi)
- ✅ CRUD User (Admin & Super Admin)
- ✅ CRUD Kategori
- ✅ CRUD Produk + multiple foto
- ✅ CRUD Customer
- ✅ CRUD Voucher
- ✅ Manajemen Pesanan (Proses, Kirim, Selesai, Cancel)
- ✅ Manajemen Retur (Setuju/Tolak/Selesai)
- ✅ Notifikasi real-time (polling)
- ✅ Laporan PDF (User, Produk, Pesanan)
- ✅ Invoice

### Security Features
- ✅ Dual authentication guard (admin + customer)
- ✅ CSRF protection (exclude midtrans callback)
- ✅ Password hashing (bcrypt)
- ✅ Input validation on all forms
- ✅ Image type validation
- ✅ Rate limiting on login (5x/menit)
- ✅ Strip_tags on rich text output
- ✅ Random password for OAuth users

---

*Laporan teknologi digenerate pada 3 Juni 2026 berdasarkan source code analysis.*
