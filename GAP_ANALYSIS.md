# Gap Analysis — Tokosparepart Mobil

**Apa Saja yang Kurang dari Aplikasi Ini?**

---

## Ringkasan

| Kategori | Jumlah Kekurangan |
|----------|------------------|
| **A. Fitur E-commerce** | 15 item |
| **B. Fitur Admin** | 11 item |
| **C. Infrastruktur** | 10 item |
| **D. Code Quality** | 9 item |
| **E. Security Hardening** | 16 item |
| **F. UX/UI** | 11 item |
| **G. SEO & Marketing** | 11 item |
| **H. Maintenance & Operasi** | 12 item |
| **TOTAL** | **95 item** |

---

## A. Fitur E-commerce yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **A1** | **Varian Produk** — Tidak ada field untuk ukuran/warna/tipe. Sparepart butuh varian (misal: kampas rem untuk Mazda 2 vs Mazda 3) | Pelanggan bingung, katalog terbatas | 🔴 HIGH |
| **A2** | **Review & Rating** — Tidak ada tabel reviews, bintang, atau upload foto review | Tidak ada social proof, konversi turun | 🔴 HIGH |
| **A3** | **Wishlist** — Tidak ada tombol simpan produk favorit | Pelanggan tidak bisa menyimpan produk untuk dibeli nanti | 🔴 HIGH |
| **A4** | **Guest Checkout** — Customer HARUS login untuk belanja. Tidak bisa checkout tanpa register | Tingkatkan bounce rate, pelanggan pergi | 🔴 HIGH |
| **A5** | **Pembatalan Order oleh Customer** — Tidak ada route `order/cancel/{id}`. Customer tidak bisa batalkan pesanan sendiri | Harus hubungi admin | 🟠 MEDIUM |
| **A6** | **COD (Cash on Delivery)** — Footer mengiklankan COD tapi tidak ada implementasi logika COD di payment flow | Iklan palsu | 🔴 HIGH |
| **A7** | **Invoice PDF** — Invoice hanya tampilan web, tidak bisa download PDF | Tidak profesional | 🟠 MEDIUM |
| **A8** | **Related / Cross-sell Products** — Halaman detail produk tidak menampilkan "Produk Terkait" atau "Yang Sering Dibeli Bersama" | Potensi upsell hilang | 🟠 MEDIUM |
| **A9** | **Notifikasi Stok untuk Customer** — Tidak ada tombol "Beritahu Saya Saat Stok Tersedia" | Kehilangan leads | 🟠 MEDIUM |
| **A10** | **Tracking Pengiriman Terintegrasi** — Field `noresi` ada tapi tidak terintegrasi dengan API JNE/TIKI/SiCepat untuk auto-tracking | Customer tidak bisa cek resi otomatis | 🟠 MEDIUM |
| **A11** | **Reorder / Beli Lagi** — Tidak ada tombol "Beli Lagi" di riwayat pesanan | Repeat purchase tidak difasilitasi | 🟡 LOW |
| **A12** | **Harga Grosir / Tiered Pricing** — Hanya 1 harga per produk. Tidak ada harga khusus untuk quantity banyak | Tidak support bisnis ke bengkel | 🟠 MEDIUM |
| **A13** | **Bandingkan Produk** — Tidak ada fitur perbandingan produk | Pelanggan sulit membandingkan spesifikasi | 🟡 LOW |
| **A14** | **Ambil di Toko (Pickup)** — Tidak ada opsi ambil barang di toko | Kurang fleksibel | 🟡 LOW |
| **A15** | **Multi Mata Uang** — Semua harga hardcoded IDR | Tidak support ekspansi | 🟡 LOW |

---

