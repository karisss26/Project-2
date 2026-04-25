<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Center - D&F Pet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .sub-judul {
            text-align: center; color: #8E24AA; font-size: 1.3rem; margin: 40px 0 20px; font-weight: 600;
        }
        /* Memaksa area tombol auth agar tidak hilang atau tertutup */
        .auth-btns {
            display: flex !important;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body class="welcome-page">

    <header class="welcome-header">
        <div class="container">
            <div class="logo-area">🐾 Paw Center</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#layanan-produk">Layanan & Produk</a></li>
                    <li><a href="#dokter">Dokter</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>
            <div class="auth-btns">
                @if(Auth::check())
                    @php
                        $role = Auth::user()->role ?? 'pelanggan';
                        $route = 'dashboard.pelanggan';
                        if(in_array($role, ['owner', 'admin'])) $route = 'dashboard.admin';
                        elseif(in_array($role, ['kasir', 'staff'])) $route = 'dashboard.staff';
                        elseif($role == 'dokter') $route = 'dashboard.dokter';
                    @endphp
                    <a href="{{ route($route) }}" class="btn btn-dark" style="border-radius: 25px; padding: 8px 20px;">Dashboard</a>
                @else
                    <a href="{{ url('/login') }}" class="btn btn-dark" style="border-radius: 25px; padding: 8px 20px;">Masuk</a>
                    <a href="{{ url('/register') }}" class="btn btn-outline" style="border-radius: 25px; padding: 8px 20px; border: 1px solid #333;">Daftar</a>
                @endif
            </div>
        </div>
    </header>

    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-text">
                <div class="hero-tag">Layanan Kesehatan Hewan Terbaik</div>
                <h1 class="hero-title">Jadwalkan Kunjungan & Penuhi Kebutuhan Hewan Peliharaan Kesayangan Anda di D&F Pet Shop</h1>
                <p class="hero-desc">Sistem terpadu layanan reservasi klinik, rekam medis, pet hotel, dan e-commerce terlengkap di Subang.</p>
                </div>
            <div class="hero-img-container" style="background-image: url('https://images.unsplash.com/photo-1583337130417-3346a1be7dee?q=80&w=800&auto=format&fit=crop');"></div>
        </div>
    </section>

    <section class="profil" id="tentang">
        <div class="container">
            <h2 class="section-title">Profil D&F Petshop</h2>
            <div class="profil-content">
                <div class="profil-img" style="background-image: url('https://images.unsplash.com/photo-1628009368231-7bb7cbcb8127?q=80&w=800&auto=format&fit=crop');"></div>
                <div class="profil-text">
                    <p>Kami memahami bahwa hewan peliharaan adalah bagian dari keluarga Anda. Oleh karena itu, kami berkomitmen untuk memberikan perawatan medis dengan penuh kasih sayang dan profesional.</p>
                    <ul>
                        <li><span style="background:#333; color:white; border-radius:50%; width:20px; height:20px; display:inline-block; text-align:center; line-height:20px; font-size:12px;">✓</span> Dokter Hewan Berpengalaman</li>
                        <li><span style="background:#333; color:white; border-radius:50%; width:20px; height:20px; display:inline-block; text-align:center; line-height:20px; font-size:12px;">✓</span> Fasilitas Medis Modern</li>
                        <li><span style="background:#333; color:white; border-radius:50%; width:20px; height:20px; display:inline-block; text-align:center; line-height:20px; font-size:12px;">✓</span> Pet Shop Terlengkap</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="lokasi">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 10px;">Lokasi D&F</h2>
            <p class="lokasi-desc">D&F Pet Shop memiliki dua cabang di Subang, siap melayani berbagai kebutuhan hewan peliharaan kesayangan Anda.</p>
            <div class="maps-grid">
                <a href="https://www.google.com/maps/search/?api=1&query=Jl.+DI.Panjaitan+No.24,+Soklat,+Kec.+Subang,+Kabupaten+Subang" target="_blank" class="map-card">
                    <div class="map-img" style="background-image: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="map-label">D&F Pet Shop & Clinic Cabang 1<br>
                        <span style="font-size:12px; font-weight:normal; color:var(--text-muted);">Jl. DI.Panjaitan No.24, Soklat, Kec. Subang</span>
                    </div>
                </a>
                <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Ion+Martasasmita+No.3,+Rancasari,+Kec.+Pamanukan,+Kabupaten+Subang" target="_blank" class="map-card">
                    <div class="map-img" style="background-image: url('https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="map-label">D&F Pet Shop Cabang 2<br>
                        <span style="font-size:12px; font-weight:normal; color:var(--text-muted);">Jl. Ion Martasasmita No.3, Rancasari, Kec. Pamanukan</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="layanan-produk" id="layanan-produk" style="padding: 60px 0;">
        <div class="container">
            <h2 class="section-title">Layanan & Produk Kami</h2>

            <h3 class="sub-judul">Klinik & Perawatan</h3>
            <div class="layanan-grid">
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1606425271394-c3ca9aa1fc06?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info"><h3>Klinik Hewan</h3><p>Layanan konsultasi dan diagnosa medis hewan.</p></div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1576201836106-db1758fd1c97?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info"><h3>Vaksinasi</h3><p>Pencegahan penyakit menular dan virus berbahaya.</p></div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1584015694208-410712f5a653?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info"><h3>Sterilisasi</h3><p>Tindakan operasi steril untuk mengontrol populasi.</p></div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info"><h3>Pet Grooming</h3><p>Layanan mandi, potong kuku, dan perawatan bulu.</p></div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info"><h3>Pet Hotel</h3><p>Penitipan hewan yang aman, nyaman, dan diawasi 24 jam.</p></div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1606514482705-ebcc5eb93ba5?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info"><h3>Pet Shop</h3><p>Menjual makanan premium, aksesoris & kebutuhan.</p></div>
                </div>
            </div>

            <h3 class="sub-judul">Produk Pilihan</h3>
            <div class="produk-grid">
                <div class="produk-card">
                    <div class="produk-img" style="background-image: url('https://images.unsplash.com/photo-1589924691995-400dc9ecc119?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">ROYAL CANIN KITTEN 2KG</h3>
                        <span class="produk-price">Rp 270.000</span>
                    </div>
                </div>
                <div class="produk-card">
                    <div class="produk-img" style="background-image: url('https://images.unsplash.com/photo-1623366302587-bcaad5cfdb66?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">Cat Choize Adult 800g</h3>
                        <span class="produk-price">Rp 25.000</span>
                    </div>
                </div>
                <div class="produk-card">
                    <div class="produk-img" style="background-image: url('https://images.unsplash.com/photo-1574144611937-0df059b5ef3e?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">FRIESKIES Kitten Pouch 80g</h3>
                        <span class="produk-price">Rp 6.000</span>
                    </div>
                </div>
            </div>

            <div class="btn-center" style="margin-top: 40px;">
                <a href="{{ url('/katalog') }}" class="btn btn-dark" style="border-radius: 8px; padding: 12px 35px; text-decoration: none;">Lihat Semua Layanan & Produk</a>
            </div>
        </div>
    </section>

    <section class="dokter" id="dokter">
        <div class="container dokter-container">
            <h2 class="section-title">Dokter Kami</h2>
            <div class="dokter-row">
                <div class="dokter-img" style="background-image: url('https://images.unsplash.com/photo-1594824436998-dd40e4f69d3c?q=80&w=300&auto=format&fit=crop');"></div>
                <div class="dokter-info">
                    <h3>drh. Nyoman Ayu</h3>
                    <span>Dokter Hewan Kecil</span>
                    <p>Menjadi dokter sekaligus pemilik di D&F Pet Shop & Clinic sejak 2017 hingga saat ini.</p>
                </div>
            </div>
            <div class="dokter-row reverse">
                <div class="dokter-img" style="background-image: url('https://images.unsplash.com/photo-1612349317150-e410f624c427?q=80&w=300&auto=format&fit=crop'); background-position: top;"></div>
                <div class="dokter-info">
                    <h3>drh. Andi Susiro</h3>
                    <span>Dokter Hewan Eksotik</span>
                    <p>Menjadi dokter D&F sejak 2019 dan mengelola cabang kedua untuk penanganan hewan khusus.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container faq-container">
            <h2 class="section-title">Tanyakan Kepada Kami</h2>
            <details>
                <summary>Bagaimana cara jadwalkan layanan grooming & klinik?</summary>
                <div class="faq-content">Anda dapat masuk melalui dashboard pelanggan setelah login. Anda bebas memilih tanggal dan jam operasional dokter.</div>
            </details>
            <details>
                <summary>Apakah saya dapat langsung membeli produk tanpa login?</summary>
                <div class="faq-content">Tidak, untuk proses checkout otomatis disarankan untuk login terlebih dahulu ke akun Paw Center.</div>
            </details>
            <details>
                <summary>Berapa biaya konsultasi dengan dokter?</summary>
                <div class="faq-content">Biaya konsultasi dasar mulai dari Rp. 50.000. Belum termasuk tindakan khusus atau obat-obatan.</div>
            </details>
        </div>
    </section>

    <section class="contact" id="kontak" style="padding: 80px 0; text-align: center;">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 15px; color: var(--purple-900);">Hubungi Kami Sekarang</h2>
            <p style="color: var(--text-muted); font-size: 15px; max-width: 600px; margin: 0 auto 30px; line-height: 1.6;">
                Jika Anda memiliki pertanyaan seputar layanan klinik, stok produk pet shop, atau butuh tindakan darurat, silakan hubungi kami melalui WhatsApp.
            </p>
            <a href="https://wa.me/6285603320626" target="_blank" class="btn" style="background-color: #f3f4f6; color: #333; border: 1px solid #d1d5db; border-radius: 30px; padding: 12px 30px; font-weight: 500; text-decoration: none; display: inline-block;">
                Hubungi Via WhatsApp
            </a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Tentang Kami</h4>
                    <p>D&F Petshop adalah klinik dan pet shop terpercaya di Subang, Jawa Barat, yang menyediakan layanan kesehatan hewan terpadu.</p>
                </div>
                <div class="footer-col">
                    <h4>Layanan Kami</h4>
                    <ul>
                        <li>Klinik Hewan</li>
                        <li>Vaksinasi & Sterilisasi</li>
                        <li>Pet Hotel</li>
                        <li>Grooming Hewan</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul>
                        <li>📍 Jl. Otto Iskandardinata No. 12, Subang</li>
                        <li>📞 0812-3456-7890</li>
                        <li>✉️ cs@dnfpetshop.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                © 2026 Paw Center by D&F Pet Shop. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
