<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Kata Sandi | Paw Center</title>
    <style>
        /* Style disamain sama forgot-password.blade.php kamu */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #F3E5F5; overflow: hidden; }
        .auth-card { background: #FFFFFF; padding: 2.5rem; border-radius: 16px; box-shadow: 0 15px 35px rgba(106, 27, 154, 0.15); width: 100%; max-width: 440px; text-align: center; }
        .header { margin-bottom: 2rem; }
        .header h1 { color: #4A148C; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; }
        .header p { color: #7B1FA2; font-size: 0.95rem; }
        .error-message { background-color: #FFEBEE; color: #C62828; padding: 1rem; border-radius: 8px; border-left: 5px solid #C62828; margin-bottom: 1.5rem; text-align: left; font-size: 0.9rem; }
        .form-group { margin-bottom: 1.2rem; text-align: left; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4A148C; font-size: 0.9rem; }

        /* --- CSS ICON DI DALAM INPUT --- */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 12px;
            font-size: 16px;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            cursor: pointer;
            font-size: 16px;
            user-select: none;
            transition: transform 0.2s;
        }
        .toggle-password:hover {
            transform: scale(1.1);
        }

        input { width: 100%; padding: 0.8rem 2.5rem 0.8rem 35px; border: 2px solid #E1BEE7; border-radius: 8px; font-size: 1rem; transition: 0.3s; }
        input:focus { outline: none; border-color: #8E24AA; box-shadow: 0 0 10px rgba(142, 36, 170, 0.1); }

        button { width: 100%; padding: 1rem; background: #8E24AA; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: 600; text-transform: uppercase; transition: 0.3s; margin-top: 10px; }
        button:hover { background-color: #6A1B9A; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="header">
            <h1>Ganti Kata Sandi</h1>
            <p>Silakan masukkan password baru untuk akun kamu.</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">✉️</span>
                    <input type="email" name="email" required placeholder="email@contoh.com" value="{{ old('email', $email ?? '') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#x1F512;</span>
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter">
                    <span class="toggle-password" id="togglePassword" title="Lihat Password">👁️</span>
                </div>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#x1F512;</span>
                    <input type="password" id="password-confirm" name="password_confirmation" required placeholder="Ulangi password baru">
                    <span class="toggle-password" id="togglePasswordConfirm" title="Lihat Password">👁️</span>
                </div>
            </div>

            <button type="submit">Update Password</button>
        </form>
    </div>

    <script>
        // JS Untuk Toggle Password Baru
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        // JS Untuk Toggle Konfirmasi Password Baru
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const confirmInput = document.querySelector('#password-confirm');

        togglePasswordConfirm.addEventListener('click', function () {
            const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>
</html>
