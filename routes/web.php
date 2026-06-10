<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Http;

// ================= ROOT =================
Route::get('/', [BerandaController::class, 'redirectToBeranda']);

// ================= HEALTHCHECK =================
Route::get('/healthcheck', [BerandaController::class, 'healthcheck']);

// ================= BACKEND LOGIN =================
Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->middleware('throttle:5,1');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout');

// Backend Password Reset
Route::get('backend/password/reset', [PasswordResetController::class, 'showForgotBackend'])->name('backend.password.request');
Route::post('backend/password/email', [PasswordResetController::class, 'sendResetLinkBackend'])->name('backend.password.email');
Route::get('backend/password/reset/{token}', [PasswordResetController::class, 'showResetFormBackend'])->name('backend.password.reset');
Route::post('backend/password/reset', [PasswordResetController::class, 'reset'])->name('backend.password.update');

// ================= BACKEND =================
Route::middleware('auth:admin')->prefix('backend')->group(function () {

    // Beranda
    Route::get('/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda');

    // User
    Route::resource('/user', UserController::class, ['as' => 'backend']);
    Route::get('/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser');
    Route::post('/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser');

    // Kategori
    Route::resource('/kategori', KategoriController::class, ['as' => 'backend']);

    // Produk
    Route::resource('/produk', ProdukController::class, ['as' => 'backend']);
    Route::post('/foto-produk/store', [ProdukController::class, 'storeFoto'])->name('backend.foto_produk.store');
    Route::delete('/foto-produk/{id}', [ProdukController::class, 'destroyFoto'])->name('backend.foto_produk.destroy');
    Route::get('/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk');
    Route::post('/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk');

    // Customer
    Route::resource('/customer', CustomerController::class, ['as' => 'backend']);

    // Voucher
    Route::resource('/voucher', VoucherController::class, ['as' => 'backend']);

    // ✅ Pesanan
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/proses', [OrderController::class, 'statusProses'])->name('proses');
        Route::get('/selesai', [OrderController::class, 'statusSelesai'])->name('selesai');
        Route::get('/detail/{id}', [OrderController::class, 'statusDetail'])->name('detail');
        Route::put('/update/{id}', [OrderController::class, 'statusUpdate'])->name('update');
        Route::get('/invoice/{id}', [OrderController::class, 'invoiceBackend'])->name('invoice');
    });

    // ✅ Laporan Pesanan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/proses', [OrderController::class, 'formOrderProses'])->name('proses');
        Route::post('/proses/cetak', [OrderController::class, 'cetakOrderProses'])->name('proses.cetak');
        Route::get('/selesai', [OrderController::class, 'formOrderSelesai'])->name('selesai');
        Route::post('/selesai/cetak', [OrderController::class, 'cetakOrderSelesai'])->name('selesai.cetak');
    });

    // ✅ Retur
    Route::prefix('retur')->name('retur.')->group(function () {
        Route::get('/', [ReturController::class, 'adminIndex'])->name('admin.index');
        Route::get('/detail/{id}', [ReturController::class, 'adminDetail'])->name('admin.detail');
        Route::put('/update/{id}', [ReturController::class, 'adminUpdate'])->name('admin.update');
    });

    // Notifikasi
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/unread-count', [NotifikasiController::class, 'unreadCount'])->name('unread');
        Route::put('/{id}/read', [NotifikasiController::class, 'markRead'])->name('read');
        Route::put('/read-all', [NotifikasiController::class, 'markAllRead'])->name('readAll');
    });

});

// ================= FRONTEND =================
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
Route::get('/produk/detail/{id}', [ProdukController::class, 'detail'])->name('produk.detail');
Route::get('/produk/kategori/{id}', [ProdukController::class, 'produkKategori'])->name('produk.kategori');
Route::get('/produk/all', [ProdukController::class, 'produkAll'])->name('produk.all');

// ================= AUTH CUSTOMER =================
Route::get('/login', [CustomerController::class, 'showLoginForm'])->name('customer.login');
Route::post('/login', [CustomerController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [CustomerController::class, 'showRegisterForm'])->name('customer.register');
Route::post('/register', [CustomerController::class, 'register'])->middleware('throttle:3,1');

// Customer Password Reset
Route::get('/password/reset', [PasswordResetController::class, 'showForgotCustomer'])->name('customer.password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkCustomer'])->name('customer.password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('customer.password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('customer.password.update');

// ================= AUTH GOOGLE =================
Route::get('/auth/redirect', [CustomerController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/google/callback', [CustomerController::class, 'callback'])->name('auth.callback');
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

// ================= ONGKIR API =================
Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
Route::get('/cities', [RajaOngkirController::class, 'getCities']);
Route::get('/districts/{city_id}', [RajaOngkirController::class, 'getDistricts']);
Route::post('/cost', [RajaOngkirController::class, 'getCost']);

// ================= MIDTRANS CALLBACK =================
Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

// ================= CUSTOMER =================
Route::middleware('is.customer')->group(function () {

    // Akun
    Route::get('/customer/akun/{id}', [CustomerController::class, 'akun'])->name('customer.akun');
    Route::put('/customer/updateakun/{id}', [CustomerController::class, 'updateAkun'])->name('customer.updateakun');

    // Keranjang
    Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('order.addToCart');
    Route::get('/cart', [OrderController::class, 'viewCart'])->name('order.cart');
    Route::post('/cart/update/{id}', [OrderController::class, 'updateCart'])->name('order.updateCart');
    Route::post('/cart/remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');

    // Pengiriman
    Route::get('/select-shipping', [OrderController::class, 'selectShipping'])->name('order.selectShipping');
    Route::post('/updateongkir', [OrderController::class, 'updateongkir'])->name('order.selectShippingStore');

    // Pembayaran
    Route::get('/select-payment', [OrderController::class, 'selectPayment'])->name('order.selectpayment');
    Route::get('/complete', [OrderController::class, 'complete'])->name('order.complete');

    // Riwayat & Invoice
    Route::get('/history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/invoice/{id}', [OrderController::class, 'invoiceFrontend'])->name('order.invoice');

    // Voucher
    Route::post('/voucher/apply', [VoucherController::class, 'apply'])->name('voucher.apply');
    Route::post('/voucher/remove', [VoucherController::class, 'remove'])->name('voucher.remove');

    // Retur
    Route::get('/retur', [ReturController::class, 'index'])->name('order.retur.index');
    Route::get('/retur/create/{orderItemId}', [ReturController::class, 'create'])->name('order.retur.create');
    Route::post('/retur/store', [ReturController::class, 'store'])->name('order.retur.store');

});