<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLogin() {
        if (Auth::check()) {
            $role = Auth::user()->role;
            // Kita ganti redirect()->route() jadi redirect() langsung ke URL
            if (in_array($role, ['owner'])) return redirect('/owner/dashboard');
            if (in_array($role, ['admin', 'kasir'])) return redirect('/admin/dashboard');
            if (in_array($role, ['staff'])) return redirect('/staff/dashboard');
            if ($role == 'dokter') return redirect('/dokter/dashboard');
            if ($role == 'pelanggan') return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function showRegister() {
        if (Auth::check()) return redirect('/dashboard');
        return view('auth.register');
    }

    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    // Proses Cek Login
public function login(Request $request)
{
    // Validasi input email dan password
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Mengecek apakah email dan password cocok
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // 👇 INI BAGIAN PINTARNYA: Ambil data role yang login
        $role = Auth::user()->role;

        // Cek rolenya dan arahkan ke rute yang sesuai
        if ($role === 'owner') {
            return redirect()->route('dashboard.owner');
        } elseif ($role === 'admin' || $role === 'kasir') {
            return redirect()->route('dashboard.admin');
        } elseif ($role === 'staff') {
            return redirect()->route('dashboard.staff');
        } elseif ($role === 'dokter') {
            return redirect()->route('dashboard.dokter');
        } else {
            return redirect()->route('dashboard.pelanggan');
        }
    }

    // Jika password atau email salah, kembalikan ke halaman login bawa pesan error
    return back()->withErrors([
        'email' => 'Maaf, email atau kata sandi kamu salah.',
    ])->onlyInput('email');
}

    // Proses Mendaftar
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard')->with('success', 'Berhasil mendaftar!'); // URL Langsung
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Berhasil keluar!');
    }
}
