<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paw Center - D&F Pet Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* === RESET & GLOBAL VARIABLES === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #FFFFFF;
            color: #333333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 5%;
        }

        section {
            padding: 80px 0;
        }

        /* === BUTTONS === */
        .btn {
            padding: 10px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-dark {
            background-color: #333333;
            color: #FFFFFF;
        }

        .btn-dark:hover {
            background-color: #555555;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #333333;
            color: #333333;
        }

        /* === HEADER / NAVBAR === */
        header {
            padding: 15px 0;
            border-bottom: 1px solid #EAEAEA;
            background-color: #FFFFFF;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 18px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            font-size: 14px;
            font-weight: 500;
        }

        .auth-btns {
            display: flex;
            gap: 10px;
        }

        /* === HERO SECTION === */
        .hero {
            background-color: #F4F4F4;
        }

        .hero .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .hero-text {
            flex: 1;
            max-width: 500px;
        }

        .hero-tag {
            display: inline-block;
            background-color: #E0E0E0;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .hero-title {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 15px;
        }

        .hero-desc {
            font-size: 14px;
            color: #666666;
            margin-bottom: 30px;
        }

        /* Placeholder kotak abu-abu di wireframe */
        .img-placeholder {
            background-color: #444444;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
        }

        .hero-img {
            flex: 1;
            height: 350px;
        }

        /* === PROFIL SECTION === */
        .profil .container {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .profil-img {
            flex: 1;
            height: 300px;
        }

        .profil-text {
            flex: 1;
        }

        .profil-text h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .profil-text p {
            font-size: 14px;
            color: #666666;
            margin-bottom: 20px;
        }

        .profil-text ul li {
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #444;
        }

        .profil-text ul li i {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-color: #333;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-size: 10px;
            font-style: normal;
        }

        /* === LOKASI SECTION === */
        .lokasi {
            text-align: center;
            padding-top: 0;
        }

        .lokasi h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .lokasi p {
            font-size: 14px;
            color: #666;
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .maps-grid {
            display: flex;
            gap: 30px;
            justify-content: center;
        }

        .map-card {
            width: 45%;
            position: relative;
        }

        .map-img {
            height: 200px;
            background-color: #E0E0E0;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .map-label {
            background-color: #FFFFFF;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            text-align: left;
            position: absolute;
            bottom: -20px;
            left: 5%;
            right: 5%;
            font-size: 14px;
            font-weight: 600;
        }

        /* === LAYANAN SECTION === */
        .layanan {
            background-color: #F4F4F4;
            text-align: center;
            margin-top: 40px;
        }

        .layanan h2 {
            font-size: 24px;
            margin-bottom: 40px;
        }

        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .layanan-card {
            background-color: #FFFFFF;
            border-radius: 8px;
            overflow: hidden;
            text-align: left;
            border: 1px solid #EAEAEA;
        }

        .layanan-img {
            height: 140px;
            background-color: #555555;
        }

        .layanan-info {
            padding: 20px;
            display: flex;
            gap: 15px;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            background-color: #F0F0F0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: bold;
        }

        .layanan-text h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .layanan-text p {
            font-size: 12px;
            color: #666;
        }

        .btn-center {
            margin-top: 40px;
        }

        /* === PRODUK SECTION === */
        .produk {
            text-align: center;
        }

        .produk h2 {
            font-size: 24px;
            margin-bottom: 40px;
        }

        .produk-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .produk-card {
            text-align: left;
            border: 1px solid #EAEAEA;
            border-radius: 8px;
            padding-bottom: 15px;
        }

        .produk-img {
            height: 220px;
            background-color: #C4C4C4;
            border-radius: 8px 8px 0 0;
            margin-bottom: 15px;
        }

        .produk-info {
            padding: 0 15px;
        }

        .produk-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .produk-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .produk-price {
            font-size: 16px;
            font-weight: 700;
        }

        .produk-cart {
            font-size: 12px;
            color: #666;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .page-item {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F4F4F4;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .page-item.active {
            background-color: #333;
            color: white;
        }

        /* === DOKTER SECTION === */
        .dokter .container {
            max-width: 800px;
        }

        .dokter h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 50px;
        }

        .dokter-row {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
        }

        .dokter-row.reverse {
            flex-direction: row-reverse;
            text-align: right;
        }

        .dokter-img {
            width: 140px;
            height: 140px;
            background-color: #333333;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dokter-info h3 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .dokter-info span {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 10px;
        }

        .dokter-info p {
            font-size: 14px;
        }

        /* === FAQ SECTION === */
        .faq {
            background-color: #F4F4F4;
        }

        .faq .container {
            max-width: 700px;
        }

        .faq h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
        }

        details {
            background-color: #FFFFFF;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        summary {
            padding: 15px 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        summary::after {
            content: '⌄';
            font-size: 18px;
        }

        details[open] summary::after {
            content: '⌃';
        }

        .faq-content {
            padding: 0 20px 20px;
            font-size: 13px;
            color: #666;
        }

        /* === CONTACT SECTION === */
        .contact {
            text-align: center;
            padding: 60px 0;
        }

        .contact h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .contact p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .btn-light {
            background-color: #EAEAEA;
            color: #333;
            font-weight: 600;
        }

        /* === FOOTER === */
        footer {
            background-color: #1A1A1A;
            color: #FFFFFF;
            padding: 60px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h4 {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .footer-col p, .footer-col ul li {
            font-size: 13px;
            color: #AAAAAA;
            margin-bottom: 12px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #333333;
            font-size: 12px;
            color: #888;
        }

    </style>
</head>
<body>

    <header>
        <div class="container">
            <div class="logo-area">
                <span>🐾 D&F Pet Shop</span>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Layanan</a></li>
                    <li><a href="#">Belanja</a></li>
                    <li><a href="#">Dokter</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </nav>
        <div class="auth-btns">
            <a href="/login" class="btn btn-dark">Masuk</a>
            <a href="/register" class="btn btn-outline">Daftar</a>
        </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-text">
                <div class="hero-tag">Layanan Kesehatan Hewan Terbaik</div>
                <h1 class="hero-title">Jadwalkan Kunjungan & Penuhi Kebutuhan Hewan Peliharaan Kesayangan Anda di D&F Pet</h1>
                <p class="hero-desc">Sistem terpadu layanan reservasi, rekam medis, dan e-commerce terlengkap di Subang.</p>
                <a href="#layanan" class="btn btn-dark">Lihat Selengkapnya</a>
            </div>
            <div class="hero-img img-placeholder">
                [ Area Gambar Hero ]
            </div>
        </div>
    </section>

    <section class="profil" id="tentang">
        <div class="container">
            <div class="profil-img img-placeholder">
                [ Gambar Pet Shop ]
            </div>
            <div class="profil-text">
                <h2>Profil D&F Petshop</h2>
                <p>Kami memahami bahwa hewan peliharaan adalah bagian dari keluarga Anda. Oleh karena itu, kami berkomitmen untuk memberikan perawatan medis dengan penuh kasih sayang dan profesional.</p>
                <ul>
                    <li><i>✓</i> Dokter Hewan Berpengalaman</li>
                    <li><i>✓</i> Fasilitas Medis Modern</li>
                    <li><i>✓</i> Pet Shop Terlengkap</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="lokasi">
        <div class="container">
            <h2>Lokasi D&F</h2>
            <p>D&F Pet Shop memiliki dua cabang di Subang, siap melayani berbagai kebutuhan hewan peliharaan kesayangan Anda.</p>
            <div class="maps-grid">
                <div class="map-card">
                    <div class="map-img img-placeholder"></div>
                    <div class="map-label">D&F Pet Shop & Clinic Cabang 1<br><span style="font-size:12px; font-weight:normal;">Jl. [...]</span></div>
                </div>
                <div class="map-card">
                    <div class="map-img img-placeholder"></div>
                    <div class="map-label">D&F Pet Shop Cabang 2<br><span style="font-size:12px; font-weight:normal;">Jl. [...]</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="layanan" id="layanan">
        <div class="container">
            <h2>Layanan Kami</h2>
            <div class="layanan-grid">
                <div class="layanan-card">
                    <div class="layanan-img img-placeholder"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🩺</div>
                        <div class="layanan-text">
                            <h3>Klinik Hewan</h3>
                            <p>Layanan konsultasi dan diagnosa hewan peliharaan.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img img-placeholder"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">💉</div>
                        <div class="layanan-text">
                            <h3>Vaksinasi</h3>
                            <p>Pencegahan penyakit menular pada hewan peliharaan.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img img-placeholder"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">✂️</div>
                        <div class="layanan-text">
                            <h3>Sterilisasi</h3>
                            <p>Tindakan operasi steril untuk mengontrol populasi.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img img-placeholder"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🛁</div>
                        <div class="layanan-text">
                            <h3>Pet Grooming</h3>
                            <p>Layanan mandi, potong kuku, dan perawatan bulu.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img img-placeholder"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🏨</div>
                        <div class="layanan-text">
                            <h3>Pet Hotel</h3>
                            <p>Penitipan hewan yang aman dan nyaman.</p>
                        </div>
                    </div>
                </div>
                <div class="layanan-card">
                    <div class="layanan-img img-placeholder"></div>
                    <div class="layanan-info">
                        <div class="icon-circle">🛍️</div>
                        <div class="layanan-text">
                            <h3>Pet Shop</h3>
                            <p>Menjual makanan, aksesoris & kebutuhan hewan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="btn btn-dark btn-center">Lihat Semua</a>
        </div>
    </section>

    <section class="produk" id="belanja">
        <div class="container">
            <h2>Belanja Kebutuhan Hewan</h2>
            <div class="produk-grid">
                <div class="produk-card">
                    <div class="produk-img"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">ROYAL CANIN KITTEN 2KG Makanan Anak Kucing</h3>
                        <div class="produk-price-row">
                            <span class="produk-price">Rp. 270.000</span>
                            <span class="produk-cart">🛒 2 Terjual</span>
                        </div>
                    </div>
                </div>
                <div class="produk-card">
                    <div class="produk-img"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">Cat Choize Adult Fresh Salmon - 800g</h3>
                        <div class="produk-price-row">
                            <span class="produk-price">Rp. 25.000</span>
                            <span class="produk-cart">🛒 5 Terjual</span>
                        </div>
                    </div>
                </div>
                <div class="produk-card">
                    <div class="produk-img"></div>
                    <div class="produk-info">
                        <h3 class="produk-title">FRIESKIES Kitten Makanan Kucing Basah Pouch...</h3>
                        <div class="produk-price-row">
                            <span class="produk-price">Rp. 6.000</span>
                            <span class="produk-cart">🛒 10 Terjual</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pagination">
                <div class="page-item">&laquo;</div>
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item">&raquo;</div>
            </div>
            <a href="#" class="btn btn-dark">Semua Kategori</a>
        </div>
    </section>

    <section class="dokter" id="dokter">
        <div class="container">
            <h2>Dokter</h2>

            <div class="dokter-row">
                <div class="dokter-img"></div>
                <div class="dokter-info">
                    <h3>drh. Nyoman Ayu</h3>
                    <span>Dokter Hewan Hewan Kecil</span>
                    <p>Menjadi dokter sekaligus pemilik di D&F Sekitar sejak 2017 hingga saat ini.</p>
                </div>
            </div>

            <div class="dokter-row reverse">
                <div class="dokter-img"></div>
                <div class="dokter-info">
                    <h3>drh. Andi Susiro</h3>
                    <span>Dokter Hewan Hewan Eksotik</span>
                    <p>Menjadi dokter D&F Sekitar sejak 2019 dan mengelola cabang Perumahan.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container">
            <h2>Tanyakan Kepada Kami</h2>

            <details>
                <summary>Bagaimana cara jadwalkan layanan grooming & klinik?</summary>
                <div class="faq-content">Anda dapat menekan tombol "Reservasi Layanan" atau melalui dashboard setelah login.</div>
            </details>
            <details>
                <summary>Apakah saya dapat langsung membeli produk tanpa login?</summary>
                <div class="faq-content">Bisa, tetapi untuk proses checkout dan rekam medis pembelian disarankan untuk login terlebih dahulu.</div>
            </details>
            <details>
                <summary>Berapa biaya konsultasi dengan dokter?</summary>
                <div class="faq-content">Biaya konsultasi dasar mulai dari Rp. 50.000, belum termasuk tindakan atau obat-obatan.</div>
            </details>
            <details>
                <summary>Apakah D&F menerima hewan berukuran besar?</summary>
                <div class="faq-content">Ya, kami memiliki fasilitas untuk anjing trah besar. Silakan hubungi admin untuk info lebih lanjut.</div>
            </details>
        </div>
    </section>

    <section class="contact">
        <div class="container">
            <h2>Hubungi Kami Sekarang</h2>
            <p>Jika Anda memiliki pertanyaan seputar layanan yang ada di klinik dan pet shop kami, silakan hubungi kami melalui tombol chat WhatsApp.</p>
            <a href="#" class="btn btn-light">Hubungi Via WhatsApp</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Tentang Kami</h4>
                    <p>D&F Petshop adalah klinik dan petshop terpercaya di Subang, Jawa Barat, yang menyediakan layanan kesehatan hewan terpadu dengan tim profesional dan fasilitas medis yang lengkap dan memadai.</p>
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
                        <li>📍 Jl. [...] No. XX, Subang</li>
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
                &copy; 2026 D&F Pet Shop. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
