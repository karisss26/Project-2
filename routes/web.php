<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KatalogController;

// =========================================================
// 1. RUTE PUBLIK
// =========================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/katalog', [KatalogController::class, 'index'])->name('dashboard.katalog');


// =========================================================
// 2. RUTE GUEST (Khusus yang BELUM login)
// =========================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});


// =========================================================
// 3. RUTE TERPROTEKSI (Wajib Login)
// =========================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profil-saya', [DashboardController::class, 'profil'])->name('profil.umum');
    Route::post('/profil-saya/update', [DashboardController::class, 'updateProfil'])->name('profil.umum.update');

    // --- GRUP PELANGGAN ---
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pelanggan'])->name('dashboard.pelanggan');
        Route::get('/data-hewan', [DashboardController::class, 'dataHewan'])->name('pelanggan.hewan');

        Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CheckoutController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/remove', [CheckoutController::class, 'removeFromCart'])->name('cart.remove');

        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

        Route::post('/dashboard/reservasi/{id}/batal', [DashboardController::class, 'batalkan'])->name('reservasi.batal');
        Route::view('/layanan-produk', 'dashboard.layanan')->name('pelanggan.layanan');
        Route::post('/reservasi/proses', [CheckoutController::class, 'prosesReservasi'])->name('reservasi.proses');
        Route::get('/reservasi/bayar/{id}', [CheckoutController::class, 'bayarDp'])->name('reservasi.bayar');
        Route::post('/reservasi/bayar/{id}/upload', [CheckoutController::class, 'uploadBuktiDp'])->name('reservasi.upload');
    });

    // --- RUTE DOKTER ---
    Route::middleware(['role:dokter'])->group(function () {
        Route::get('/dokter/dashboard', [DashboardController::class, 'dokter'])->name('dashboard.dokter');
    });

    // --- RUTE STAFF ---
    Route::middleware(['role:staff'])->group(function () {
        Route::get('/staff/dashboard', [DashboardController::class, 'staff'])->name('dashboard.staff');
    });

    // --- RUTE ADMIN & KASIR (Dinamis) ---
    Route::middleware(['role:admin,kasir'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');

        Route::post('/admin/reservasi/setujui/{id}', [DashboardController::class, 'setujuiReservasi'])->name('admin.reservasi.setujui');
    Route::post('/admin/reservasi/tolak/{id}', [DashboardController::class, 'tolakReservasi'])->name('admin.reservasi.tolak');

        // 1. Kelola Akun User (CRUD & Unblock)
        Route::prefix('admin/users')->name('admin.users.')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
            Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
            Route::put('/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
            Route::patch('/unblock/{id}', [App\Http\Controllers\Admin\UserController::class, 'unblock'])->name('unblock');
        });

        // 2. Kelola Katalog Produk (CRUD)
        Route::prefix('admin/katalog')->name('admin.katalog.')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('index');
            Route::post('/store', [App\Http\Controllers\Admin\ProdukController::class, 'store'])->name('store');
            Route::put('/update/{id}', [App\Http\Controllers\Admin\ProdukController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Admin\ProdukController::class, 'destroy'])->name('destroy');
        });

        // 3. Kelola Layanan Klinik (CRUD)
        Route::prefix('admin/layanan')->name('admin.layanan.')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\LayananController::class, 'index'])->name('index');
            Route::post('/store', [App\Http\Controllers\Admin\LayananController::class, 'store'])->name('store');
            Route::put('/update/{id}', [App\Http\Controllers\Admin\LayananController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Admin\LayananController::class, 'destroy'])->name('destroy');
        });

        // 4. Pengaturan Profil Admin
        Route::get('/admin/profil', [DashboardController::class, 'profil'])->name('admin.profil');
        Route::post('/admin/profil/update', [DashboardController::class, 'updateProfil'])->name('admin.profil.update');
    });

    // --- RUTE OWNER ---
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', [DashboardController::class, 'owner'])->name('dashboard.owner');
    });

    // --- RUTE CRUD HEWAN ---
    Route::post('/data-hewan/store', [DashboardController::class, 'storeHewan'])->name('hewan.store');
    Route::post('/data-hewan/update/{id}', [DashboardController::class, 'updateHewan'])->name('hewan.update');
    Route::delete('/data-hewan/delete/{id}', [DashboardController::class, 'hapusHewan'])->name('hewan.hapus');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('dashboard.checkout');
});