## B. Fitur Admin yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **B1** | **Dashboard Analytics** — Dashboard hanya dekoratif. Tidak ada: grafik penjualan, produk terlaris, stok menipis, order baru | Admin buta kondisi bisnis | 🔴 HIGH |
| **B2** | **Import/Export CSV/Excel** — Tidak bisa import produk massal atau export data customer | Operasional manual & lambat | 🔴 HIGH |
| **B3** | **Email Notifikasi ke Customer** — Saat status order berubah (Kirim/Selesai), customer tidak dapat email | Komunikasi kurang | 🔴 HIGH |
| **B4** | **Activity Log / Audit Trail** — Tidak ada catatan siapa yang create/update/delete apa dan kapan | Tidak ada akuntabilitas | 🔴 HIGH |
| **B5** | **Buat Order Manual oleh Admin** — Admin tidak bisa buatkan order untuk customer (mis: order via telepon) | Proses manual di luar sistem | 🟠 MEDIUM |
| **B6** | **Refund Management** — Retur cuma sampai approve, tidak ada workflow pengembalian dana | Retur tidak selesai | 🔴 HIGH |
| **B7** | **Manajemen Ongkir Custom** — Tidak bisa setting ongkir fixed atau free shipping threshold | Tergantung 100% ke API RajaOngkir | 🟠 MEDIUM |
| **B8** | **Manajemen Banner Promo** — Banner di homepage hardcoded di Blade, tidak bisa diubah dari admin | Marketing terbatas | 🟠 MEDIUM |
| **B9** | **Laporan Penggunaan Voucher** — Tidak ada report voucher: siapa pakai, total diskon, dll | Tidak bisa ukur efektivitas promo | 🟠 MEDIUM |
| **B10** | **Manajemen Pembayaran** — Metode bayar (BCA, Mandiri, QRIS) hardcoded di footer. Tidak bisa diatur dari admin | Tidak fleksibel | 🟡 LOW |
| **B11** | **Role & Permission Granular** — Hanya 2 level (admin/superadmin). Tidak bisa atur izin per fitur (misal: staff gudang hanya lihat produk) | Risiko keamanan internal | 🟠 MEDIUM |

---

## C. Infrastruktur yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **C1** | **Queue System** — `QUEUE_CONNECTION=sync`. Semua proses jalan synchronous. Tidak ada Job class | Midtrans callback & email akan lambat | 🔴 HIGH |
| **C2** | **Scheduled Tasks / Cron** — Tidak ada jadwal untuk: hapus cart kadaluarsa, cancel order unpaid, bersihkan session | Sampah data menumpuk | 🟠 MEDIUM |
| **C3** | **Event-Driven Architecture** — Tidak ada Events/Listeners. Semua panggilan method langsung | Kode sulit diperluas | 🟠 MEDIUM |
| **C4** | **Mail Classes** — Folder `app/Mail/` kosong. Tidak ada Mailable | Email tidak bisa dikirim | 🔴 HIGH |
| **C5** | **Notification Classes** — Tidak ada Laravel Notification class. Hanya pakai model Notifikasi manual | Tidak bisa kirim email/SMS notif | 🟠 MEDIUM |
| **C6** | **Redis / Advanced Caching** — Cuma pakai file cache. Tidak ada Redis | Performance turun di skala besar | 🟠 MEDIUM |
| **C7** | **Broadcasting / WebSockets** — BroadcastServiceProvider di-comment. Notifikasi hanya polling 30 detik | Tidak real-time | 🟡 LOW |
| **C8** | **Logging Strategy** — Stack log cuma `single` file. Tidak ada rotasi, alert, atau structured logging | Debugging sulit | 🟠 MEDIUM |
| **C9** | **Monitoring / Health Check** — Tidak ada health check endpoint, Telescope, atau Horizon | Tidak bisa monitor kesehatan app | 🟡 LOW |
| **C10** | **API Rate Limiting (RajaOngkir)** — Endpoint rajaongkir publik tanpa throttle — API key bisa bocor/overuse | Biaya API membengkak | 🔴 HIGH |

---

## D. Code Quality yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **D1** | **Test Coverage Sangat Rendah** — 39 tests (37 passing). Tidak ada test untuk: voucher logic, retur flow, Midtrans callback, cart, checkout complete, RajaOngkir, dll | Bug tidak terdeteksi | 🔴 HIGH |
| **D2** | **Tidak ada Form Request** — Semua validasi inline di controller. Tidak pakai Form Request classes | Kode sulit di-maintain | 🟠 MEDIUM |
| **D3** | **Tidak ada Factory & Seeder** — Tidak ada factory untuk Produk/Kategori/Order/Voucher. DatabaseSeeder default Laravel | Development manual & lambat | 🟠 MEDIUM |
| **D4** | **No Documentation** — README.md masih default Laravel. Tidak ada dokumentasi API, deployment, atau arsitektur | Developer baru kesulitan | 🟠 MEDIUM |
| **D5** | **Validasi Kurang Ketat** — `harga`, `berat`, `stok` divalidasi cuma `required`, bukan `numeric` | Data kotor bisa masuk | 🟠 MEDIUM |
| **D6** | **Tidak ada PHPDoc** — Banyak method controller tidak punya dokumentasi PHPDoc | Sulit dipahami | 🟡 LOW |
| **D7** | **Tidak ada API Documentation** — Tidak ada Scribe/Swagger/OpenAPI | Developer sulit integrasi | 🟡 LOW |
| **D8** | **Kode Tidak Konsisten** — Indentasi campur, style tidak seragam antar file | Sulit dibaca | 🟡 LOW |
| **D9** | **Error Handling Minim** — `Exceptions/Handler.php` kosong, tidak ada custom rendering | User experience jelek saat error | 🟠 MEDIUM |

