<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Paw Center | D&F Pet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --purple-primary: #8E24AA;
            --purple-dark: #4A148C;
            --purple-light: #F3E5F5;
            --bg-body: #fbfbfb;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-body); color: #333; }

        /* --- HEADER --- */
        header {
            background: white;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo { font-size: 1.4rem; font-weight: 700; color: var(--purple-dark); text-decoration: none; }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .back-home {
            text-decoration: none;
            color: var(--purple-primary);
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 15px;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--purple-dark), var(--purple-primary));
            color: white;
            padding: 4rem 5% 6rem;
            text-align: center;
        }
        .hero-section h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }

        .search-container {
            max-width: 1000px;
            margin: -40px auto 2rem;
            padding: 0 1.5rem;
        }
        .search-wrapper {
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 1.5rem;
        }
        .search-bar input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid var(--purple-light);
            border-radius: 12px;
            outline: none;
            font-size: 1rem;
            transition: 0.3s;
        }
        .search-bar input:focus { border-color: var(--purple-primary); }

        .categories {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: none;
        }
        .categories::-webkit-scrollbar { display: none; }
        .cat-pill {
            padding: 8px 20px;
            background: var(--purple-light);
            color: var(--purple-dark);
            border-radius: 25px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            transition: 0.3s;
        }
        .cat-pill.active, .cat-pill:hover {
            background: var(--purple-primary);
            color: white;
        }

        .catalog-grid {
            max-width: 1200px;
            margin: 2rem auto 5rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
            padding: 0 1.5rem;
        }
        .card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.04);
            transition: 0.3s;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }
        .card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(74, 20, 140, 0.1); }

        .card-img {
            width: 100%;
            height: 180px;
            background-size: cover;
            background-position: center;
        }
        .card-body { padding: 1.2rem; display: flex; flex-direction: column; flex-grow: 1; }
        .tag {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--purple-primary);
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }
        .card-title { font-size: 1rem; font-weight: 600; color: #333; margin-bottom: 10px; line-height: 1.4; height: 2.8rem; overflow: hidden; }
        .price { font-size: 1.1rem; font-weight: 700; color: #f39c12; margin-bottom: 15px; margin-top: auto; }

        .btn-action {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background: var(--purple-primary);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-action:hover { background: var(--purple-dark); }
        .btn-action-outline {
            background: white;
            color: var(--purple-primary);
            border: 2px solid var(--purple-primary);
        }
        .btn-action-outline:hover {
            background: var(--purple-light);
            color: var(--purple-dark);
        }

        /* Tombol khusus di header */
        .btn-header { width: auto; padding: 8px 20px; border-radius: 25px; }
        .btn-outline { background: transparent; color: var(--purple-primary); border: 2px solid var(--purple-primary); }
        .btn-outline:hover { background: var(--purple-light); color: var(--purple-dark); }

        footer { text-align: center; padding: 3rem; color: #999; font-size: 0.8rem; }
    </style>
</head>
<body>

    <header>
        <a href="/" class="logo">🐾 Paw Center</a>

        <div class="header-right">
            <a href="{{ route('dashboard.pelanggan') }}" class="back-home">Dashboard Saya</a>

            @auth
                <span style="font-weight: 500; font-size: 0.9rem; color: var(--purple-dark); margin-right: 10px;">
                    Halo, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('logout') }}" class="btn-action btn-header btn-outline">Keluar</a>
            @else
                <a href="{{ route('login') }}" class="btn-action btn-header btn-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn-action btn-header">Daftar</a>
            @endauth
        </div>
    </header>

    <section class="hero-section">
        <h1>Katalog Paw Center</h1>
        <p>Temukan produk dan layanan terbaik untuk anabul kesayangan</p>
    </section>

    <div class="search-container">
        <div class="search-wrapper">
            <div class="search-bar">
                <input type="text" placeholder="Cari apa saja di Paw Center...">
            </div>
            <div class="categories">
                <a href="#" class="cat-pill active">Semua</a>
                <a href="#" class="cat-pill">Klinik</a>
                <a href="#" class="cat-pill">Grooming</a>
                <a href="#" class="cat-pill">Pet Hotel</a>
                <a href="#" class="cat-pill">Makanan</a>
                <a href="#" class="cat-pill">Aksesoris</a>
            </div>
        </div>
    </div>

    <main class="catalog-grid">
        <div class="card">
            <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1589924691995-400dc9ecc119?q=80&w=400&auto=format&fit=crop');"></div>
            <div class="card-body">
                <span class="tag">Makanan</span>
                <h3 class="card-title">Royal Canin Kitten 2Kg</h3>
                <p class="price">Rp 275.000</p>

                @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="1">
                        <input type="hidden" name="tipe" value="produk">
                        <button type="submit" class="btn-action">🛒 Tambah ke Keranjang</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-action btn-action-outline">Masuk untuk Membeli</a>
                @endauth
            </div>
        </div>

        <div class="card">
            <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=400&auto=format&fit=crop');"></div>
            <div class="card-body">
                <span class="tag">Grooming</span>
                <h3 class="card-title">Grooming Sehat (Mandi & Kutu)</h3>
                <p class="price">Rp 90.000</p>

                @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="2">
                        <input type="hidden" name="tipe" value="layanan">
                        <button type="submit" class="btn-action">📅 Booking Layanan</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-action btn-action-outline">Masuk untuk Booking</a>
                @endauth
            </div>
        </div>

        <div class="card">
            <div class="card-img" style="background-image: url('https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=400&auto=format&fit=crop');"></div>
            <div class="card-body">
                <span class="tag">Pet Hotel</span>
                <h3 class="card-title">Penitipan Kamar VIP (AC)</h3>
                <p class="price">Rp 120.000 <small>/malam</small></p>

                @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="3">
                        <input type="hidden" name="tipe" value="layanan">
                        <button type="submit" class="btn-action">📅 Booking Kamar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-action btn-action-outline">Masuk untuk Booking</a>
                @endauth
            </div>
        </div>
    </main>

    <footer>
        &copy; 2026 Paw Center by D&F Pet Shop & Clinic Subang.
    </footer>

</body>
</html>
