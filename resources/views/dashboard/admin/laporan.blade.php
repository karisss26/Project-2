@extends('layouts.app')

@section('title', 'Laporan Penjualan - Admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="content">
    <div class="admin-header">
        <h2>Laporan Penjualan - Admin</h2>
    </div>

    <div class="admin-card">
        <h3>Filter Periode</h3>
        <form method="GET" action="{{ route('admin.laporan') }}">
            <div class="filter-row">
                <div>
                    <label>Mode</label>
                    <select name="mode" class="form-select" style="min-width: 200px;" onchange="this.form.submit()">
                        <option value="day" {{ $mode === 'day' ? 'selected' : '' }}>Harian (last {{ $count }} hari)</option>
                        <option value="month" {{ $mode === 'month' ? 'selected' : '' }}>Bulanan (last {{ $count }} bulan)</option>
                        <option value="year" {{ $mode === 'year' ? 'selected' : '' }}>Tahunan (last {{ $count }} tahun)</option>
                    </select>
                </div>

                <div>
                    <label>Jumlah periode</label>
                    <select name="count" class="form-select" style="min-width: 200px;">
                        <option value="7" {{ (int)$count === 7 ? 'selected' : '' }}>7</option>
                        <option value="14" {{ (int)$count === 14 ? 'selected' : '' }}>14</option>
                        <option value="30" {{ (int)$count === 30 ? 'selected' : '' }}>30</option>
                        <option value="6" {{ (int)$count === 6 ? 'selected' : '' }}>6</option>
                        <option value="12" {{ (int)$count === 12 ? 'selected' : '' }}>12</option>
                        <option value="5" {{ (int)$count === 5 ? 'selected' : '' }}>5</option>
                    </select>
                </div>

                <button class="btn-acc" type="submit">Tampilkan</button>
            </div>
        </form>
    </div>

    <div class="grid-stats">
        <div class="stat-card">
            <span class="title">Total Pendapatan</span>
            <span class="angka">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
        <div class="stat-card">
            <span class="title">Total Produk Terjual</span>
            <span class="angka">{{ $totalQtySold }} Item</span>
        </div>
        <div class="stat-card">
            <span class="title">Top Produk</span>
            <span class="angka" style="font-size:20px;">{{ $topProductName ?? '-' }}</span>
        </div>
    </div>

    <div class="grid-2">
        <div class="admin-card">
            <h3>Grafik Pendapatan (Roll Up: {{ $modeDisplay }})</h3>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
        <div class="admin-card">
            <h3>Pie Produk Terjual (Top 10)</h3>
            <canvas id="productPie" height="120"></canvas>
        </div>
    </div>

    <div class="admin-card">
        <h3>Top Produk</h3>
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-end">Qty Terjual</th>
                        <th class="text-end">Pendapatan Produk (perkiraan)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $row)
                        <tr>
                            <td><strong>{{ $row->nama_produk }}</strong></td>
                            <td class="text-end">{{ $row->qty_sold }}</td>
                            <td class="text-end">Rp {{ number_format($row->revenue_est ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="muted" style="text-align:center;">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card">
        <h3>Transaksi Selesai Terbaru</h3>
        <div style="overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactionsTable as $trx)
                        <tr>
                            <td><strong>#TRX-{{ $trx->id }}</strong></td>
                            <td>{{ $trx->created_at->format('d M Y') }}</td>
                            <td>{{ $trx->user->name ?? 'Anonim' }}</td>
                            <td>Rp {{ number_format($trx->total_harga ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="muted" style="text-align:center;">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const revenueLabels = {!! json_encode($revenueLabels) !!};
    const revenueSeries = {!! json_encode($revenueData) !!};

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueSeries,
                borderColor: '#36005E', // Warna ungu utama Paw Center
                backgroundColor: 'rgba(54, 0, 94, 0.12)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const pieLabels = {!! json_encode($pieLabels) !!};
    const pieData = {!! json_encode($pieData) !!};
    const pieCtx = document.getElementById('productPie').getContext('2d');

    const colors = [
        '#36005E','#47127e','#5d1aa8','#7f2fff','#9a61ff',
        '#c59aff','#dcc2ff','#ede1ff','#7c3aed','#6d28d9'
    ];

    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: colors.slice(0, pieLabels.length),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection