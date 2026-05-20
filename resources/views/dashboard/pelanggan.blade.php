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
    .stat-card h3 { color: #555; font-size: 16px; margin-bottom: 10px; margin-top:0; }
    .stat-card .angka { font-size: 24px; font-weight: bold; color: #800080; }
    .section-box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; border: 1px solid #f1f5f9; }
    .section-box h3 { margin-top: 0; margin-bottom: 20px; color: #1e1b4b; font-size: 18px; display: flex; align-items: center; gap: 8px; }
    .table-responsive { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
    .data-table th { background: #f8fafc; color: #64748b; font-weight: 600; padding: 12px 16px; border-bottom: 2px solid #edf2f7; }
    .data-table td { padding: 16px; border-bottom: 1px solid #edf2f7; color: #334155; vertical-align: middle; }
    .badge-status { padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; display: inline-block; }
    .status-menunggu { background: #fef3c7; color: #d97706; }
    .status-aktif { background: #e0f2fe; color: #0284c7; }
    .status-selesai { background: #dcfce7; color: #16a34a; }
    .status-batal { background: #fee2e2; color: #dc2626; }
    .btn-sm { padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; text-decoration: none; display: inline-block; transition: all 0.2s; }
    .btn-primary { background: #800080; color: white; border: none; }
    .btn-primary:hover { background: #600060; }
    .btn-danger { background: #ef4444; color: white; border: none; cursor: pointer; }
    .btn-danger:hover { background: #dc2626; }
</style>

<div class="content">
    <div style="margin-bottom: 25px;">
        <h2 style="margin:0; color: #1e1b4b;">Selamat Datang Kembali, {{ Auth::user()->name }}! 👋</h2>
        <p style="margin:5px 0 0 0; color: #64748b;">Pantau kondisi anabul dan status belanjamu di dashboard Paw Center.</p>
    </div>

    <div class="grid-dashboard">
        <div class="stat-card"><h3>Total Hewan Kamu</h3><span class="angka">{{ $petCount }}</span></div>
        <div class="stat-card"><h3>Reservasi Aktif</h3><span class="angka">{{ $activeReservationsCount }}</span></div>
        <div class="stat-card"><h3>Total Transaksi Belanja</h3><span class="angka">{{ count($pembelianProduk) }}</span></div>
    </div>

    <div class="section-box">
        <h3>🩺 Riwayat Jadwal Layanan & Klinik</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Booking</th>
                        <th>Layanan</th>
                        <th>Nama Anabul</th>
                        <th>Jadwal Kunjungan</th>
                        <th>Status</th>
                        <th>Aksi / Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservasiLayanan as $r)
                    <tr>
                        <td><strong>#RES-{{ $r->id }}</strong></td>
                        <td>{{ $r->nama_layanan }}</td>
                        <td><span style="background:#f1f5f9; padding:4px 8px; border-radius:4px; font-weight:600;">🐱 {{ $r->pet_name }}</span></td>
                        <td>
                            @if(!empty($r->tanggal))
                                {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}<br>
                                <small style="color:#64748b;">{{ \Carbon\Carbon::parse($r->waktu)->format('H:i') }} WIB</small>
                            @else
                                <span style="color:red;">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status 
                                {{ $r->status == 'Selesai' ? 'status-selesai' : '' }}
                                {{ in_array($r->status, ['Dikonfirmasi', 'Menunggu Jadwal']) ? 'status-aktif' : '' }}
                                {{ $r->status == 'Menunggu Konfirmasi Admin' ? 'status-menunggu' : '' }}
                                {{ $r->status == 'Dibatalkan' ? 'status-batal' : '' }}
                            ">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td>
                            @if($r->status === 'Menunggu Jadwal')
                                <a href="{{ route('reservasi.e-ticket.download', $r->id) }}" class="btn-sm btn-primary">
                                    Print E‑Ticket
                                </a>
                            @endif

                            @if($r->status === 'Menunggu Pembayaran')
                                <a href="{{ route('reservasi.bayar', $r->id) }}" class="btn-sm" style="background:#f59e0b; color:white;">
                                    Upload DP
                                </a>
                            @endif

                            @if(in_array($r->status, ['Menunggu Pembayaran', 'Menunggu Konfirmasi Admin', 'Dikonfirmasi', 'Menunggu Jadwal']))
                                <form action="{{ route('reservasi.batal', $r->id) }}" method="POST" style="display:inline;" onsubmit="return mintaAlasanDP(event, this, '{{ $r->nama_layanan }}', '{{ $r->status }}')">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger" style="margin-left: 5px;">Batal</button>
                                </form>
                            @else
                                <span style="color:#94a3b8; font-size:12px;">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center; padding: 30px; color: #9ca3af;">Belum ada riwayat booking klinik/layanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-box">
        <h3>🛍️ Riwayat Transaksi Belanja Produk</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tgl Checkout</th>
                        <th>Total Belanja</th>
                        <th>Metode Pengiriman</th>
                        <th>Status Pesanan</th>
                        <th>Bukti Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelianProduk as $t)
                    <tr>
                        <td><strong>#TRX-{{ $t->id }}</strong></td>
                        <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                        <td><span style="font-weight:600; color:#16a34a;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span></td>
                        
                        <td>
                            @if(isset($t->metode_pengiriman) && $t->metode_pengiriman == 'pickup')
                                <span style="color: #4c1d95; font-weight: bold;">📍 Ambil Sendiri</span><br>
                                <small style="color: #64748b;">Rencana Ambil: {{ !empty($t->tanggal_ambil) ? \Carbon\Carbon::parse($t->tanggal_ambil)->format('d M Y') : '-' }}</small>
                            @else
                                <span style="color: #0284c7; font-weight: bold;">🚚 Dikirim Kurir</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge-status
                                {{ $t->status == 'Selesai' ? 'status-selesai' : '' }}
                                {{ in_array($t->status, ['Dikonfirmasi', 'Diproses', 'Menunggu Diambil', 'Menunggu Jadwal', 'Menunggu Kurir', 'Pesanan Diantar']) ? 'status-aktif' : '' }}
                                {{ in_array($t->status, ['Menunggu Pembayaran', 'Menunggu Konfirmasi Admin']) ? 'status-menunggu' : '' }}
                                {{ $t->status == 'Dibatalkan' ? 'status-batal' : '' }}
                            ">
                                {{ $t->status == 'Menunggu Jadwal' ? 'Menunggu Diambil' : $t->status }}
                            </span>
                        </td>
                        <td>
                            @if($t->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $t->bukti_pembayaran) }}" target="_blank" class="btn-sm" style="background:#e2e8f0; color:#334155;">Lihat Struk</a>
                            @else
                                <span style="color:#94a3b8; font-size:12px;">COD / Tanpa Bukti</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center; padding: 30px; color: #9ca3af;">Belum ada riwayat pembelian produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function mintaAlasanDP(event, form, namaLayanan, status) {
        event.preventDefault();
        let pesan = `Apakah kamu yakin ingin membatalkan jadwal ${namaLayanan} ini?\\n\\n`;
        if (status === 'Disetujui' || status === 'Dikonfirmasi' || status === 'Menunggu Konfirmasi Admin' || status === 'Menunggu Jadwal') {
            pesan += "⚠️ PERINGATAN: Karena reservasi sudah masuk tahap proses, uang DP yang sudah dibayarkan TIDAK DAPAT DIKEMBALIKAN (Hangus).\\n\\n";
        }
        pesan += "Silakan masukkan alasan pembatalan:";
        let alasan = prompt(pesan);
        if (alasan !== null && alasan.trim() !== '') {
            let inputAlasan = document.createElement('input');
            inputAlasan.type = 'hidden';
            inputAlasan.name = 'alasan_batal';
            inputAlasan.value = alasan;
            form.appendChild(inputAlasan);
            form.submit();
        } else if (alasan !== null) {
            alert('Gagal membatalkan. Alasan pembatalan wajib diisi ya!');
        }
        return false;
    }
</script>
@endsection