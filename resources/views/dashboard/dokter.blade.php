@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<style>
    .grid-dashboard { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
    .stat-card { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 5px solid #28a745; }
    .stat-card h3 { color: #555; font-size: 16px; margin-bottom: 5px; }
    .stat-card .angka { font-size: 28px; font-weight: bold; color: #28a745; }
</style>

<div class="grid-dashboard">
    <div class="stat-card">
        <h3>Antrean Pasien Hari Ini</h3>
        <div class="angka">8 Pasien</div>
    </div>
    <div class="stat-card" style="border-left-color: #17a2b8;">
        <h3 style="color: #17a2b8;">Konsultasi Selesai</h3>
        <div class="angka" style="color: #17a2b8;">3 Pasien</div>
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #333;">Antrean Saat Ini</h3>
<table style="width: 100%; border-collapse: collapse; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
    <tr style="background: #28a745; color: white;">
        <th style="padding: 12px; text-align: left;">No. Antrean</th>
        <th style="padding: 12px; text-align: left;">Nama Hewan</th>
        <th style="padding: 12px; text-align: left;">Keluhan Utama</th>
        <th style="padding: 12px; text-align: left;">Aksi</th>
    </tr>
    <tr>
        <td style="padding: 12px; border-bottom: 1px solid #ddd; font-weight: bold;">A-04</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">Boba (Anjing)</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">Muntah dan diare sejak pagi</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">
            <button style="background: #800080; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">Isi Rekam Medis</button>
        </td>
    </tr>
</table>
@endsection