---

## E. Security Hardening yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **E1** | **Payment IDOR (C1)** — `OrderController::complete()` tidak cek kepemilikan order | 🚨 **GRATISAN BARANG** | 🔴 CRITICAL |
| **E2** | **Profile IDOR (C2)** — `CustomerController::updateAkun()` tidak verifikasi kepemilikan | Akun orang bisa diubah | 🔴 CRITICAL |
| **E3** | **APP_DEBUG=true (C3)** — Debug mode nyala | Stack trace + env bocor | 🔴 CRITICAL |
| **E4** | **Sanctum Middleware Dinonaktifkan** — `EnsureFrontendRequestsAreStateful` di-comment di Kernel | API routes tidak aman | 🟠 MEDIUM |
| **E5** | **No Authorization Policies** — `AuthServiceProvider` punya `$policies = []` kosong. Tidak ada Gate/Policy. Kontrol akses hanya pakai middleware sederhana | Tidak ada permission granular | 🟠 MEDIUM |
| **E6** | **No Security Headers** — Tidak ada: `X-Content-Type-Options`, `X-Frame-Options`, `Strict-Transport-Security`, `Content-Security-Policy` | Rentan clickjacking, XSS, dll | 🟠 MEDIUM |
| **E7** | **No Two-Factor Authentication** — Tidak ada 2FA untuk admin | Admin akun bisa diambil alih | 🔴 HIGH |
| **E8** | **No Password Confirmation** — Aksi sensitif (update order, approve retur) tidak perlu konfirmasi password | Abuse by unauthorized user | 🟠 MEDIUM |
| **E9** | **No HTTPS Enforcement** — Session cookie tidak dipaksa secure. `APP_URL` default HTTP | Data bisa diintersep (MITM) | 🔴 HIGH |
| **E10** | **CORS Allow All Origins** — `config/cors.php` set `allowed_origins = ['*']` | Domain lain bisa akses API | 🟠 MEDIUM |
| **E11** | **Rate Limiting Backend Login** — Admin login (`/backend/login`) tidak ada throttle! | Bruteforce admin unlimited | 🔴 HIGH |
| **E12** | **Session Tidak Di-encrypt** — `config/session.php` encrypt=false | Data session terbaca dari file | 🟠 MEDIUM |
| **E13** | **No CSRF on API Routes** — API routes tanpa middleware CSRF (tapi juga tanpa auth) | API bisa dieksploitasi | 🟠 MEDIUM |
| **E14** | **Nama File Upload Predictable** — Pakai `uniqid()` + timestamp — bisa ditebak | File upload bisa diprediksi | 🟡 LOW |
| **E15** | **No MIME Validation** — Validasi file cuma `mimes:` (extension), bukan `mimetypes:` (content) | File palsu bisa diupload | 🟠 MEDIUM |
| **E16** | **Logout Admin Logout Customer Juga** — `LoginController::logoutBackend()` panggil `Auth::guard('web')->logout()` | Session customer kena efek samping | 🟠 MEDIUM |

---

