<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // 1. Fungsi Tambah Barang ke Keranjang
    // Fungsi Tambah Barang ke Keranjang
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        // Bikin ID unik untuk keranjang.
        // Kalau produk biasa, biarin id-nya sama biar kalau dibeli lagi Qty-nya yang nambah.
        // Tapi kalau LAYANAN, kita kasih tambahan waktu (time) biar reservasinya nggak numpuk walau jenisnya sama.
        $cartKey = $request->id;
        if ($request->type == 'Layanan') {
            $cartKey = $request->id . '_' . time();
        }

        // Cek kalau produk udah ada, tambah qty
        if (isset($cart[$cartKey]) && $request->type == 'Produk') {
            $cart[$cartKey]['qty']++;
        } else {
            // Masukin data baru
            $cart[$cartKey] = [
                'name' => $request->name,
                'price' => $request->price,
                'type' => $request->type,
                'qty' => 1,
                // Tambahan khusus untuk form reservasi Layanan
                'pet_name' => $request->pet_name ?? null,
                'schedule_date' => $request->schedule_date ?? null,
                'schedule_time' => $request->schedule_time ?? null,
                'notes' => $request->notes ?? null,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', $request->name . ' berhasil ditambahkan ke keranjang!');
    }

    // Fungsi untuk Tambah (+) atau Kurang (-) Qty
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            if($request->action == 'plus') {
                $cart[$request->id]['qty']++;
            } elseif($request->action == 'minus' && $cart[$request->id]['qty'] > 1) {
                $cart[$request->id]['qty']--;
            }
            session()->put('cart', $cart);
        }
        return back();
    }

    // Fungsi untuk Menghapus Item dari Keranjang
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    // ... (Fungsi index dan process yang sebelumnya tetap ada) ...
    // 2. Menampilkan halaman checkout dinamis
    public function index()
    {
        $cart = session()->get('cart', []);

        $total_produk = 0;
        $total_layanan = 0;

        // Hitung total belanja
        foreach($cart as $item) {
            $subtotal = $item['price'] * $item['qty'];
            if($item['type'] == 'Produk') {
                $total_produk += $subtotal;
            } else {
                $total_layanan += $subtotal;
            }
        }

        $biaya_admin = 2000;
        $total_tagihan = $total_produk + $total_layanan + $biaya_admin;

        // Bawa data hitungan ke file HTML (Blade)
        return view('dashboard.checkout', compact('cart', 'total_produk', 'total_layanan', 'biaya_admin', 'total_tagihan'));
    }

    // 3. Memproses bukti pembayaran
    public function process(Request $request)
    {
        // Hapus keranjang setelah bayar
        session()->forget('cart');

        return redirect()->route('dashboard.pelanggan')
                         ->with('success', 'Pembayaran QRIS berhasil diunggah! Menunggu konfirmasi dari kasir.');
    }
}
