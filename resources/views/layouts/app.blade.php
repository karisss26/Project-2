<!DOCTYPE html>
<html lang="id">
<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Center - D&F Pet Shop</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="dashboard-body">

    <div class="sidebar" id="mySidebar">
        <div class="sidebar-header">
            <div class="logo-text">🐾 Paw Center</div>
            <button class="toggle-btn" id="toggleBtn" title="Kecilkan/Besarkan Sidebar">☰</button>
        </div>

        <div class="menu-items">
            {{-- --- MENU PELANGGAN --- --}}
            @if(Auth::check() && Auth::user()->role == 'pelanggan')
                <a href="{{ route('dashboard.pelanggan') }}">
                    <span class="menu-icon">🏠</span><span class="menu-text">Dashboard</span>
                </a>
                <a href="{{ route('dashboard.katalog') }}">
                    <span class="menu-icon">🛍️</span><span class="menu-text">Layanan & Produk</span>
                </a>
                <a href="{{ route('pelanggan.hewan') }}">
                    <span class="menu-icon">🐶</span><span class="menu-text">Data Hewan</span>
                </a>
                <a href="{{ route('profil.umum') }}">
                    <span class="menu-icon">👤</span><span class="menu-text">Profil Saya</span>
                </a>

            {{-- --- MENU ADMIN, KASIR, & OWNER --- --}}
            @elseif(Auth::check() && in_array(Auth::user()->role, ['admin', 'kasir', 'owner']))

                {{-- Spesifik Owner --}}
                @if(Auth::user()->role == 'owner')
                    <a href="{{ route('dashboard.owner') }}">
                        <span class="menu-icon">🏠</span><span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('owner.profil') }}">
                        <span class="menu-icon">⚙️</span><span class="menu-text">Pengaturan Profil</span>
                    </a>

                {{-- Admin & Kasir --}}
                @else
                    <a href="{{ route('dashboard.admin') }}">
                        <span class="menu-icon">🏠</span><span class="menu-text">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}">
                        <span class="menu-icon">👥</span><span class="menu-text">Kelola Akun</span>
                    </a>
                    <a href="{{ route('admin.katalog.index') }}">
                        <span class="menu-icon">📦</span><span class="menu-text">Kelola Katalog Produk</span>
                    </a>
                    <a href="{{ route('admin.layanan.index') }}">
                        <span class="menu-icon">🩺</span><span class="menu-text">Kelola Layanan Klinik</span>
                    </a>
                    <a href="{{ route('admin.pos.index') }}">
                        <span class="menu-icon">🛒</span><span class="menu-text">Aplikasi Kasir (POS)</span>
                    </a>
                    <a href="{{ route('admin.laporan') }}">
                        <span class="menu-icon">📊</span><span class="menu-text">Laporan Penjualan</span>
                    </a>
                    <a href="{{ route('admin.profil') }}">
                        <span class="menu-icon">⚙️</span><span class="menu-text">Pengaturan Profil</span>
                    </a>
                @endif

            {{-- --- JIKA BELUM LOGIN / GUEST --- --}}
            @else
                <a href="#">
                    <span class="menu-icon">📊</span><span class="menu-text">Dashboard</span>
                </a>
            @endif
        </div>

        <a href="{{ route('logout') }}" class="logout-btn-sidebar">
            <span class="menu-icon">🚪</span>
            <span class="menu-text">Keluar</span>
        </a>
    </div>

    <div class="main-content">

        <div class="header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=36005E&color=fff' }}"
                    alt="Foto Profil"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #36005E; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

                <span style="font-weight: bold; color: #333; font-size: 16px;">
                    Halo, {{ Auth::user()->name }}! 👋
                </span>
            </div>
        </div>

        <div class="content">
            <div class="card">
                @yield('content')
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('mySidebar');
            const toggleBtn = document.getElementById('toggleBtn');

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                });
            }
        });
    </script>

</body>
</html>
