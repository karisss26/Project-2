<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Center - D&F Pet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="welcome-page">

    <header class="welcome-header">
        <div class="container">
            <div class="logo-area">🐾 Paw Center</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#belanja">Belanja</a></li>
                    <li><a href="#dokter">Dokter</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>
            <div class="auth-btns">
                <a href="{{ url('/login') }}" class="btn btn-dark" style="border-radius: 25px; padding: 8px 20px;">Masuk</a>
                <a href="{{ url('/register') }}" class="btn btn-outline" style="border-radius: 25px; padding: 8px 20px;">Daftar</a>
            </div>
        </div>
    </header>

    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-text">
                <div class="hero-tag">Layanan Kesehatan Hewan Terbaik</div>
                <h1 class="hero-title">Jadwalkan Kunjungan & Penuhi Kebutuhan Hewan Peliharaan Kesayangan Anda di D&F Pet</h1>
                <p class="hero-desc">Sistem terpadu layanan reservasi klinik, rekam medis, pet hotel, dan e-commerce terlengkap di Subang.</p>
                <a href="#layanan" class="btn btn-dark" style="border-radius: 25px;">Lihat Selengkapnya</a>
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
                <a href="https://maps.app.goo.gl/xxqApHvC4yykGRTD7" target="_blank" class="map-card">
                    <div class="map-img" style="background-image: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="map-label">D&F Pet Shop & Clinic Cabang 1<br>
                        <span style="font-size:12px; font-weight:normal; color:var(--text-muted);">Jl. DI.Panjaitan No.24, Soklat, Kec. Subang, Kabupaten Subang, Jawa Barat 51214</span>
                    </div>
                </a>

                <a href="https://maps.app.goo.gl/TxGVGoUtfKUuNPh67" target="_blank" class="map-card">
                    <div class="map-img" style="background-image: url('https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?q=80&w=600&auto=format&fit=crop');"></div>
                    <div class="map-label">D&F Pet Shop Cabang 2<br>
                        <span style="font-size:12px; font-weight:normal; color:var(--text-muted);">Jl. Ion Martasasmita No.3, Rancasari, Kec. Pamanukan, Kabupaten Subang, Jawa Barat 41254</span>
                    </div>
                </a>
            </div>

        </div>
    </section>

    <section class="layanan" id="layanan">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="layanan-grid">
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1606425271394-c3ca9aa1fc06?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🩺</div>
                        <div class="layanan-text">
                            <h3>Klinik Hewan</h3>
                            <p>Layanan konsultasi dan diagnosa medis hewan peliharaan.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1576201836106-db1758fd1c97?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">💉</div>
                        <div class="layanan-text">
                            <h3>Vaksinasi</h3>
                            <p>Pencegahan penyakit menular dan virus berbahaya.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1584015694208-410712f5a653?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">✂️</div>
                        <div class="layanan-text">
                            <h3>Sterilisasi</h3>
                            <p>Tindakan operasi steril untuk mengontrol populasi hewan.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🛁</div>
                        <div class="layanan-text">
                            <h3>Pet Grooming</h3>
                            <p>Layanan mandi, potong kuku, dan perawatan bulu rapi.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🏨</div>
                        <div class="layanan-text">
                            <h3>Pet Hotel</h3>
                            <p>Penitipan hewan yang aman, nyaman, dan diawasi 24 jam.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img" style="background-image: url('https://images.unsplash.com/photo-1606514482705-ebcc5eb93ba5?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🛍️</div>
                        <div class="layanan-text">
                            <h3>Pet Shop</h3>
                            <p>Menjual makanan premium, aksesoris & kebutuhan hewan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-center">
                <a href="{{ url('/layanan') }}" class="btn btn-dark" style="border-radius: 8px;">Lihat Semua</a>
            </div>
        </div>
    </section>

<section class="produk" id="belanja">
        <div class="container">
            <h2 class="section-title">Belanja Kebutuhan Hewan</h2>

            <div class="produk-grid">
                <div class="produk-card">
                    <div class="produk-img" style="background-image: url('https://images.unsplash.com/photo-1589924691995-400dc9ecc119?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">ROYAL CANIN KITTEN 2KG Makanan Anak Kucing</h3>
                        <div class="produk-price-row">
                            <span class="produk-price">Rp 270.000</span>
                        </div>
                    </div>
                </div>

                <div class="produk-card">
                    <div class="produk-img" style="background-image: url('https://images.unsplash.com/photo-1623366302587-bcaad5cfdb66?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">Cat Choize Adult Fresh Salmon Dry Food - 800g</h3>
                        <div class="produk-price-row">
                            <span class="produk-price">Rp 25.000</span>
                        </div>
                    </div>
                </div>

                <div class="produk-card">
                    <div class="produk-img" style="background-image: url('https://images.unsplash.com/photo-1574144611937-0df059b5ef3e?q=80&w=400&auto=format&fit=crop');"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">FRIESKIES Kitten Makanan Kucing Basah Pouch 80g</h3>
                        <div class="produk-price-row">
                            <span class="produk-price">Rp 6.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-center" style="margin-top: 20px;">
                <a href="{{ url('/login') }}" class="btn btn-dark" style="border-radius: 8px; padding: 12px 35px;">Lihat Semua</a>
            </div>
        </div>
    </section>

    <section class="dokter" id="dokter">
        <div class="container dokter-container">
            <h2 class="section-title">Dokter</h2>
            <div class="dokter-row">
                <div class="dokter-img" style="background-image: url('https://images.unsplash.com/photo-1594824436998-dd40e4f69d3c?q=80&w=300&auto=format&fit=crop');"></div>
                <div class="dokter-info">
                    <h3>drh. Nyoman Ayu</h3>
                    <span>Dokter Hewan Hewan Kecil</span>
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
            <details>
                <summary>Apakah D&F menerima penitipan hewan berukuran besar?</summary>
                <div class="faq-content">Ya, kami memiliki fasilitas untuk anjing trah besar. Kapasitas terbatas, silakan hubungi admin terlebih dahulu.</div>
            </details>
        </div>
    </section>

    <section class="contact" id="kontak" style="padding: 80px 0; text-align: center;">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 15px; color: var(--purple-900);">Hubungi Kami Sekarang</h2>
            <p style="color: var(--text-muted); font-size: 15px; max-width: 600px; margin: 0 auto 30px; line-height: 1.6;">
                Jika Anda memiliki pertanyaan seputar layanan klinik, stok produk pet shop, atau butuh tindakan darurat, silakan hubungi kami melalui WhatsApp.
            </p>

            <a href="https://wa.me/6285603320626?text=Halo%20Admin%20D%26F%20Pet%20Shop,%20saya%20ingin%20bertanya%20seputar%20layanan%20Paw%20Center."
            target="_blank"
            class="btn"
            style="background-color: #f3f4f6; color: #333; border: 1px solid #d1d5db; border-radius: 30px; padding: 12px 30px; font-weight: 500; text-decoration: none; display: inline-block; transition: all 0.3s ease;">
            Hubungi Via WhatsApp
            </a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Tentang Kami</h4>
                    <p>D&F Petshop adalah klinik dan pet shop terpercaya di Subang, Jawa Barat, yang menyediakan layanan kesehatan hewan terpadu dengan tim profesional dan fasilitas medis yang lengkap.</p>
                </div>
                <div class="footer-col">
                    <h4>Layanan Kami</h4>
                    <ul>
                        <li>Klinik Hewan</li>
                        <li>Vaksinasi</li>
                        <li>Sterilisasi</li>
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
                <div class="footer-col">
                    <h4>Ikuti Kami</h4>
                    <p>Instagram | Facebook | TikTok</p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2026 Paw Center by D&F Pet Shop. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
