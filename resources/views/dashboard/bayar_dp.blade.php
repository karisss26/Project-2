@extends('layouts.app')

@section('title', 'Pembayaran DP Reservasi')

@section('content')
<div style="max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <h2 style="color: #800080; margin-bottom: 20px; text-align: center; font-weight: bold;">📸 Scan QRIS untuk Bayar DP</h2>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #800080;">
        <h3 style="font-size: 16px; margin-bottom: 10px; color: #333;">Rincian Reservasi</h3>
        <p style="margin-bottom: 5px; color: #555;"><strong>Layanan:</strong> {{ $reservasi->nama_layanan }}</p>
        <p style="margin-bottom: 5px; color: #555;"><strong>Harga Total:</strong> Rp {{ number_format($reservasi->harga_total, 0, ',', '.') }}</p>
        <hr style="margin: 10px 0; border: 0; border-top: 1px solid #ddd;">
        <p style="margin-bottom: 5px; font-size: 18px; color: #800080;"><strong>DP Wajib (30%): Rp {{ number_format($reservasi->dp, 0, ',', '.') }}</strong></p>
        <p style="margin-bottom: 5px; font-size: 13px; color: #666;">*Sisa pembayaran dilunasi di klinik setelah treatment.</p>
    </div>

    <div style="text-align: center; background: white; border: 2px solid #E6E6FA; padding: 20px; border-radius: 12px; margin-bottom: 25px;">
        <p style="color: #4B0082; font-weight: bold; margin-bottom: 15px;">Scan QRIS Paw Center di Bawah Ini:</p>

        <img src="{{ asset('storage/img/qris.jpg') }}" alt="QRIS Paw Center" style="width: 250px; height: auto; margin-bottom: 15px; border: 1px solid #eee;">

        <h4 style="font-size: 18px; color: #2e1065; font-weight: bold; margin: 0;">PAW CENTER (D&F PETS)</h4>
        <p style="color: #666; font-size: 12px;">NMID: ID1234567890123</p>
    </div>

    <form action="{{ route('reservasi.upload', $reservasi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="font-weight: bold; display: block; margin-bottom: 10px; color: #555;">Sudah bayar? Upload Screenshot Berhasilnya di Sini:</label>
            <input type="file" name="bukti_pembayaran_dp" accept="image/jpeg, image/png, image/jpg" required style="width: 100%; padding: 10px; border: 1px dashed #800080; border-radius: 6px; background: #fafafa; cursor: pointer;">
            <small style="color: #dc3545; display: block; margin-top: 5px;"><strong>Penting:</strong> Reservasi hanya akan dikonfirmasi jika bukti transfer valid.</small>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #800080; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(128, 0, 128, 0.2);">Konfirmasi Sudah Bayar</button>

        <a href="{{ route('dashboard.pelanggan') }}" style="display: block; text-align: center; margin-top: 15px; color: #999; text-decoration: none; font-size: 14px;">Bayar Nanti Saja</a>
    </form>
</div>
@endsection
