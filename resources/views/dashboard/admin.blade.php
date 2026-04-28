@extends('layouts.app')

@section('title', 'Dashboard Admin & Kasir')

@section('content')
<style>
    /* Menggunakan variabel warna dari style.css kamu */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .admin-header h2 {
        color: var(--purple-900);
        font-weight: 700;
    }

    /* Grid Statistik */
    .grid-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: var(--white);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05);
        border: 1px solid var(--purple-100);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .stat-card .title { color: var(--text-muted); font-size: 14px; font-weight: 600; margin-bottom: 10px; }
    .stat-card .angka { font-size: 32px; font-weight: 800; color: var(--purple-600); }

    /* Grid Layout Utama */
    .grid-main {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    /* Card Container Umum */
    .admin-card {
        background: var(--white);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05);
        border: 1px solid var(--purple-100);
        margin-bottom: 30px;
    }
    .admin-card h3 {
        color: var(--purple-800);
        font-size: 18px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--purple-50);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Tabel Styling */
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: var(--purple-50); color: var(--purple-900); padding: 12px 15px; text-align: left; font-size: 14px; }
    .admin-table td { padding: 15px; border-bottom: 1px solid var(--purple-50); font-size: 14px; color: var(--text-main); }
    .admin-table tr:hover { background-color: var(--purple-50); }

    /* Badges Status */
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-process { background: #cce5ff; color: #004085; }
    .badge-success { background: #d4edda; color: #155724; }

    /* Buttons */
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; cursor: pointer; border: none; font-weight: 600; transition: 0.3s; }
    .btn-acc { background: var(--purple-600); color: white; }
    .btn-acc:hover { background: var(--purple-800); }
    .btn-tolak { background: #dc3545; color: white; }
    .btn-tolak:hover { background: #c82333; }

    /* POS Banner */
    .pos-banner {
        background: linear-gradient(135deg, var(--purple-600), var(--purple-800));
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px rgba(91, 33, 182, 0.3);
    }
    .pos-banner h2 { font-size: 24px; margin-bottom: 10px; }
    .pos-banner p { color: var(--purple-100); margin-bottom: 20px; font-size: 14px; }
    .btn-pos { background: var(--white); color: var(--purple-700); padding: 12px 25px; border-radius: 25px; font-weight: 700; display: inline-block; transition: 0.3s; text-decoration: none;}
    .btn-pos:hover { background: var(--purple-100); transform: translateY(-2px); }

    /* Aktivitas List */
    .activity-list { list-style: none; padding: 0; }
    .activity-list li { padding: 12px 0; border-bottom: 1px solid var(--purple-50); display: flex; align-items: flex-start; gap: 10px; }
    .activity-list li:last-child { border-bottom: none; }
    .activity-time { font-size: 12px; color: var(--text-muted); min-width: 60px; }
    .activity-desc { font-size: 13px; color: var(--text-main); }

    /* Menu Panel */
    .panel-menu { display: flex; flex-direction: column; gap: 10px; }
    .panel-menu a { display: block; padding: 15px; background: var(--purple-50); color: var(--purple-900); border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
    .panel-menu a:hover { background: var(--purple-100); border-left-color: var(--purple-600); padding-left: 20px; }

    /* Select Dropdown Table */
    .status-select { padding: 6px; border-radius: 6px; border: 1px solid var(--purple-200); color: var(--purple-900); font-size: 13px; outline: none; }
</style>

<div class="content">
    <div class="admin-header">
        <h2>Dashboard Utama (Admin & Kasir)</h2>
        <div>
            <a href="#" class="btn btn-outline" style="border-radius: 8px; padding: 10px 20px;">Halo, Admin 👋</a>
        </div>
    </div>

    <div class="pos-banner">
        <h2>Sistem Kasir (Point of Sales) 🛒</h2>
        <p>Buka antarmuka kasir untuk memproses transaksi langsung di toko, penjualan produk retail, maupun pembayaran layanan klinik.</p>
        <a href="#" class="btn-pos">Buka Aplikasi POS Sekarang</a>
    </div>

    <div class="grid-stats">
        <div class="stat-card">
            <span class="title">Total Pemasukan Hari Ini</span>
            <span class="angka">Rp ---</span> </div>
        <div class="stat-card">
            <span class="title">Menunggu Konfirmasi</span>
            <span class="angka" style="color: #e67e22;">{{ $menungguKonfirmasi }}</span>
        </div>
        <div class="stat-card">
            <span class="title">Pesanan/Reservasi Diproses</span>
            <span class="angka" style="color: #3498db;">{{ $pesananDiproses }}</span>
        </div>
        <div class="stat-card">
            <span class="title">Total Pengguna (Pelanggan)</span>
            <span class="angka">{{ $totalPengguna }}</span>
        </div>
    </div>

    <div class="admin-card">
                <h3>Antrean Konfirmasi Pembayaran</h3>
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Reservasi</th>
                                <th>Pelanggan</th>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antreanPembayaran as $antrean)
                            <tr>
                                <td>#RES-{{ $antrean->id }}</td>
                                <td>{{ $antrean->user->name ?? 'User Tidak Ditemukan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($antrean->tanggal)->format('d M Y') }} - {{ $antrean->waktu }}</td>
                                <td><span class="badge badge-pending">{{ $antrean->status }}</span></td>
                                <td>
                                    <form action="#" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-acc">Konfirmasi</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted);">Tidak ada antrean pembayaran saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="admin-card">
                <h3>Kelola Status Reservasi / Pesanan</h3>
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID Reservasi</th>
                                <th>Pelanggan</th>
                                <th>Layanan / Catatan</th>
                                <th>Status Saat Ini</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananAktif as $pesanan)
                            <tr>
                                <td>#RES-{{ $pesanan->id }}</td>
                                <td>{{ $pesanan->user->name ?? 'User Tidak Ditemukan' }}</td>
                                <td>{{ $pesanan->keluhan ?? '-' }}</td>
                                <td><span class="badge badge-process">{{ $pesanan->status }}</span></td>
                                <td>
                                    <form action="#" method="POST" style="display: flex; gap: 5px;">
                                        @csrf
                                        <select name="status" class="status-select">
                                            <option value="Dikonfirmasi" {{ $pesanan->status == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                            <option value="Selesai">Selesai</option>
                                        </select>
                                        <button type="submit" class="btn-sm btn-acc" style="padding: 5px 10px;">✓</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted);">Tidak ada pesanan yang sedang diproses.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-card">
                <h3>Grafik Penjualan & Reservasi (Minggu Ini)</h3>
                <div style="height: 250px; background: var(--purple-50); border-radius: 8px; display:flex; justify-content:center; align-items:center; color: var(--purple-400); font-weight:600; border: 2px dashed var(--purple-200);">
                    [ Area Canvas Chart.js ]
                </div>
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
                    <li class="activity-desc">Belum ada aktivitas yang tercatat.</li>
                @endforelse
            </ul>
            <a href="#" style="display: block; text-align: center; margin-top: 15px; font-size: 13px; color: var(--purple-600); font-weight: 600;">Lihat Semua Laporan Aktivitas</a>
        </div>

    </div>
</div>
@endsection
