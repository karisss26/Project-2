<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) {
            $role = Auth::user()->role;
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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role;

            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Login',
                'deskripsi' => $user->name . ' (' . $role . ') masuk ke sistem.'
            ]);

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

        return back()->withErrors([
            'email' => 'Maaf, email atau kata sandi kamu salah.',
        ])->onlyInput('email');
    }

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

        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Register Akun Baru',
            'deskripsi' => $user->name . ' mendaftar sebagai pelanggan baru dan langsung masuk ke sistem.'
        ]);

        return redirect('/dashboard')->with('success', 'Berhasil mendaftar!');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Logout',
                'deskripsi' => $user->name . ' keluar dari sistem.'
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil keluar!');
    }
}
