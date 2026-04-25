<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Pastikan nama Model di bawah ini sesuai dengan yang kamu buat ya!
use App\Models\Produk;
use App\Models\Layanan;

class KatalogController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel produk dan layanan
        $produk = Produk::all();
        $layanan = Layanan::all();

        // Mengirimkan data tersebut ke file view dashboard/katalog.blade.php
        return view('dashboard.katalog', compact('produk', 'layanan'));
    }
}
