@extends('layouts.app')

@section('title', 'Dashboard Staff (Inventaris)')

@section('content')
<div class="alert-stok">
    <strong>⚠️ Peringatan:</strong> Ada 2 produk yang stoknya hampir habis. Segera lakukan restock!
</div>

<h3 style="margin-bottom: 15px; color: #333;">Daftar Produk Kritis</h3>
<table class="table-staff">
    <thead>
        <tr>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Sisa Stok</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>PRD-001</td>
            <td>Pasir Kucing Gumpal 5L</td>
            <td>Perlengkapan</td>
            <td style="color: red; font-weight: bold;">2 Pcs</td>
        </tr>
    </tbody>
</table>
@endsection
