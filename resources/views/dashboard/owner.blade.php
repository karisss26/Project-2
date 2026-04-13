@extends('layouts.app')

@section('title', 'Dashboard Owner (Admin)')

@section('content')
<style>
    .grid-dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .stat-card { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #E6E6FA; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .stat-card h3 { color: #888; font-size: 14px; text-transform: uppercase; margin-bottom: 10px; }
    .stat-card .angka { font-size: 24px; font-weight: bold; color: #333; }
    .angka.uang { color: #800080; }
</style>

<div class="grid-dashboard">
    <div class="stat-card">
        <h3>Pendapatan Hari Ini</h3>
        <div class="angka uang">Rp 1.450.000</div>
    </div>
    <div class="stat-card">
        <h3>Total Layanan Selesai</h3>
        <div class="angka">24</div>
    </div>
    <div class="stat-card">
        <h3>Produk Terjual</h3>
        <div class="angka">18 Item</div>
    </div>
    <div class="stat-card">
        <h3>Penghuni Pet Hotel</h3>
        <div class="angka">6 Ekor</div>
    </div>
</div>

<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px;">
    <h3 style="color: #333; margin-bottom: 15px;">Aktivitas Terbaru</h3>
    <ul style="list-style: none; padding: 0;">
        <li style="padding: 10px 0; border-bottom: 1px solid #ddd;">✅ Pembayaran layanan Grooming (Rp 120.000) oleh Kasir Budi.</li>
        <li style="padding: 10px 0; border-bottom: 1px solid #ddd;">✅ drh. Adrian baru saja menyelesaikan rekam medis pasien A-03.</li>
        <li style="padding: 10px 0;">⚠️ Stok 'Pasir Kucing Gumpal 5L' sisa 2 Pcs.</li>
    </ul>
</div>
@endsection
