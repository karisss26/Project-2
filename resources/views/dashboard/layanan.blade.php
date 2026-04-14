<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Layanan - Paw Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .service-page { background-color: var(--bg-light); padding: 40px 0 80px; }
        .service-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 40px;
        }
        .service-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            background-color: var(--purple-200);
        }
        .service-body { padding: 40px; }
        .service-title { font-size: 24px; color: var(--purple-900); margin-bottom: 15px; font-weight: 700; }
        .service-desc { font-size: 15px; color: var(--text-muted); margin-bottom: 30px; line-height: 1.8; }
        .page-header { text-align: center; margin-bottom: 50px; }
        .page-header h1 { color: var(--purple-900); font-size: 32px; font-weight: 800; }
        .page-header p { color: var(--text-muted); font-size: 15px; margin-top: 10px; }
    </style>
</head>
<body class="welcome-page">

    <header class="welcome-header">
        <div class="container">
            <div class="logo-area">🐾 Paw Center</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/#layanan') }}" style="color: var(--purple-600); font-weight: 600;">Layanan</a></li>
                    <li><a href="{{ url('/#belanja') }}">Belanja</a></li>
                    <li><a href="{{ url('/#kontak') }}">Kontak</a></li>
                </ul>
            </nav>
            <div class="auth-btns">
                <a href="{{ url('/login') }}" class="btn btn-dark" style="border-radius: 25px; padding: 8px 20px;">Masuk</a>
            </div>
        </div>
    </header>

    <section class="service-page">
        <div class="container" style="max-width: 900px;">
            <div class="page-header">
                <h1>Daftar Layanan Kami</h1>
                <p>Pilih layanan terbaik untuk kesehatan dan kenyamanan hewan peliharaan Anda.</p>
            </div>

            <div class="service-card">
                <img src="https://images.unsplash.com/photo-1606425271394-c3ca9aa1fc06?q=80&w=1200&auto=format&fit=crop" alt="Klinik Hewan" class="service-img">
                <div class="service-body">
                    <h2 class="service-title">Klinik Hewan</h2>
                    <p class="service-desc">Layanan konsultasi dan diagnosa medis hewan peliharaan bersama dokter hewan profesional. Kami menyediakan fasilitas lengkap untuk memastikan kesehatan optimal bagi anabul Anda, termasuk pemeriksaan rutin, rawat jalan, tindakan medis minor, serta pengecekan lab dasar.</p>
                    <a href="{{ url('/login') }}" class="btn btn-primary">Reservasi Sekarang</a>
                </div>
            </div>

            <div class="service-card">
                <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?q=80&w=1200&auto=format&fit=crop" alt="Vaksinasi" class="service-img">
                <div class="service-body">
                    <h2 class="service-title">Vaksinasi Terjadwal</h2>
                    <p class="service-desc">Cegah penyebaran virus dan penyakit menular berbahaya dengan program vaksinasi rutin. Kami menyediakan berbagai jenis vaksin lengkap untuk anjing dan kucing, disesuaikan dengan usia dan kebutuhan medis hewan peliharaan Anda.</p>
                    <a href="{{ url('/login') }}" class="btn btn-primary">Reservasi Sekarang</a>
                </div>
            </div>

            <div class="service-card">
                <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=1200&auto=format&fit=crop" alt="Pet Grooming" class="service-img">
                <div class="service-body">
                    <h2 class="service-title">Premium Pet Grooming</h2>
                    <p class="service-desc">Manjakan anabul Anda dengan layanan grooming profesional kami. Meliputi mandi bersih, mandi anti-kutu dan jamur, potong & kikir kuku, pembersihan telinga, hingga styling bulu oleh groomer berpengalaman agar hewan Anda tampil bersih dan wangi.</p>
                    <a href="{{ url('/login') }}" class="btn btn-primary">Reservasi Sekarang</a>
                </div>
            </div>

        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-bottom" style="border-top: none; padding-top: 0;">
                &copy; 2026 Paw Center by D&F Pet Shop. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