## F. UX/UI yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **F1** | **Breadcrumb Navigation** — Tidak ada breadcrumb di halaman produk/detail/checkout | User mudah tersesat | 🟠 MEDIUM |
| **F2** | **Error Pages Kustom** — Tidak ada halaman 403, 404, 500, 503 dengan tema otomotif | Tampilan tidak konsisten saat error | 🟠 MEDIUM |
| **F3** | **Search Autocomplete** — Search cuma input biasa, tidak ada saran produk saat mengetik | User experience jelek | 🟠 MEDIUM |
| **F4** | **Product Filtering** — Search cuma LIKE. Tidak ada filter: range harga, stok tersedia, urutkan, brand | Pelanggan susah cari produk | 🔴 HIGH |
| **F5** | **Step Progress Checkout** — Tidak ada indikator langkah (Cart → Shipping → Payment → Complete) | User bingung di tahap mana | 🟠 MEDIUM |
| **F6** | **Empty State Illustrasi** — Halaman kosong (cart kosong, search no result) cuma teks, tanpa ilustrasi | Kurang menarik | 🟡 LOW |
| **F7** | **Loading State AJAX** — Tidak ada spinner/loading saat Midtrans token di-generate | User klik berulang | 🟠 MEDIUM |
| **F8** | **Accessibility** — Tidak ada ARIA labels, focus management, keyboard navigation, screen reader support | Tidak accessible untuk difabel | 🟡 LOW |
| **F9** | **Mobile Checkout UX** — Form checkout panjang tanpa optimasi mobile | Tingkatkan bounce rate mobile | 🟠 MEDIUM |
| **F10** | **Toast vs Static Alert** — Semua flash message adalah alert bar statis, bukan toast auto-dismiss | User harus klik tutup manual | 🟡 LOW |
| **F11** | **Dark/Light Theme Tidak Sempurna** — Tema toggle ada tapi beberapa elemen mungkin tidak ter-cover | Tampilan aneh di light mode | 🟡 LOW |

---

## G. SEO & Marketing yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **G1** | **Sitemap XML** — Tidak ada `sitemap.xml` | Google tidak bisa index semua halaman | 🔴 HIGH |
| **G2** | **Meta Tags Per Halaman** — Tidak ada meta description, OG tags, Twitter Cards | Share ke sosial media jelek | 🔴 HIGH |
| **G3** | **Structured Data (Schema.org)** — Tidak ada JSON-LD Product, Organization, LocalBusiness markup | Tidak tampil rich results di Google | 🔴 HIGH |
| **G4** | **Google Analytics / Tag Manager** — Tidak ada tracking code | Tidak bisa ukur traffic & konversi | 🔴 HIGH |
| **G5** | **Newsletter Tidak Fungsional** — Form newsletter di footer hanya HTML hiasan, tidak ada backend processing | Lead hilang | 🟠 MEDIUM |
| **G6** | **Social Media Pixel** — Tidak ada Facebook Pixel / TikTok Pixel untuk retargeting ads | Iklan tidak optimal | 🟠 MEDIUM |
| **G7** | **Abandoned Cart Recovery** — Tidak ada mekanisme kirim email untuk cart yang ditinggalkan | Revenue hilang | 🔴 HIGH |
| **G8** | **Blog / Content Marketing** — Tidak ada blog, artikel, atau halaman SEO | Tidak ada organic traffic dari konten | 🔴 HIGH |
| **G9** | **Recently Viewed Products** — Tidak ada fitur "Produk yang Baru Dilihat" | Engagement turun | 🟡 LOW |
| **G10** | **Promo Banner Management** — Banner homepage hardcoded di Blade, admin tidak bisa ganti | Marketing lambat | 🟠 MEDIUM |
| **G11** | **Canonical URL** — Tidak ada tag canonical | Duplicate content issue | 🟡 LOW |

---

## H. Maintenance & Operasi yang Kurang

