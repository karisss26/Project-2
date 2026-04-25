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
            if (in_array($role, ['owner', 'admin'])) return redirect('/admin/dashboard');
            if (in_array($role, ['kasir', 'staff'])) return redirect('/staff/dashboard');
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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            switch ($role) {
                case 'owner':
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'kasir':
                case 'staff':
                    return redirect('/staff/dashboard');
                case 'dokter':
                    return redirect('/dokter/dashboard');
                case 'pelanggan':
                    return redirect('/dashboard'); // Ganti di sini juga sayang
                default:
                    Auth::logout();
                    return back()->withInput()->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        return back()->withInput()->withErrors([
            'email' => 'Maaf sayang, email atau kata sandi kamu salah.',
        ]);
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
