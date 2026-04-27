<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahan wajib
use App\Models\Produk;
use App\Models\Layanan;
use App\Models\hewan; // Tambahan model hewan

class KatalogController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        $layanan = Layanan::all();

        // Ambil data hewan khusus punya pelanggan yang lagi login
        $hewan_user = [];
        if (Auth::check()) {
            $hewan_user = hewan::where('user_id', Auth::id())->get();
        }

        return view('dashboard.katalog', compact('produk', 'layanan', 'hewan_user'));
    }
}
