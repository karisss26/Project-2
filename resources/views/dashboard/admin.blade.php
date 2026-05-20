@extends('layouts.app')

@section('title', 'Dashboard Admin & Kasir')

@section('content')
<div class="content">
    <div class="admin-header">
        <h2>Dashboard Utama (Admin & Kasir)</h2>
    </div>

    <div class="grid-stats">
        <div class="stat-card">
            <a href="{{ route('admin.laporan') }}" style="text-decoration:none; color: inherit;" aria-label="Buka Laporan Penjualan">
                <span class="title">Total Pemasukan</span>
            </a>
            <span class="angka">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
        </div>
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
                                    <button type="submit" class="btn-sm btn-acc" style="background: #28a745; color: white;">Setujui</button>
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
                        <th>Jenis</th>
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
