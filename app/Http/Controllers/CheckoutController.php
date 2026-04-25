<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Layanan;

class CheckoutController extends Controller
{
    // 1. Menampilkan halaman checkout
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('dashboard.checkout', compact('cart'));
    }

    // 2. Memasukkan barang dari katalog ke keranjang
    public function addToCart(Request $request)
    {
        $id = $request->item_id;
        $tipe = $request->tipe;

        $cart = session()->get('cart', []);
        $cartKey = $tipe . '_' . $id;

        if ($tipe == 'produk') {
            $item = Produk::findOrFail($id);
            $nama = $item->nama_produk;
        } else {
            $item = Layanan::findOrFail($id);
            $nama = $item->nama_layanan;
        }

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['jumlah']++;
        } else {
            $cart[$cartKey] = [
                "id" => $id,
                "nama" => $nama,
                "harga" => $item->harga,
                "tipe" => $tipe,
                "jumlah" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Yey! ' . $nama . ' berhasil masuk ke keranjang 🛒');
    }

    // 3. Mesin Tombol + dan - (INI YANG BIKIN ERROR TADI!)
    public function updateCart(Request $request)
    {
        $id = $request->id;
        $action = $request->action;
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if($action == 'plus') {
                $cart[$id]['jumlah']++;
            } elseif($action == 'minus') {
                $cart[$id]['jumlah']--;

                // Kalau dikurangi sampai 0, hapus sekalian
                if($cart[$id]['jumlah'] <= 0) {
                    unset($cart[$id]);
                }
            }
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    // 4. Mesin Tombol Tong Sampah
    public function removeFromCart(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // 5. Mesin Proses Pembayaran (Buat jaga-jaga kalau tombol "Konfirmasi" ditekan)
    public function process(Request $request)
    {
        // Nantinya logika untuk menyimpan ke database akan ditaruh di sini

        // Sementara ini, kita kosongkan keranjang saja
        session()->forget('cart');

        // Arahkan kembali ke dashboard pelanggan dengan pesan sukses
        return redirect()->route('dashboard.pelanggan')->with('success', 'Pesanan kamu berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }
}
