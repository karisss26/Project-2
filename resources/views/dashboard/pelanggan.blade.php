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

    /* TAMBAHAN STYLE BUAT TABEL BIAR CAKEP */
    .table-container {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.08);
        margin-bottom: 30px;
        overflow-x: auto; /* Biar ngga nabrak kalo layarnya kecil */
    }
    .table-header-title {
        color: #6d28d9;
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px; /* Biar kolomnya lega dan list produk ngga kelipet */
    }
    .custom-table th {
        background: #f3e8ff; /* ungu terang */
        color: #4c1d95;
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        font-weight: 600;
        border-bottom: 2px solid #e9d5ff;
    }
    .custom-table td {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #374151;
        vertical-align: middle;
    }
    .custom-table tr:hover {
        background-color: #faf5ff;
    }
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-gray { background: #f3f4f6; color: #4b5563; }
    .badge-orange { background: #fef3c7; color: #d97706; }
    .badge-green { background: #d1fae5; color: #059669; }
    .badge-red { background: #fee2e2; color: #dc2626; }

    .product-list {
        margin: 0;
        padding-left: 20px;
        color: #4b5563;
    }
    .product-list li {
        margin-bottom: 4px;
        list-style-type: disc;
    }
    .btn-batal {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
        font-size: 12px;
    }
    .btn-batal:hover { background: #b91c1c; }
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

<div class="table-container">
    <div class="table-header-title">
        🏥 Riwayat Reservasi Layanan
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Layanan</th>
                <th>Tanggal & Waktu</th>
                <th>Metode Bayar</th>
                <th>Status</th>
                <th>Alasan Batal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasiLayanan as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $r->nama_layanan }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($r->tanggal_reservasi)->format('d M Y') }} <br> <span style="color:#6b7280; font-size:12px;">{{ $r->waktu_reservasi }} WIB</span></td>
                <td>
                    <span class="badge badge-gray">
                        {{ $r->metode_pembayaran ?? 'Bayar di Klinik' }}
                    </span>
                </td>
                <td>
                    @if($r->status == 'Menunggu' || $r->status == 'Pending')
                        <span class="badge badge-orange">Menunggu</span>
                    @elseif($r->status == 'Disetujui' || $r->status == 'Dikonfirmasi')
                        <span class="badge badge-green">Disetujui</span>
                    @else
                        <span class="badge badge-red">{{ $r->status }}</span>
                    @endif
                </td>
                <td>{{ $r->alasan_batal ?? '-' }}</td>
                <td>
                    @if($r->status === 'Dikonfirmasi')
                        <a href="{{ route('reservasi.e-ticket.download', $r->id) }}" class="btn btn-sm" style="background:#2e1065; color:#fff; padding:8px 12px; border-radius:6px; display:inline-block; text-decoration:none; font-weight:bold;">
                            Print E‑Ticket
                        </a>
                    @elseif($r->status != 'Dibatalkan' && $r->status != 'Selesai')
                        <form action="{{ route('reservasi.batal', $r->id) }}" method="POST" onsubmit="return mintaAlasanDP(event, this, '{{ $r->nama_layanan }}', '{{ $r->status }}')">
                            @csrf
                            <button type="submit" class="btn-batal">Batalkan</button>
                        </form>
                    @else
                        <span style="color:#9ca3af; font-size:12px;">Tidak ada aksi</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #9ca3af;">Belum ada riwayat reservasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="table-container">
    <div class="table-header-title">
        🛍️ Riwayat Pembelian Produk
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Produk yang Dibeli</th>
                <th>Total</th>
                <th>Metode Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelianProduk as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>#TRX-{{ $t->id }}</strong></td>
                <td>
                    <ul class="product-list">
                        @foreach($t->detilProduk as $detail)
                            <li>
                            {{ $detail->produk->nama_produk }} 
                            <br>
                            <small style="color: #6b7280;">
                                {{ $detail->jumlah }}x @ Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}
                            </small>
                            </li>
                        @endforeach
                    </ul>

                        </td>
                <td style="color: #6d28d9; font-weight: bold;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-gray">
                            {{ $t->bukti_pembayaran ? 'Transfer Bank' : 'Bayar Cash' }}
                        </span>
                    </td>
                <td>
                    @if($t->status == 'Selesai')
                        <span class="badge badge-green">Selesai</span>
                    @else
                        <span class="badge badge-orange">{{ $t->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #9ca3af;">Belum ada riwayat pembelian produk.</td>
            </tr>
            @endforelse
        </tbody>
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
