@extends('layouts.app')

@section('title', 'Laporan Penjualan - Admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .admin-header h2 { color: var(--purple-900); font-weight: 700; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }

    .admin-card { background: var(--white); padding: 22px; border-radius: 12px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05); border: 1px solid var(--purple-100); margin-bottom: 18px; }
    .admin-card h3 { color: var(--purple-800); font-size: 18px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--purple-50); }

    .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 18px; }
    .stat-card { background: var(--white); padding: 18px; border-radius: 12px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05); border: 1px solid var(--purple-100); display: flex; flex-direction: column; gap: 8px; }
    .stat-card .title { color: var(--text-muted); font-size: 14px; font-weight: 600; }
    .stat-card .angka { font-size: 28px; font-weight: 800; color: var(--purple-600); }

    .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-row label { font-size: 12px; font-weight: 700; color: var(--text-muted); margin-bottom: 6px; display: block; }
    .form-control, .form-select { border: 1px solid var(--purple-200); border-radius: 10px; padding: 10px 12px; }
    .btn-acc { background: var(--purple-600); color: white; padding: 10px 14px; border-radius: 10px; border: none; font-weight: 800; cursor: pointer; }

    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: var(--purple-50); color: var(--purple-900); padding: 12px 15px; text-align: left; font-size: 13px; }
    .admin-table td { padding: 15px; border-bottom: 1px solid var(--purple-50); font-size: 13px; color: var(--text-main); vertical-align: top;}
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }

    .muted { color: var(--text-muted); }
</style>

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
                borderColor: '#800080',
                backgroundColor: 'rgba(128, 0, 128, 0.12)',
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
        '#800080','#6d28d9','#7c3aed','#a855f7','#9333ea',
        '#5b21b6','#4c1d95','#7f1d1d','#b91c1c','#ef4444'
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

