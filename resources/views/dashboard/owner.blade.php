@extends('layouts.app')

@section('title', 'Dashboard Owner - Paw Center')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .grid-dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .stat-card { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #E6E6FA; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .stat-card h3 { color: #888; font-size: 14px; text-transform: uppercase; margin-bottom: 10px; }
    .stat-card .angka { font-size: 24px; font-weight: bold; color: #333; }
    .angka.uang { color: #800080; }

    .section-container { background: #fff; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #E6E6FA; }
    .btn-print { background: #800080; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-bottom: 15px;}
    .btn-print:hover { background: #600060; }

    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    table, th, td { border: 1px solid #ddd; }
    th, td { padding: 12px; text-align: left; }
    th { background-color: #f8f9fa; }

    /* Styling khusus saat halaman di-print */
    @media print {
        body * { visibility: hidden; } /* Sembunyikan semua elemen */
        .print-area, .print-area * { visibility: visible; } /* Tampilkan hanya area laporan */
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; } /* Sembunyikan tombol print dsb saat nge-print */
    }
</style>

<button class="btn-print no-print" onclick="window.print()">🖨️ Cetak Laporan Operasional</button>

<div class="print-area">
    <h2 class="no-print" style="margin-bottom: 20px;">Ringkasan D&F Pet Shop</h2>

    <div class="grid-dashboard">
        <div class="stat-card">
            <h3>Pendapatan Hari Ini</h3>
            <div class="angka uang">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <h3>Total Layanan Selesai</h3>
            <div class="angka">{{ $layananSelesai }}</div>
        </div>
        <div class="stat-card">
            <h3>Produk Terjual</h3>
            <div class="angka">{{ $produkTerjual }} Item</div>
        </div>
        <div class="stat-card">
            <h3>Penghuni Pet Hotel</h3>
            <div class="angka">{{ $petHotel }} Ekor</div>
        </div>
    </div>

    <div class="section-container">
        <h3 style="color: #333; margin-bottom: 15px;">Grafik Pendapatan 7 Hari Terakhir</h3>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <div class="section-container">
        <h3 style="color: #333; margin-bottom: 15px;">Laporan Operasional & Transaksi Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Status</th>
                    <th>Total Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporanOperasional as $trx)
                <tr>
                    <td>#TRX-{{ $trx->id }}</td>
                    <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $trx->user->name ?? 'Anonim' }}</td>
                    <td>
                        <span style="padding: 5px 10px; border-radius: 4px; background: {{ $trx->status == 'Selesai' ? '#d4edda' : '#fff3cd' }};">
                            {{ $trx->status }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($trx->total_harga ?? 0, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const chartLabels = {!! json_encode($chartData['labels']) !!};
    const chartData = {!! json_encode($chartData['data']) !!};

    const revenueChart = new Chart(ctx, {
        type: 'line', // Bisa diganti 'bar' kalau mau bentuk batang
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartData,
                borderColor: '#800080',
                backgroundColor: 'rgba(128, 0, 128, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3 // Bikin garisnya agak melengkung smooth
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
