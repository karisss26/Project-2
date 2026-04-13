@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
@if(session('success'))
    <div style="background-color: #d4edda; border-left: 5px solid #28a745; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        ✅ <strong>Berhasil!</strong> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background-color: #f8d7da; border-left: 5px solid #dc3545; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        ❌ <strong>Waduh!</strong> {{ session('error') }}
    </div>
@endif

<style>
    .grid-dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .stat-card { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 5px solid #800080; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .stat-card h3 { color: #555; font-size: 16px; margin-bottom: 5px; }
    .stat-card .angka { font-size: 28px; font-weight: bold; color: #800080; }
    .btn-batal { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; transition: 0.2s; }
    .btn-batal:hover { background: #a71d2a; transform: scale(1.05); }
</style>

<div class="grid-dashboard">
    <div class="stat-card">
        <h3>Hewan Peliharaan Saya</h3>
        <div class="angka">{{ $petCount }} Anabul</div>
    </div>

    <div class="stat-card">
        <h3>Reservasi Aktif</h3>
        <div class="angka">{{ $activeReservationsCount }} Jadwal</div>
    </div>

    <div class="stat-card">
        <h3>Keranjang Belanja</h3>
        <div class="angka">{{ $cartCount }} Item</div>

        @if($cartCount > 0)
            <a href="{{ route('checkout.index') }}" style="display: inline-block; margin-top: 10px; background: #800080; color: white; padding: 6px 15px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold;">Bayar Sekarang 🛒</a>
        @endif
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #333;">Jadwal Terdekat</h3>
<div style="background: #f8f9fa; border-radius: 8px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; overflow: hidden;">
        <tr style="background: #800080; color: white;">
            <th style="padding: 12px; text-align: left;">Layanan</th>
            <th style="padding: 12px; text-align: left;">Tanggal & Waktu</th>
            <th style="padding: 12px; text-align: left;">Hewan</th>
            <th style="padding: 12px; text-align: left;">Status</th>
            <th style="padding: 12px; text-align: center;">Aksi</th>
        </tr>

        @forelse($jadwalTerdekat as $jadwal)
        <tr>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $jadwal->nama_layanan }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }} <br>
                <small style="color: #666;">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB</small>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $jadwal->pet_name }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                <span style="background: #ffc107; color: #856404; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                    {{ $jadwal->status }}
                </span>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd; text-align: center;">
                @if($jadwal->status != 'Dibatalkan')
                    <form action="{{ route('reservasi.batal', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan jadwal {{ $jadwal->nama_layanan }} ini?');">
                        @csrf
                        <button type="submit" class="btn-batal">Batalkan</button>
                    </form>
                @else
                    <small style="color: #999;">Sudah Dibatalkan</small>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center; padding: 20px; color: #888;">Belum ada jadwal reservasi aktif.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection
