<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================
// 1. RUTE PUBLIK (Bisa diakses siapa saja / belum login)
// =========================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Middleware 'guest' mencegah user yang sudah login balik ke halaman ini
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Tambahin baris ini buat nampilin form register dan ngasih nama rute 'register'
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| 2. RUTE TERPROTEKSI (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Rute Logout dipindah ke sini karena butuh sesi login
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- GRUP PELANGGAN ---
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pelanggan'])->name('dashboard.pelanggan');
        Route::get('/data-hewan', [DashboardController::class, 'dataHewan'])->name('pelanggan.hewan');
        Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CheckoutController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/remove', [CheckoutController::class, 'removeFromCart'])->name('cart.remove');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/dashboard/reservasi/{id}/batal', [DashboardController::class, 'batalkan'])->name('reservasi.batal');
        Route::view('/layanan-produk', 'dashboard.layanan')->name('pelanggan.layanan');
        Route::get('/profil-saya', [DashboardController::class, 'profil'])->name('pelanggan.profil');
        Route::post('/profil-saya/update', [DashboardController::class, 'updateProfil'])->name('pelanggan.profil.update');
    });

    // --- RUTE DOKTER ---
    Route::middleware(['role:dokter'])->group(function () {
        Route::get('/dokter/dashboard', [DashboardController::class, 'dokter'])->name('dashboard.dokter');
    });

    // --- RUTE STAFF / KASIR ---
    Route::middleware(['role:admin,kasir,staff'])->group(function () {
        Route::get('/staff/dashboard', [DashboardController::class, 'staff'])->name('dashboard.staff');
    });

    // --- RUTE OWNER ---
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
    });

    // --- RUTE CRUD HEWAN ---
    Route::post('/data-hewan/store', [DashboardController::class, 'storeHewan'])->name('hewan.store');
    Route::post('/data-hewan/update/{id}', [DashboardController::class, 'updateHewan'])->name('hewan.update');
    Route::delete('/data-hewan/delete/{id}', [DashboardController::class, 'hapusHewan'])->name('hewan.hapus');

    // Tambahkan di dalam routes/web.php
    Route::get('/layanan', function () {
    return view('layanan');
});

});
