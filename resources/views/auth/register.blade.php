<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Paw Center</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #F3E5F5; overflow: hidden; }
        .auth-card { background: #FFFFFF; padding: 2.5rem; border-radius: 16px; box-shadow: 0 15px 35px rgba(106, 27, 154, 0.15); width: 100%; max-width: 440px; text-align: center; }
        .header { margin-bottom: 2rem; }
        .header h1 { color: #4A148C; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .header p { color: #7B1FA2; font-size: 0.95rem; }
        .error-message { background-color: #FFEBEE; color: #C62828; padding: 1rem; border-radius: 8px; border-left: 5px solid #C62828; margin-bottom: 1.5rem; text-align: left; font-size: 0.9rem; }
        .form-group { margin-bottom: 1.2rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4A148C; font-size: 0.9rem; }
        input { width: 100%; padding: 0.8rem 1rem; border: 2px solid #E1BEE7; border-radius: 8px; font-size: 1rem; transition: 0.3s; }
        input:focus { outline: none; border-color: #8E24AA; box-shadow: 0 0 10px rgba(142, 36, 170, 0.1); }
        button { width: 100%; padding: 1rem; background: #8E24AA; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: 600; text-transform: uppercase; transition: 0.3s; margin-top: 0.5rem; }
        button:hover { background-color: #6A1B9A; }
        .card-footer { margin-top: 1.5rem; font-size: 0.9rem; color: #7B1FA2; }
        .card-footer a { color: #8E24AA; text-decoration: none; font-weight: 600; }
        .card-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="header">
            <h1>Daftar Akun</h1>
            <p>Gabung bersama Paw Center sekarang</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Karisma Ainun">
            </div>
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" required value="{{ old('email') }}" placeholder="email@contoh.com">
            </div>
            <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter">
            </div>
            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="card-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>
</body>
</html>