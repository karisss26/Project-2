<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Proses Cek Login
    public function login(Request $request)
    {
        // 1. Validasi inputan
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba cocokkan email dan password ke database
        if (Auth::attempt($credentials)) {
            // 3. Amankan sesi
            $request->session()->regenerate();

            // 4. Cek role user, lalu arahkan ke dashboard
            $role = Auth::user()->role;

            switch ($role) {
                case 'owner':
                case 'admin':
                    return redirect()->route('dashboard.admin');
                case 'kasir':
                case 'staff':
                    return redirect()->route('dashboard.staff');
                case 'dokter':
                    return redirect()->route('dashboard.dokter');
                case 'pelanggan':
                    return redirect()->route('dashboard.pelanggan');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        // Kalau gagal
        return back()->withErrors([
            'email' => 'Maaf sayang, email atau kata sandi kamu salah.',
        ]);
    }

    // Proses Keluar (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil keluar, Sayang!');
    }

    // Tampilkan Halaman Login
    public function showLogin() {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role == 'owner' || $role == 'admin') return redirect()->route('dashboard.admin');
            if ($role == 'kasir' || $role == 'staff') return redirect()->route('dashboard.staff');
            if ($role == 'dokter') return redirect()->route('dashboard.dokter');
            if ($role == 'pelanggan') return redirect()->route('dashboard.pelanggan');
        }

        return view('auth.login');
    }

    // (Opsional) Tambahkan fungsi register kosong ini agar rute register tidak error
    // jika kamu belum buat isinya
    public function register(Request $request) {
        // Logika register di sini
    }

    // Tampilkan Halaman Register
    public function showRegister() {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role == 'owner' || $role == 'admin') return redirect()->route('dashboard.admin');
            if ($role == 'kasir' || $role == 'staff') return redirect()->route('dashboard.staff');
            if ($role == 'dokter') return redirect()->route('dashboard.dokter');
            if ($role == 'pelanggan') return redirect()->route('dashboard.pelanggan');
        }

        // Pastikan kamu udah bikin file resources/views/auth/register.blade.php ya!
        return view('auth.register');
    }
}
