# Katalon Test - Tokosparepart Mobil

## Setup Awal

### 1. Install Katalon Studio
- Download dari: https://katalon.com/download
- Install dan buka aplikasi

### 2. Buka Project di Katalon
- Buka Katalon Studio
- File > Open Project
- Pilih folder: `katalon-test/`

### 3. Capture Object Repository
Semua test case menggunakan Object Repository (`Object Repository/README.txt`).
Gunakan **Spy Web** (icon spy di toolbar Katalon):
1. Buka browser target (pastikan Laravel running)
2. Klik Spy Web, masukkan URL
3. Arahkan kursor ke elemen yang ingin di-capture
4. Beri nama sesuai panduan di `Object Repository/README.txt`

### 4. Jalankan Laravel
```bash
# Di folder project Laravel
php artisan serve
```
Akses: http://localhost:8000

### 5. Sesuaikan Profile
Buka `Profiles/default.glbl` dan isi:
- `APP_URL`: URL Laravel (default: http://localhost:8000)
- `ADMIN_EMAIL`: email admin
- `ADMIN_PASSWORD`: password admin

### 6. Jalankan Test
- Di Katalon Studio: klik **Run** pada Test Case atau Test Suite
- Atau via CLI:
```bash
katalon -noSplash -runMode=console -projectPath="katalon-test/" -testSuitePath="Test Suites/TS_FullRegression" -browserType="Chrome" -executionProfile="default"
```

## Test Modules

| Module | Folder | Test Cases |
|--------|--------|------------|
| Frontend | `Test Cases/Frontend/` | Home, Product List, Detail, Category |
| Backend | `Test Cases/Backend/` | Login, Dashboard, CRUD Kategori/Produk, Orders, Customers |
| Cart | `Test Cases/Cart/` | Add to Cart, View Cart, Checkout, Order History |

## Test Suites

| Suite | Isi |
|-------|-----|
| `TS_SmokeTest_Frontend` | Semua test frontend |
| `TS_SmokeTest_Backend` | Semua test backend admin |
| `TS_FullRegression` | Semua test (frontend + backend + cart) |
