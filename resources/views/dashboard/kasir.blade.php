@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<style>
    .grid-dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .stat-card { background: #E6E6FA; padding: 20px; border-radius: 8px; text-align: center; }
    .stat-card h3 { color: #555; font-size: 16px; margin-bottom: 5px; }
    .stat-card .angka { font-size: 28px; font-weight: bold; color: #800080; }
    .btn-pos { display: inline-block; background: #800080; color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 18px; margin-top: 20px; }
    .btn-pos:hover { background: #4B0082; }
</style>

<div class="grid-dashboard">
    <div class="stat-card">
        <h3>Transaksi Hari Ini</h3>
        <div class="angka">12</div>
    </div>
    <div class="stat-card">
        <h3>Antrean Pembayaran</h3>
        <div class="angka">3</div>
    </div>
    <div class="stat-card">
        <h3>Pesanan Pick-Up</h3>
        <div class="angka">5</div>
    </div>
</div>

<div style="text-align: center; padding: 40px; background: #f4f4f9; border-radius: 8px;">
    <h2 style="color: #333;">Sistem Kasir (POS)</h2>
    <p style="color: #666; margin-bottom: 20px;">Buka antarmuka kasir untuk memproses pembayaran layanan klinik dan produk pet shop.</p>
    <a href="#" class="btn-pos">Buka Aplikasi POS 🛒</a>
</div>
@endsection
