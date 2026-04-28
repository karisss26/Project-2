<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Center - D&F Pet Shop</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Reset CSS Dasar */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; height: 100vh; background-color: #f4f4f9; overflow: hidden; }

        /* ... (sisa CSS di bawahnya biarkan sama persis nggak usah diubah) ... */

        /* --- SIDEBAR UNGU --- */
        .sidebar {
            width: 260px;
            background-color: #800080;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: width 0.3s ease; /* Animasi mulus saat dikecilkan */
            z-index: 10;
        }

        /* Saat sidebar mode kecil */
        .sidebar.collapsed { width: 80px; }

        /* Bagian Atas Sidebar (Logo & Tombol Toggle) */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            height: 70px;
        }
        .logo-text { font-size: 22px; font-weight: bold; white-space: nowrap; transition: opacity 0.3s; }
        .sidebar.collapsed .logo-text { opacity: 0; pointer-events: none; display: none; }

        .toggle-btn {
            background: none; border: none; color: white; font-size: 24px; cursor: pointer; outline: none;
            transition: transform 0.3s;
        }
        .toggle-btn:hover { color: #E6E6FA; }
        .sidebar.collapsed .toggle-btn { margin: 0 auto; }

        /* Area Menu */
        .menu-items { flex: 1; padding-top: 15px; overflow-y: auto; overflow-x: hidden; }
        .sidebar a {
            display: flex; align-items: center; padding: 15px 20px; color: #ffffff; text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.3s; white-space: nowrap;
        }
        .sidebar a:hover { background-color: #4B0082; padding-left: 25px; border-left: 4px solid #E6E6FA; }
        .sidebar.collapsed a { padding: 15px; justify-content: center; border-left: none; }
        .sidebar.collapsed a:hover { padding-left: 15px; }

        /* Ikon & Teks Menu */
        .menu-icon { font-size: 20px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; font-size: 15px; transition: opacity 0.3s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }

        /* Tombol Logout di paling bawah */
        .logout-form { border-top: 1px solid rgba(255, 255, 255, 0.1); }
        .logout-btn {
            width: 100%; display: flex; align-items: center; padding: 15px 20px; background-color: #4B0082;
            color: white; border: none; cursor: pointer; font-size: 15px; transition: 0.3s; white-space: nowrap;
        }
        .logout-btn:hover { background-color: #dc3545; }
        .sidebar.collapsed .logout-btn { padding: 15px; justify-content: center; }

        /* --- AREA KONTEN UTAMA --- */
        .main-content { flex: 1; display: flex; flex-direction: column; transition: margin 0.3s ease; }

        /* --- HEADER PUTIH --- */
        .header {
            background-color: #ffffff; padding: 0 30px; height: 70px; display: flex;
            justify-content: flex-end; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* --- KONTEN HALAMAN --- */
        .content { padding: 30px; overflow-y: auto; height: calc(100vh - 70px); }
        .card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <div class="sidebar" id="mySidebar">
        <div class="sidebar-header">
            <div class="logo-text">🐾 Paw Center</div>
            <button class="toggle-btn" id="toggleBtn" title="Kecilkan/Besarkan Sidebar">☰</button>
        </div>

        <div class="menu-items">
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
                <a href="{{ route('pelanggan.profil') }}">
                    <span class="menu-icon">👤</span><span class="menu-text">Profil Saya</span>
                </a>

            @elseif(Auth::check() && in_array(Auth::user()->role, ['admin', 'kasir']))
                <a href="{{ route('dashboard.admin') }}">
                    <span class="menu-icon">📊</span><span class="menu-text">Dashboard Utama</span>
                </a>
                <a href="#">
                    <span class="menu-icon">👥</span><span class="menu-text">Kelola Akun Pengguna</span>
                </a>
                <a href="{{ route('dashboard.katalog') }}">
                    <span class="menu-icon">📦</span><span class="menu-text">Kelola Katalog Produk</span>
                </a>
                <a href="#">
                    <span class="menu-icon">🏥</span><span class="menu-text">Kelola Layanan Klinik</span>
                </a>
                <a href="#">
                    <span class="menu-icon">⚙️</span><span class="menu-text">Pengaturan Profil</span>
                </a>

            @else
                <a href="#">
                    <span class="menu-icon">📊</span><span class="menu-text">Dashboard</span>
                </a>
            @endif
        </div>

        <a href="{{ route('logout') }}" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 10px; border-top: 1px solid rgba(255, 255, 255, 0.1); transition: 0.3s;" onmouseover="this.style.backgroundColor='#dc3545'" onmouseout="this.style.backgroundColor='transparent'">
            <span class="menu-icon">🚪</span>
            <span class="menu-text">Keluar</span>
        </a>
    </div>

    <div class="main-content">

        <div class="header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=800080&color=fff' }}"
                    alt="Foto Profil"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #800080; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

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
