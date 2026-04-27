<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KatalogController; // 👈 Tambahan baru: Jangan lupa panggil controller katalognya

// =========================================================
// 1. RUTE PUBLIK (Bisa diakses siapa saja)
// =========================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 👈 Perbaikan: Arahkan ke Controller agar bisa mengambil data produk/layanan dari database
Route::get('/katalog', [KatalogController::class, 'index'])->name('dashboard.katalog');


// =========================================================
// 2. RUTE GUEST (Khusus buat yang BELUM login)
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

    // --- GRUP PELANGGAN ---
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pelanggan'])->name('dashboard.pelanggan');
        Route::get('/data-hewan', [DashboardController::class, 'dataHewan'])->name('pelanggan.hewan');

        // 👈 Catatan: Nanti di tombol katalog, panggil route('cart.add') ya buat masukin keranjang!
        Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CheckoutController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/remove', [CheckoutController::class, 'removeFromCart'])->name('cart.remove');

        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

        Route::post('/dashboard/reservasi/{id}/batal', [DashboardController::class, 'batalkan'])->name('reservasi.batal');
        Route::view('/layanan-produk', 'dashboard.layanan')->name('pelanggan.layanan');
        Route::get('/profil-saya', [DashboardController::class, 'profil'])->name('pelanggan.profil');
        Route::post('/profil-saya/update', [DashboardController::class, 'updateProfil'])->name('pelanggan.profil.update');
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

    // --- RUTE ADMIN & KASIR ---
    Route::middleware(['role:admin,kasir'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
    });

    // --- RUTE OWNER ---
    Route::middleware(['role:owner'])->group(function () {
        Route::get('/owner/dashboard', [DashboardController::class, 'owner'])->name('dashboard.owner');
    });

    // --- RUTE CRUD HEWAN ---
    Route::post('/data-hewan/store', [DashboardController::class, 'storeHewan'])->name('hewan.store');
    Route::post('/data-hewan/update/{id}', [DashboardController::class, 'updateHewan'])->name('hewan.update');
    Route::delete('/data-hewan/delete/{id}', [DashboardController::class, 'hapusHewan'])->name('hewan.hapus');

    // Ganti nama rute agar sinkron
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('dashboard.checkout');

});

// ❌ Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// KODE DI ATAS UDAH AKU HAPUS KARENA BIKIN BENTROK
