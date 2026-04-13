<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&F Pet Shop - Klinik dan Pet Shop</title>
    <style>
        /* --- RESET & BASIC --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        html { scroll-behavior: smooth; }
        body { background-color: #f8f9fa; color: #333; line-height: 1.6; }
        a { text-decoration: none; }

        /* --- NAVBAR --- */
        .navbar {
            background-color: #ffffff; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100;
        }
        .navbar .logo { font-size: 24px; font-weight: bold; color: #800080; display: flex; align-items: center; gap: 10px; }
        .navbar .menu a { color: #555; margin: 0 15px; font-weight: 500; transition: color 0.3s; }
        .navbar .menu a:hover { color: #800080; }
        .btn-login { background-color: #800080; color: #fff; padding: 8px 20px; border-radius: 20px; border: none; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-login:hover { background-color: #4B0082; }

        /* --- HERO SECTION --- */
        .hero {
            background: linear-gradient(135deg, #800080, #9932CC); color: #ffffff; padding: 100px 50px; text-align: center;
        }
        .hero h1 { font-size: 40px; margin-bottom: 15px; font-weight: 800; }
        .hero p { font-size: 18px; max-width: 700px; margin: 0 auto 30px; opacity: 0.9; }
        .hero .btn-hero { background-color: white; color: #800080; padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: bold; display: inline-block; transition: 0.3s; }
        .hero .btn-hero:hover { transform: scale(1.05); box-shadow: 0 4px 15px rgba(255,255,255,0.3); }

        /* --- SECTION GLOBAL --- */
        .section { padding: 60px 50px; text-align: center; }
        .section-title { font-size: 32px; color: #800080; margin-bottom: 10px; font-weight: bold; }
        .section-subtitle { color: #666; margin-bottom: 40px; font-size: 16px; }

        /* --- GRID CARDS (LAYANAN & PRODUK) --- */
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.04); text-align: left; transition: transform 0.3s; border: 1px solid #eee; display: flex; flex-direction: column; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(128, 0, 128, 0.1); border-color: #E6E6FA; }
        .card-img { width: 100%; height: 160px; background-color: #E6E6FA; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; color: #800080; font-size: 40px; }
        .card-title { font-size: 20px; color: #333; margin-bottom: 8px; font-weight: bold; }
        .card-desc { font-size: 14px; color: #666; margin-bottom: 10px; flex-grow: 1; }
        .card-price { font-size: 18px; color: #800080; font-weight: bold; margin-bottom: 15px; }
        .btn-action { display: block; width: 100%; text-align: center; background-color: #ffffff; color: #800080; border: 2px solid #800080; padding: 10px; border-radius: 6px; font-weight: bold; transition: 0.3s; cursor: pointer; }
        .btn-action:hover { background-color: #800080; color: #ffffff; }

        /* --- TENTANG KAMI & PROFIL DOKTER --- */
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto; }
        .feature-item { background: white; padding: 20px; border-radius: 10px; text-align: center; }
        .feature-icon { font-size: 40px; color: #800080; margin-bottom: 10px; }
        .doctor-section { background-color: #ffffff; }
        .doctor-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 900px; margin: 0 auto; }
        .doctor-card { background: #f8f9fa; border-radius: 15px; padding: 30px; text-align: center; transition: 0.3s; border: 1px solid #eaeaea; }
        .doctor-photo { width: 120px; height: 120px; background-color: #ccc; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 50px; border: 4px solid #E6E6FA; }
        .doctor-name { font-size: 22px; color: #800080; font-weight: bold; margin-bottom: 5px; }
        .doctor-spec { color: #555; font-weight: 500; margin-bottom: 15px; font-size: 14px; background: #E6E6FA; display: inline-block; padding: 4px 12px; border-radius: 15px; }
        .doctor-schedule { font-size: 14px; color: #666; text-align: left; background: white; padding: 15px; border-radius: 8px; border-left: 4px solid #800080; }

        /* --- FOOTER & MODAL --- */
        .footer { background-color: #2c003e; color: #fff; padding: 50px 50px 20px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; margin-bottom: 30px; }
        .footer h3 { font-size: 20px; margin-bottom: 15px; color: #E6E6FA; }
        .footer p, .footer ul li { font-size: 14px; color: #ccc; margin-bottom: 10px; }
        .footer ul { list-style: none; }
        .footer ul li a { color: #ccc; transition: 0.3s; }
        .footer ul li a:hover { color: #fff; text-decoration: underline; }
        .footer-bottom { text-align: center; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 13px; color: #aaa; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); display: none; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(3px); }
        .modal-box { background: #ffffff; padding: 35px; border-radius: 12px; width: 100%; max-width: 400px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .close-btn { position: absolute; top: 15px; right: 20px; font-size: 28px; cursor: pointer; color: #999; transition: 0.3s; }
        .close-btn:hover { color: #333; }
        .modal-box h2 { text-align: center; color: #800080; margin-bottom: 25px; font-size: 24px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; color: #555; font-size: 14px; font-weight: 500; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none; transition: 0.3s; }
        .btn-submit { width: 100%; background-color: #800080; color: white; padding: 12px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 10px; font-weight: bold; transition: 0.3s; }
        .btn-submit:hover { background-color: #4B0082; }
    </style>
</head>
<body>
    @if(session('success'))
        <div id="toast" style="position: fixed; top: 20px; right: 20px; background-color: #28a745; color: white; padding: 15px 25px; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 10px rgba(0,0,0,0.2); font-weight: bold; animation: fadein 0.5s;">
            ✅ {{ session('success') }}
        </div>
        <script>
            setTimeout(() => { document.getElementById('toast').style.display = 'none'; }, 3000);
        </script>
    @endif

    <nav class="navbar">
        <div class="logo">🐾 D&F Pet Shop</div>

<div class="menu">
            <a href="/">Beranda</a>

            <a href="{{ Auth::check() && Auth::user()->role == 'pelanggan' ? route('pelanggan.layanan') : '#layanan' }}">Layanan</a>
            <a href="{{ Auth::check() && Auth::user()->role == 'pelanggan' ? route('pelanggan.layanan') : '#pet-shop' }}">Pet Shop</a>

            @guest
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            @else
                <a href="{{
                    Auth::user()->role == 'owner' ? route('dashboard.admin') : (
                    Auth::user()->role == 'dokter' ? route('dashboard.dokter') : (
                    Auth::user()->role == 'pelanggan' ? route('dashboard.pelanggan') :
                    route('dashboard.staff')))
                }}" class="btn-dashboard">Ke Dashboard</a>
            @endguest
        </div>
    </nav>
    <header class="hero">
        <h1>Pusat Kesehatan & Perawatan Hewan Terpadu</h1>
        <p>Percayakan kesehatan, kebersihan, dan kebutuhan nutrisi anabul kesayangan Anda pada tim ahli kami. Layanan lengkap, cepat, dan profesional.</p>
        <a href="#layanan" class="btn-hero">Lihat Layanan Kami</a>
    </header>

    <section id="tentang" class="section">
        <h2 class="section-title">Mengapa Memilih D&F Pets?</h2>
        <p class="section-subtitle">Kami berkomitmen memberikan yang terbaik untuk sahabat berbulu Anda.</p>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">🏥</div>
                <h3 style="color: #333; margin-bottom: 10px;">Fasilitas Terpadu</h3>
                <p style="font-size: 14px; color: #666;">Klinik, pet shop, grooming, dan hotel hewan dalam satu lokasi untuk kemudahan Anda.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">👨‍⚕️</div>
                <h3 style="color: #333; margin-bottom: 10px;">Tenaga Profesional</h3>
                <p style="font-size: 14px; color: #666;">Ditangani langsung oleh dokter hewan bersertifikat dan staf grooming berpengalaman.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📱</div>
                <h3 style="color: #333; margin-bottom: 10px;">Sistem Digital</h3>
                <p style="font-size: 14px; color: #666;">Reservasi online, rekam medis digital, dan antrean real-time tanpa perlu repot menunggu lama.</p>
            </div>
        </div>
    </section>

    <section id="dokter" class="section doctor-section">
        <h2 class="section-title">Kenalan dengan Dokter Kami</h2>
        <p class="section-subtitle">Tim medis yang ramah, ahli, dan penuh kasih sayang terhadap hewan peliharaan.</p>
        <div class="doctor-grid">
            <div class="doctor-card">
                <div class="doctor-photo">👨‍⚕️</div>
                <h3 class="doctor-name">drh. Aditya Lanang W </h3>
                <div class="doctor-spec">Spesialis Bedah & Jaringan Lunak</div>
                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Berpengalaman lebih dari 8 tahun dalam menangani operasi caesar, sterilisasi, dan trauma pada hewan kecil.</p>
                <div class="doctor-schedule">
                    <strong>Jadwal Praktik:</strong><br>Senin - Rabu: 09.00 - 15.00 WIB<br>Jumat: 13.00 - 20.00 WIB
                </div>
            </div>
            <div class="doctor-card">
                <div class="doctor-photo">👩‍⚕️</div>
                <h3 class="doctor-name">drh. Arifa Nurjayanti</h3>
                <div class="doctor-spec">Perawatan Mata & Penyakit Dalam</div>
                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Fokus pada pencegahan penyakit menular, scaling karang gigi, dan konsultasi nutrisi diet hewan.</p>
                <div class="doctor-schedule">
                    <strong>Jadwal Praktik:</strong><br>Kamis - Sabtu: 09.00 - 16.00 WIB<br>Minggu: 10.00 - 14.00 WIB
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="section" style="background-color: #E6E6FA;">
        <h2 class="section-title">Layanan Favorit</h2>
        <p class="section-subtitle">Reservasi layanan kami dengan mudah melalui website.</p>
        <div class="grid-container">
            <div class="card">
                <div class="card-img">🩺</div>
                <h3 class="card-title">Konsultasi Medis</h3>
                <p class="card-desc">Pemeriksaan kesehatan menyeluruh, diagnosa penyakit, dan pengobatan.</p>
                <div class="card-price">Rp 100.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Reservasi Jadwal</button>
                @else
                    <button type="button" class="btn-action" onclick="openResModal('LYN-001', 'Konsultasi Medis', '100000')">Reservasi Jadwal</button>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">💉</div>
                <h3 class="card-title">Vaksinasi Lengkap</h3>
                <p class="card-desc">Vaksinasi rutin untuk perlindungan dari virus berbahaya seperti panleukopenia dan rabies.</p>
                <div class="card-price">Rp 180.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Reservasi Jadwal</button>
                @else
                    <button type="button" class="btn-action" onclick="openResModal('LYN-002', 'Vaksinasi Lengkap', '180000')">Reservasi Jadwal</button>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🛁</div>
                <h3 class="card-title">Grooming Sehat</h3>
                <p class="card-desc">Mandi jamur/kutu, potong kuku, bersihkan telinga, dan perapian bulu.</p>
                <div class="card-price">Rp 80.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Reservasi Grooming</button>
                @else
                    <button type="button" class="btn-action" onclick="openResModal('LYN-003', 'Grooming Sehat', '80000')">Reservasi Grooming</button>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🏨</div>
                <h3 class="card-title">Pet Hotel Premium</h3>
                <p class="card-desc">Penitipan hewan dengan ruangan ber-AC, update via WhatsApp, dan free play time (Harga per hari).</p>
                <div class="card-price">Rp 50.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Pesan Kamar</button>
                @else
                    <button type="button" class="btn-action" onclick="openResModal('LYN-004', 'Pet Hotel Premium (1 Hari)', '50000')">Pesan Kamar</button>
                @endguest
            </div>
        </div>
    </section>

    <section id="produk" class="section">
        <h2 class="section-title">Katalog Pet Shop</h2>
        <p class="section-subtitle">Kebutuhan nutrisi dan aksesoris harian tersedia di sini.</p>
        <div class="grid-container">
            <div class="card">
                <div class="card-img">🥩</div>
                <h3 class="card-title">Royal Canin Kitten (1kg)</h3>
                <p class="card-desc">Makanan kering khusus anak kucing dengan nutrisi seimbang untuk masa pertumbuhan.</p>
                <div class="card-price">Rp 155.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-001">
                        <input type="hidden" name="name" value="Royal Canin Kitten (1kg)">
                        <input type="hidden" name="price" value="155000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🧴</div>
                <h3 class="card-title">NutriPlus Gel (120g)</h3>
                <p class="card-desc">Suplemen multivitamin tinggi energi untuk pemulihan dan nafsu makan hewan peliharaan.</p>
                <div class="card-price">Rp 120.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-002">
                        <input type="hidden" name="name" value="NutriPlus Gel (120g)">
                        <input type="hidden" name="price" value="120000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🐈</div>
                <h3 class="card-title">Pasir Kucing Gumpal (5L)</h3>
                <p class="card-desc">Pasir wangi bentonite yang cepat menggumpal dan efektif menyerap bau tidak sedap.</p>
                <div class="card-price">Rp 45.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-003">
                        <input type="hidden" name="name" value="Pasir Kucing Gumpal (5L)">
                        <input type="hidden" name="price" value="45000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🧸</div>
                <h3 class="card-title">Mainan Tongkat Bulu</h3>
                <p class="card-desc">Mainan interaktif dengan bulu dan lonceng untuk menstimulasi insting berburu kucing.</p>
                <div class="card-price">Rp 15.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-004">
                        <input type="hidden" name="name" value="Mainan Tongkat Bulu">
                        <input type="hidden" name="price" value="15000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🧼</div>
                <h3 class="card-title">Shampo Anti Kutu (250ml)</h3>
                <p class="card-desc">Formulasi khusus untuk membasmi kutu dan telur kutu pada anjing dan kucing.</p>
                <div class="card-price">Rp 55.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-005">
                        <input type="hidden" name="name" value="Shampo Anti Kutu (250ml)">
                        <input type="hidden" name="price" value="55000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🦴</div>
                <h3 class="card-title">Snack Dental Tulang (Anjing)</h3>
                <p class="card-desc">Camilan yang dirancang untuk membersihkan plak dan karang gigi anjing.</p>
                <div class="card-price">Rp 35.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-006">
                        <input type="hidden" name="name" value="Snack Dental Tulang (Anjing)">
                        <input type="hidden" name="price" value="35000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🎀</div>
                <h3 class="card-title">Kalung Lonceng Kulit</h3>
                <p class="card-desc">Kalung kulit sintetis warna-warni yang nyaman dengan lonceng kecil untuk kucing.</p>
                <div class="card-price">Rp 20.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-007">
                        <input type="hidden" name="name" value="Kalung Lonceng Kulit">
                        <input type="hidden" name="price" value="20000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
            <div class="card">
                <div class="card-img">🥣</div>
                <h3 class="card-title">Tempat Makan Anti Semut</h3>
                <p class="card-desc">Mangkuk makan plastik ganda dengan pinggiran yang dapat diisi air agar semut tidak naik.</p>
                <div class="card-price">Rp 25.000</div>
                @guest
                    <button class="btn-action" onclick="openModal()">Tambah ke Keranjang</button>
                @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="PRD-008">
                        <input type="hidden" name="name" value="Tempat Makan Anti Semut">
                        <input type="hidden" name="price" value="25000">
                        <input type="hidden" name="type" value="Produk">
                        <button type="submit" class="btn-action" style="width: 100%;">Tambah ke Keranjang</button>
                    </form>
                @endguest
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-grid">
            <div>
                <h3>🐾 D&F Pets</h3>
                <p>Sistem Informasi Terintegrasi Paw Center. Memberikan solusi terbaik untuk manajemen klinik hewan dan layanan pelanggan secara digital.</p>
            </div>
            <div>
                <h3>Navigasi Cepat</h3>
                <ul>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#layanan">Layanan Klinik</a></li>
                    <li><a href="#dokter">Profil Dokter</a></li>
                    <li><a href="#produk">Belanja Produk</a></li>
                </ul>
            </div>
            <div>
                <h3>Hubungi Kami</h3>
                <p>📍 Jl. Karang Tengah Raya, Lebak Bulus, Jakarta Selatan</p>
                <p>📞 0822-1122-2233</p>
                <p>✉️ hello@dnfpets.com</p>
                <p>🕒 <strong>Buka:</strong> Setiap Hari (08.00 - 20.00 WIB)</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 D&F Pet Shop & Clinic. Developed by Paw Center System.
        </div>
    </footer>

        <div id="modalDaftar" class="modal-overlay">
        <div class="modal-box">
            <span class="close-btn" onclick="closeModal('modalDaftar')">&times;</span>
            <h2>Buat Akun Paw Center</h2>
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div class="form-group">
                    <label>Alamat Email</label>
                    <input type="email" name="email" placeholder="Contoh: user@dnfpets.com" required>
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                </div>
                <button type="submit" class="btn-submit">Daftar Sekarang</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 14px;">
                Sudah punya akun? <a href="javascript:void(0)" onclick="switchModal('modalDaftar', 'modalLogin')" style="color: #800080; font-weight: bold;">Masuk di sini</a>
            </p>
        </div>
    </div>

    <div id="loginModal" class="modal-overlay">
        <div class="modal-box">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Masuk ke Paw Center</h2>
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email / Username</label>
                    <input type="email" id="email" name="email" required placeholder="Contoh: user@dnfpets.com">
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi">
                </div>
                <button type="submit" class="btn-submit">Masuk ke Dashboard</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 14px;">Belum punya akun? <a href="#" style="color: #800080; font-weight: bold;">Daftar di sini</a></p>
        </div>
    </div>

    <div id="reservationModal" class="modal-overlay">
        <div class="modal-box">
            <span class="close-btn" onclick="closeResModal()">&times;</span>
            <h2>Form Reservasi Jadwal</h2>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="res_id">
                <input type="hidden" name="name" id="res_name">
                <input type="hidden" name="price" id="res_price">
                <input type="hidden" name="type" value="Layanan">

                <div class="form-group">
                    <label>Layanan yang Dipilih</label>
                    <input type="text" id="res_display_name" readonly style="background: #eee; cursor: not-allowed; color: #800080; font-weight: bold;">
                </div>

                <div class="form-group">
                    <label for="pet_name">Nama Hewan Peliharaan</label>
                    <input type="text" id="pet_name" name="pet_name" required placeholder="Contoh: Mochi (Kucing)">
                </div>

                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="schedule_date">Tanggal</label>
                        <input type="date" id="schedule_date" name="schedule_date" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="schedule_time">Waktu Kunjungan</label>
                        <input type="time" id="schedule_time" name="schedule_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Keluhan Utama / Catatan Khusus</label>
                    <input type="text" id="notes" name="notes" placeholder="Contoh: Kucing saya flu, atau Mau potong kuku">
                </div>

                <button type="submit" class="btn-submit">Simpan & Masukkan Keranjang</button>
            </form>
        </div>
    </div>

    <script>
        // Modal Login
        const modal = document.getElementById('loginModal');
        function openModal() { modal.style.display = 'flex'; }
        function closeModal() { modal.style.display = 'none'; }

        // Modal Reservasi
        const resModal = document.getElementById('reservationModal');
        function openResModal(id, name, price) {
            document.getElementById('res_id').value = id;
            document.getElementById('res_name').value = name;
            document.getElementById('res_price').value = price;
            document.getElementById('res_display_name').value = name;
            resModal.style.display = 'flex';
        }
        function closeResModal() {
            resModal.style.display = 'none';
        }

        // Tutup modal jika area luar di-klik
        window.onclick = function(event) {
            if (event.target == modal) closeModal();
            if (event.target == resModal) closeResModal();
        }

        // Pertahankan posisi scroll saat refresh
        window.addEventListener('beforeunload', function() {
            localStorage.setItem('posisiScroll', window.scrollY);
        });

        window.addEventListener('load', function() {
            const posisiScroll = localStorage.getItem('posisiScroll');
            if (posisiScroll !== null) {
                window.scrollTo({ top: parseInt(posisiScroll), behavior: 'instant' });
                localStorage.removeItem('posisiScroll');
            }
        });
    </script>
</body>
</html>