| # | Fitur | Dampak | Severity |
|---|-------|--------|----------|
| **H1** | **Backup Strategy** — Tidak ada backup database & file otomatis | Data hilang total jika server crash | 🔴 HIGH |
| **H2** | **Deployment Script** — Tidak ada script deploy, CI/CD, atau GitHub Actions | Deployment manual & riskan error | 🟠 MEDIUM |
| **H3** | **Environment Validation** — Tidak ada pengecekan env vars wajib saat boot | App bisa jalan dengan config salah | 🟠 MEDIUM |
| **H4** | **Graceful Degradation (API)** — Panggilan RajaOngkir & Midtrans tanpa timeout, retry, atau fallback | App error total jika API down | 🔴 HIGH |
| **H5** | **Database Indexes** — Tidak ada explicit indexes di kolom yang sering di-query (`order.status`, `produk.kategori_id`, dll) | Performa query menurun | 🟠 MEDIUM |
| **H6** | **Debug Bar** — Tidak ada `laravel-debugbar` untuk development | Debugging development sulit | 🟡 LOW |
| **H7** | **Health Check Endpoint** — Tidak ada `/health` atau `/ping` | Load balancer / monitoring tidak bisa cek | 🟡 LOW |
| **H8** | **Pending Migration Check** — Tidak ada pengecekan migration pending saat boot | Lupa migrate = error | 🟡 LOW |
| **H9** | **Feature Flags** — Tidak ada fitur toggle tanpa deploy | Risiko deploy tinggi | 🟡 LOW |
| **H10** | **Vendor Cleanup** — Ada folder `public/frontend/eshop/` duplicate dengan template asli (3 HTML, 1 ZIP) — pemborosan storage | Storage terbuang | 🟡 LOW |
| **H11** | **Log Rotation** — Log hanya `single` file (satu file membesar terus) | Hardisk bisa penuh | 🟠 MEDIUM |
| **H12** | **No API Versioning** — API routes tidak pakai prefix version (`api/v1/...`) | Breaking change sulit di-handle | 🟡 LOW |

---

## Prioritas Perbaikan

### 🔴 Critical (Harus Sekarang)

| # | Item | Perbaikan |
|---|------|-----------|
| 1 | **E1 (C1)** — Payment IDOR | Tambah `where('customer_id', $customer->id)` di `Order::find()` |
| 2 | **E2 (C2)** — Profile IDOR | Tambah ownership check di `updateAkun()` |
| 3 | **E3 (C3)** — `APP_DEBUG=true` | Set `false` di production |
| 4 | **E9** — No HTTPS | Force HTTPS via `AppServiceProvider` + `SESSION_SECURE_COOKIE=true` |
| 5 | **E11** — No rate limit backend login | Tambah throttle middleware di `backend/login` |
| 6 | **G4** — No Analytics | Pasang Google Analytics / Tag Manager |
| 7 | **G8** — No Blog | Buat blog module untuk SEO content |

### 🟠 High (Minggu Ini)

| Prioritaskan | Item |
|-------------|------|
| A1 — Varian produk | D2 — Factory & Seeder |
| A2 — Review & Rating | D5 — Validasi lebih ketat |
| A4 — Guest checkout | G1 — Sitemap XML |
| B1 — Dashboard analytics | G2 — Meta tags |
| B3 — Email notif customer | G3 — Schema.org structured data |
| B4 — Audit trail | G7 — Abandoned cart recovery |
| B6 — Refund management | H1 — Backup strategy |
| C1 — Queue system | H4 — Graceful degradation |
| C10 — Rate limit RajaOngkir | F4 — Product filtering |

### 🟡 Medium & Low (Bulan Ini)
Sisanya bisa dikerjakan bertahap sesuai prioritas bisnis.

---

## Kesimpulan

**Aplikasi ini punya fondasi yang cukup baik** — fitur e-commerce inti (cart, checkout, payment, shipping) sudah berfungsi. Tapi ada **95 celah/ kekurangan** yang perlu diperbaiki sebelum siap production.

### 3 Hal Paling Kritis:
1. **🔴 Payment IDOR** — Customer bisa dapat barang gratis (fix: 1 baris kode)
2. **🔴 Security hardening** — Debug mode, HTTPS, rate limiting, CSRF
3. **🔴 SEO & Marketing** — Tanpa Google Analytics, sitemap, dan structured data, aplikasi tidak akan ditemukan di Google

### Perbandingan dengan E-commerce Siap Production:

| Aspek | Saat Ini | Target |
|-------|----------|--------|
| **Fitur E-commerce** | 50% | 85%+ |
| **Admin Tools** | 40% | 80%+ |
| **Security** | 55% | 95%+ (setelah critical fixed) |
| **SEO & Marketing** | 10% | 80%+ |
| **Infrastructure** | 30% | 75%+ |
| **Code Quality** | 35% | 70%+ |
| **UX/UI** | 55% | 80%+ |
| **Maintenance** | 20% | 70%+ |

**Estimated effort to close all gaps:** 3-6 bulan untuk 1-2 full-stack developer.
**Estimated effort for production-ready (critical + high only):** 2-4 minggu.
