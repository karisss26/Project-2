@extends('layouts.app')

@section('title', 'Dashboard Owner - Paw Center')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #4A148C; font-weight: 700;">Dashboard Owner 🐾</h2>
        <span class="badge bg-purple" style="background: #8E24AA; padding: 10px;">Filter: {{ $modeDisplay }}</span>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 5px solid #8E24AA;">
                <div class="card-body">
                    <h6 class="text-muted">Total Pendapatan</h6>
                    <h3 class="fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 5px solid #4A148C;">
                <div class="card-body">
                    <h6 class="text-muted">Omzet Bersih</h6>
                    <h3 class="fw-bold">Rp {{ number_format($omzetBersih, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 5px solid #2E7D32;">
                <div class="card-body">
                    <h6 class="text-muted">Transaksi Selesai</h6>
                    <h3 class="fw-bold">{{ $totalTransaksiSelesai }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 5px solid #F57C00;">
                <div class="card-body">
                    <h6 class="text-muted">Produk Terjual</h6>
                    <h3 class="fw-bold">{{ $totalQtySold }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Tren Pendapatan ({{ $count }} {{ $modeDisplay }})</strong></div>
                <div class="card-body">
                    <canvas id="revenueChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Komposisi Penjualan Produk</strong></div>
                <div class="card-body">
                    <canvas id="produkChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white"><strong>Komposisi Reservasi Layanan</strong></div>
                <div class="card-body">
                    <canvas id="layananChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Line Chart Pendapatan
    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($revenueData) !!},
                borderColor: '#8E24AA',
                backgroundColor: 'rgba(142, 36, 170, 0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // 2. Pie Chart Produk Terlaris
    const ctxProd = document.getElementById('produkChart').getContext('2d');
    new Chart(ctxProd, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($pieLabels) !!},
            datasets: [{
                data: {!! json_encode($pieData) !!},
                backgroundColor: ['#4A148C', '#8E24AA', '#AB47BC', '#CE93D8', '#F3E5F5']
            }]
        }
    });

    // 3. Pie Chart Layanan Terlaris
    const ctxLay = document.getElementById('layananChart').getContext('2d');
    new Chart(ctxLay, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($topLayananPieLabels) !!},
            datasets: [{
                data: {!! json_encode($topLayananPieData) !!},
                backgroundColor: ['#1B5E20', '#388E3C', '#4CAF50', '#81C784', '#C8E6C9']
            }]
        }
    });
</script>
@endsection