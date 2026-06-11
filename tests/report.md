# Laporan Hasil Test — Tokosparepart Mobil

**Tanggal:** 9 Juni 2026  
**Framework:** Pest 2.36.1  
**Lingkungan:** Laravel 10 + Tailwind CSS v4 + Vite  

---

## Ringkasan

| Status   | Jumlah |
|----------|--------|
| ✅ Pass  | 39     |
| ❌ Fail  | 0      |
| **Total** | **39 tests (64 assertions)** |

**Durasi:** 2.80s

---

## Hasil per Test Suite

|------|--------|
| Tests\Unit\ExampleTest — that true is true | ✅ |
| Tests\Unit\ModelTest — produk model has belongs to kategori relation | ✅ |
| Tests\Unit\ModelTest — produk model uses correct table | ✅ |
| Tests\Unit\ModelTest — kategori model uses correct table | ✅ |
| Tests\Unit\ModelTest — kategori model has no timestamps | ✅ |
| Tests\Unit\ModelTest — order model has relations | ✅ |
| Tests\Unit\ModelTest — order model uses correct table | ✅ |
| Tests\Unit\ModelTest — order item model has relations | ✅ |
| Tests\Unit\ModelTest — order item model uses correct table | ✅ |
| Tests\Unit\ModelTest — customer model uses correct table | ✅ |
| Tests\Unit\ModelTest — customer model has relation | ✅ |
| Tests\Unit\ModelTest — user model uses correct table | ✅ |
| Tests\Unit\ModelTest — foto produk model exists | ✅ |

### Feature Tests — API

| Test | Status |
|------|--------|
| provinces endpoint returns json | ✅ |
| cities endpoint returns json | ✅ |
| districts endpoint returns json | ✅ |

### Feature Tests — Backend Auth

| Test | Status |
|------|--------|
| admin login page can be rendered | ✅ |
| backend beranda redirects to login when unauthenticated | ✅ |
| admin can login with valid credentials | ✅ |
| admin cannot login with invalid password | ✅ |
| inactive admin cannot login | ✅ |
| admin can logout | ✅ |

### Feature Tests — Backend CRUD

| Test | Status |
|------|--------|
| admin can access dashboard | ✅ |
| admin can view users page | ✅ |
| admin can view categories page | ✅ |
| admin can create category | ✅ |
| admin can update category | ✅ |
| admin can delete category | ✅ |
| admin can view products page | ✅ |
| admin can view customers page | ✅ |
| admin can access orders pages | ✅ |

### Feature Tests — Frontend

| Test | Status |
|------|--------|
| home page redirects to beranda | ✅ |
| beranda page returns 200 | ✅ |
| all products page returns 200 | ✅ |
| product detail displays product | ✅ |
| product detail with invalid id returns 404 | ✅ |
| product by category displays products | ✅ |
| product by category with invalid id returns 200 empty | ✅ |

### Feature Tests — Example

| Test | Status |
|------|--------|
| the application returns a successful response | ✅ |

---

## Perbaikan yang Dilakukan

### 1. `tests/Feature/ApiTest.php:47` — districts endpoint

**Sebelum:**
```php
$response = $this->get('/districts?city_id=1');
```

**Sesudah:**
```php
$response = $this->get('/districts/1');
```

**Penyebab:** Route didefinisikan sebagai `Route::get('/districts/{city_id}', ...)` (parameter URL), tapi test mengirim `city_id` sebagai query parameter.

### 2. `tests/Feature/BackendAuthTest.php:40` — admin login guard mismatch

**Sebelum:**
```php
$this->assertAuthenticated();
```

**Sesudah:**
```php
$this->assertAuthenticated('admin');
```

**Penyebab:** Backend login menggunakan guard `admin`, tapi `assertAuthenticated()` tanpa argumen memeriksa guard `web` (default), sehingga selalu gagal meskipun login berhasil.

---
