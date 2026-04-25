<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Paw Center - Pusat Perawatan Hewan</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <style>
        /* --- RESET CSS DASAR --- */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        /* --- STYLING HALAMAN --- */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Latar belakang Ungu Muda */
            background-color: #F3E5F5;
            overflow: hidden;
        }

        /* --- STYLING KARTU LOGIN --- */
        .login-card {
            /* Kartu warna Putih */
            background: #FFFFFF;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            /* Bayangan lembut bernuansa ungu */
            box-shadow: 0 15px 35px rgba(106, 27, 154, 0.15);
            width: 100%;
            max-width: 440px;
            text-align: center;
            position: relative;
        }

        /* --- STYLING HEADER --- */
        .header { margin-bottom: 2.5rem; }

        .paw-icon-container {
            width: 80px;
            height: 80px;
            /* Ikon background Ungu Utama */
            background-color: #8E24AA;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1.25rem;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(142, 36, 170, 0.3);
        }

        .header h1 {
            /* Warna teks Ungu Gelap */
            color: #4A148C;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #7B1FA2; /* Ungu medium */
            font-size: 1rem;
            font-weight: 500;
        }

        /* --- STYLING PESAN ERROR --- */
        .error-message {
            background-color: #FFEBEE;
            color: #C62828;
            padding: 1rem;
            border-radius: 8px;
            border-left: 5px solid #C62828;
            margin-bottom: 1.5rem;
            text-align: left;
            font-size: 0.9rem;
        }
        .error-message ul { margin-left: 1.5rem; }

        /* --- STYLING FORM & INPUT --- */
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 600;
            color: #4A148C; /* Ungu gelap */
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #BA68C8; /* Ungu muda untuk ikon */
            font-size: 1.1rem;
        }

        input {
            width: 100%;
            padding: 0.8rem 2.75rem; /* Ruang untuk ikon kiri & kanan */
            border: 2px solid #E1BEE7; /* Border ungu sangat muda */
            border-radius: 8px;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #8E24AA; /* Border ungu saat fokus */
            box-shadow: 0 0 10px rgba(142, 36, 170, 0.1);
        }

        /* Ikon mata untuk show/hide password */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8E24AA;
            font-size: 1.2rem;
            user-select: none;
        }

        /* --- STYLING TOMBOL --- */
        button {
            width: 100%;
            padding: 1rem;
            background: #8E24AA; /* Ungu Utama */
            color: #FFFFFF; /* Putih */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, transform 0.1s ease;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #6A1B9A; /* Ungu lebih gelap saat hover */
        }

        button:active {
            transform: scale(0.98);
        }

        /* --- STYLING FOOTER --- */
        .card-footer {
            margin-top: 2.5rem;
            font-size: 0.9rem;
            color: #7B1FA2;
        }

        .card-footer a {
            color: #8E24AA;
            text-decoration: none;
            font-weight: 600;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="header">
            <div class="paw-icon-container">
                &#x1F43E;
            </div>
            <h1>Paw Center</h1>
            <p>Pusat Perawatan Hewan Kesayangan Anda</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <strong>Waduh, ada masalah!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#x2709;</span>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="budi@pawcenter.com">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#x1F512;</span>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                    <span class="toggle-password" id="togglePassword" title="Lihat Password">👁️</span>
                </div>
            </div>

            <button type="submit">Masuk ke Dashboard</button>
        </form>

        <div class="card-footer">
            <p>Belum punya akun? <a href="{{ url('/register') }}">Daftar Sekarang</a></p>
            <p><a href="forgot-password">Lupa kata sandi?</a></p>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Cek tipe input saat ini
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';

            // Ubah tipe input
            passwordInput.setAttribute('type', type);

            // Ubah ikon mata (bisa pakai emoji monyet tutup mata biar lucu, atau teks)
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>

</body>
</html>
