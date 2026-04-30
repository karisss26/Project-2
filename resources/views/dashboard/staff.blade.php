@extends('layouts.app')

@section('title', 'Dashboard Staff (Inventaris)')

@section('content')
<style>
    .alert-stok { background: #ffeeba; border-left: 5px solid #ffc107; padding: 15px; margin-bottom: 20px; border-radius: 4px; color: #856404; }
</style>

<div class="alert-stok">
    <strong>⚠️ Peringatan:</strong> Ada 2 produk yang stoknya hampir habis. Segera lakukan restock!
</div>

<h3 style="margin-bottom: 15px; color: #333;">Daftar Produk Kritis</h3>
<table style="width: 100%; border-collapse: collapse; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
    <tr style="background: #dc3545; color: white;">
        <th style="padding: 12px; text-align: left;">Kode Produk</th>
        <th style="padding: 12px; text-align: left;">Nama Produk</th>
        <th style="padding: 12px; text-align: left;">Kategori</th>
        <th style="padding: 12px; text-align: left;">Sisa Stok</th>
    </tr>
    <tr>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">PRD-001</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">Pasir Kucing Gumpal 5L</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">Perlengkapan</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd; color: red; font-weight: bold;">2 Pcs</td>
    </tr>
    <tr>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">PRD-045</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">Royal Canin Kitten 1kg</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd;">Makanan</td>
        <td style="padding: 12px; border-bottom: 1px solid #ddd; color: red; font-weight: bold;">0 Pcs</td>
    </tr>
</table>
@endsection
