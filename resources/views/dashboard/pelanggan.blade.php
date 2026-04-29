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
    /* CSS Bawaan Kamu */
    .grid-dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .stat-card { background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 5px solid #800080; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .stat-card h3 { color: #555; font-size: 16px; margin-bottom: 5px; }
    .stat-card .angka { font-size: 28px; font-weight: bold; color: #800080; }
    .btn-batal { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold; transition: 0.2s; }
    .btn-batal:hover { background: #a71d2a; transform: scale(1.05); }
    .btn-katalog { display: inline-block; background: #28a745; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .btn-katalog:hover { background: #218838; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.15); }

    /* Tambahan CSS Buat Badge Status */
    .badge-status { padding: 5px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block;}
    .status-menunggu-pembayaran { background: #ffeeba; color: #856404; }
    .status-menunggu-konfirmasi { background: #d1ecf1; color: #0c5460; }
    .status-dikonfirmasi { background: #d4edda; color: #155724; }
    .status-dibatalkan { background: #f8d7da; color: #721c24; }
    .status-default { background: #e2e3e5; color: #383d41; }
</style>

<div class="grid-dashboard">
    <div class="stat-card">
        <h3>Hewan Peliharaan Saya</h3>
        <div class="angka">{{ $petCount }} Anabul</div>
    </div>

    <div class="stat-card">
        <h3>Reservasi Aktif</h3>
        <div class="angka">{{ $activeReservationsCount ?? 0 }} Jadwal</div>
    </div>

    <div class="stat-card">
        <h3>Keranjang Belanja</h3>
        <div class="angka">{{ $cartCount }} Item</div>

        @if($cartCount > 0)
            <a href="{{ route('dashboard.checkout') }}" style="display: inline-block; margin-top: 10px; background: #800080; color: white; padding: 6px 15px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: bold;">Bayar Sekarang 🛒</a>
        @endif
    </div>
</div>

<h3 style="margin-bottom: 15px; color: #800080; margin-top: 30px;">📅 Jadwal Reservasi Layanan</h3>
<div style="background: #f8f9fa; border-radius: 8px; overflow-x: auto; border-left: 5px solid #800080;">
    <table style="width: 100%; border-collapse: collapse; overflow: hidden;">
        <tr style="background: #800080; color: white;">
            <th style="padding: 12px; text-align: left;">Layanan</th>
            <th style="padding: 12px; text-align: left;">Tanggal & Waktu</th>
            <th style="padding: 12px; text-align: left;">Hewan</th>
            <th style="padding: 12px; text-align: left;">Status</th>
            <th style="padding: 12px; text-align: center;">Aksi</th>
        </tr>

        @forelse($reservasiLayanan as $jadwal)
        <tr>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;"><strong>{{ $jadwal->nama_layanan }}</strong></td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }} <br>
                <small style="color: #666;">{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} WIB</small>
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $jadwal->pet_name }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                @if($jadwal->status == 'Menunggu Pembayaran' || $jadwal->status == 'Menunggu')
                    <span class="badge-status status-menunggu-pembayaran">Menunggu Pembayaran</span>
                @elseif($jadwal->status == 'Menunggu Konfirmasi Admin')
                    <span class="badge-status status-menunggu-konfirmasi">Dicek Admin</span>
                @elseif($jadwal->status == 'Dikonfirmasi')
                    <span class="badge-status status-dikonfirmasi">Disetujui</span>
                @elseif($jadwal->status == 'Dibatalkan')
                    <span class="badge-status status-dibatalkan">Dibatalkan</span>
                @else
                    <span class="badge-status status-default">{{ $jadwal->status }}</span>
                @endif
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd; text-align: center;">
                {{-- Tombol Batal muncul selama status belum Selesai atau Dibatalkan --}}
                @if($jadwal->status != 'Dibatalkan' && $jadwal->status != 'Selesai')
                    <form action="{{ route('reservasi.batal', $jadwal->id) }}" method="POST" onsubmit="mintaAlasanDP(event, this, '{{ $jadwal->nama_layanan }}', '{{ $jadwal->status }}');" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn-batal">Batalkan</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align: center; padding: 20px; color: #888;">Belum ada jadwal reservasi layanan.</td>
        </tr>
        @endforelse
    </table>
</div>

<h3 style="margin-bottom: 15px; color: #28a745; margin-top: 30px;">🛍️ Status Pembelian Produk</h3>
<div style="background: #f8f9fa; border-radius: 8px; overflow-x: auto; border-left: 5px solid #28a745;">
    <table style="width: 100%; border-collapse: collapse; overflow: hidden;">
        <tr style="background: #28a745; color: white;">
            <th style="padding: 12px; text-align: left;">ID Transaksi</th>
            <th style="padding: 12px; text-align: left;">Tanggal Beli</th>
            <th style="padding: 12px; text-align: left;">Total Belanja</th>
            <th style="padding: 12px; text-align: left;">Status</th>
        </tr>

        @forelse($pembelianProduk as $produk)
        <tr>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;"><strong>#TRX-{{ $produk->id }}</strong></td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                {{ \Carbon\Carbon::parse($produk->created_at)->translatedFormat('d F Y') }}
            </td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">Rp {{ number_format($produk->total_harga, 0, ',', '.') }}</td>
            <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                <span class="badge-status status-default">{{ $produk->status }}</span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align: center; padding: 20px; color: #888;">Belum ada riwayat pembelian produk.</td>
        </tr>
        @endforelse
    </table>
</div>

<script>
    function mintaAlasanDP(event, form, namaLayanan, status) {
        // Stop form biar ga langsung submit
        event.preventDefault();

        let pesan = `Apakah kamu yakin ingin membatalkan jadwal ${namaLayanan} ini?\n\n`;

        // Kasih warning khusus kalau udah bayar/disetujui
        if (status === 'Disetujui' || status === 'Dikonfirmasi' || status === 'Menunggu Konfirmasi Admin') {
            pesan += "⚠️ PERINGATAN: Karena reservasi sudah masuk tahap proses, uang DP yang sudah dibayarkan TIDAK DAPAT DIKEMBALIKAN (Hangus).\n\n";
        }

        pesan += "Silakan masukkan alasan pembatalan:";

        // Munculin pop-up input
        let alasan = prompt(pesan);

        // Kalau diisi dan klik OK
        if (alasan !== null && alasan.trim() !== '') {
            let inputAlasan = document.createElement('input');
            inputAlasan.type = 'hidden';
            inputAlasan.name = 'alasan_batal';
            inputAlasan.value = alasan;

            form.appendChild(inputAlasan);
            form.submit(); // Lanjut kirim ke controller
        } else if (alasan !== null) {
            // Kalau klik OK tapi dikosongin
            alert('Gagal membatalkan. Alasan pembatalan WAJIB diisi!');
        }
    }
</script>
@endsection
