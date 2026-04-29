@extends('layouts.app')

@section('title', 'Dashboard Admin & Kasir')

@section('content')
<style>
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .admin-header h2 { color: var(--purple-900); font-weight: 700; }

    .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: var(--white); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05); border: 1px solid var(--purple-100); display: flex; flex-direction: column; justify-content: center; }
    .stat-card .title { color: var(--text-muted); font-size: 14px; font-weight: 600; margin-bottom: 10px; }
    .stat-card .angka { font-size: 32px; font-weight: 800; color: var(--purple-600); }

    .admin-card { background: var(--white); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05); border: 1px solid var(--purple-100); margin-bottom: 30px; }
    .admin-card h3 { color: var(--purple-800); font-size: 18px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--purple-50); }

    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: var(--purple-50); color: var(--purple-900); padding: 12px 15px; text-align: left; font-size: 13px; }
    .admin-table td { padding: 15px; border-bottom: 1px solid var(--purple-50); font-size: 13px; color: var(--text-main); vertical-align: top;}

    .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .badge-pending { background: #fff3cd; color: #856404; }

    .btn-sm { padding: 6px 10px; font-size: 11px; border-radius: 6px; cursor: pointer; border: none; font-weight: 600; transition: 0.3s; }
    .btn-acc { background: var(--purple-600); color: white; }
    .btn-tolak { background: #dc3545; color: white; }

    .status-select { padding: 5px; border-radius: 6px; border: 1px solid var(--purple-200); color: var(--purple-900); font-size: 12px; outline: none; width: 100%; }
    .detail-list { margin: 5px 0 0 0; padding-left: 15px; font-size: 12px; color: #555; }

    /* STYLE RIWAYAT (FULL WIDTH DI BAWAH) */
    .activity-list { list-style: none; padding: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; }
    .activity-list li { padding: 15px; background: var(--purple-50); border-radius: 10px; display: flex; flex-direction: column; gap: 5px; border-left: 4px solid var(--purple-300); }
    .activity-time { font-size: 11px; color: var(--text-muted); font-weight: 600; }
    .activity-desc { font-size: 13px; color: var(--text-main); }
</style>

<div class="content">
    <div class="admin-header">
        <h2>Dashboard Utama (Admin & Kasir)</h2>
    </div>

    <div class="grid-stats">
        <div class="stat-card"><span class="title">Total Pemasukan</span><span class="angka">Rp ---</span></div>
        <div class="stat-card"><span class="title">Menunggu Konfirmasi</span><span class="angka" style="color: #e67e22;">{{ $menungguKonfirmasi }}</span></div>
        <div class="stat-card"><span class="title">Pesanan Aktif</span><span class="angka" style="color: #3498db;">{{ $pesananDiproses }}</span></div>
        <div class="stat-card"><span class="title">Total Pengguna</span><span class="angka">{{ $totalPengguna }}</span></div>
    </div>

    <div class="admin-card">
        <h3>Antrean Konfirmasi Pembayaran</h3>
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Rincian Belanja</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antreanPembayaran as $antrean)
                    <tr>
                        <td>#{{ $antrean->nama_layanan ? 'RES' : 'TRX' }}-{{ $antrean->id }}</td>
                        <td>{{ $antrean->user->name ?? 'User' }}</td>
                        <td>
                            @if($antrean->nama_layanan)
                                <strong>🏥 {{ $antrean->nama_layanan }}</strong>
                            @else
                                <strong>📦 Produk:</strong>
                                <ul class="detail-list">
                                    @foreach($antrean->detail_belanja as $detail)
                                        <li>{{ $detail->nama_produk }} (x{{ $detail->jumlah }})</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            @php $path = $antrean->bukti_pembayaran_dp ?? $antrean->bukti_pembayaran; @endphp
                            @if($path)
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" style="background: var(--purple-900); color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 11px;">Lihat Struk</a>
                            @else
                                <span style="color: red; font-size: 11px;">Belum Bayar</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <form action="{{ route('admin.reservasi.setujui', $antrean->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tipe" value="{{ $antrean->nama_layanan ? 'reservasi' : 'transaksi' }}">
                                    <button type="submit" class="btn-sm" style="background: #28a745; color: white;">Setujui</button>
                                </form>
                                <form action="{{ route('admin.reservasi.tolak', $antrean->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tipe" value="{{ $antrean->nama_layanan ? 'reservasi' : 'transaksi' }}">
                                    <button type="submit" class="btn-sm btn-tolak">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center;">Tidak ada antrean.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card">
        <h3>Kelola Status Pesanan Aktif</h3>
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Item</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesananAktif as $pesanan)
                    <tr>
                        <td>#{{ $pesanan->nama_layanan ? 'RES' : 'TRX' }}-{{ $pesanan->id }}</td>
                        <td>{{ $pesanan->user->name ?? 'User' }}</td>
                        <td>{{ $pesanan->nama_layanan ?? 'Pembelian Produk' }}</td>
                        <td>
                            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST" style="display: flex; gap: 5px;">
                                @csrf
                                <input type="hidden" name="tipe" value="{{ $pesanan->nama_layanan ? 'reservasi' : 'transaksi' }}">
                                <select name="status" class="status-select">
                                    <option value="Dikonfirmasi" {{ $pesanan->status == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    @if($pesanan->nama_layanan)
                                        <option value="Menunggu Jadwal" {{ $pesanan->status == 'Menunggu Jadwal' ? 'selected' : '' }}>Menunggu Jadwal</option>
                                    @else
                                        <option value="Menunggu Jadwal" {{ $pesanan->status == 'Menunggu Jadwal' ? 'selected' : '' }}>Menunggu Diambil</option>
                                        <option value="Menunggu Kurir" {{ $pesanan->status == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                                        <option value="Pesanan Diantar" {{ $pesanan->status == 'Pesanan Diantar' ? 'selected' : '' }}>Diantar</option>
                                    @endif
                                    <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <button type="submit" class="btn-sm btn-acc">Update</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align: center;">Kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card">
        <h3>Riwayat Aktivitas Sistem</h3>
        <ul class="activity-list">
            @forelse($riwayatAktivitas as $log)
                <li>
                    <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                    <span class="activity-desc">
                        <strong>[{{ $log->aktivitas }}]</strong> {{ $log->deskripsi }}
                    </span>
                </li>
            @empty
                <li class="activity-desc">Belum ada catatan.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
