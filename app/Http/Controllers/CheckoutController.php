<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Layanan;
use App\Models\reservasi; // Wajib dipanggil biar bisa nge-save
use App\Models\Transaksi;
use App\Models\DetilTransaksiProduk;

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
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kamu masih kosong!');
        }

        // Hitung total harga produk
        $totalHarga = 0;
        foreach ($cart as $details) {
            $totalHarga += $details['harga'] * $details['jumlah'];
        }

        // Tambahkan ongkos kirim (jika user pilih delivery)
        $ongkir = $request->input('ongkir', 0);
        $totalHarga += $ongkir;

        // --- LOGIKA STATUS & BUKTI BAYAR ---
        $buktiPath = null;
        $statusAwal = 'Menunggu Pembayaran'; // Status awal default (untuk Cash/Tunai)

        // Kalau bayar pakai Transfer dan ada file yang diupload
        if ($request->payment_method == 'transfer' && $request->hasFile('bukti_bayar')) {
            $buktiPath = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');
            $statusAwal = 'Menunggu Konfirmasi Admin'; // Status langsung naik jadi nunggu dicek
        }

        DB::transaction(function () use ($cart, $totalHarga, $buktiPath, $statusAwal) {
            // 1. Simpan Transaksi Utama
            $transaksi = Transaksi::create([
                'user_id' => Auth::id(),
                'total_harga' => $totalHarga,
                'status' => $statusAwal,
                'bukti_pembayaran' => $buktiPath,
            ]);

            // 2. Simpan Detil Belanjaannya
            foreach ($cart as $details) {
                if ($details['tipe'] == 'produk') {
                    DetilTransaksiProduk::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $details['id'],
                        'jumlah' => $details['jumlah'],
                        'harga_satuan' => $details['harga'],
                    ]);
                }
            }
        });

        session()->forget('cart');

        return redirect()->route('dashboard.pelanggan')->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi.');
    }
    public function prosesReservasi(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required',
            'nama_layanan' => 'required',
            'tanggal_reservasi' => 'required|date',
            'waktu_reservasi' => 'required',
            'nama_hewan' => 'required'
        ]);

        // Ambil data layanan dari database biar harganya akurat dan aman
        $layanan = Layanan::findOrFail($request->layanan_id);

        // Perhitungan DP 30%
        $harga_total = $layanan->harga;
        $dp = $harga_total * 0.30; // 30 persen
        $sisa_bayar = $harga_total - $dp;

        // Simpan ke database
        $reservasi = reservasi::create([
            'user_id' => Auth::id(),
            'nama_layanan' => $request->nama_layanan,
            'tanggal' => $request->tanggal_reservasi,
            'waktu' => $request->waktu_reservasi,
            'pet_name' => $request->nama_hewan,
            'harga_total' => $harga_total,
            'dp' => $dp,
            'sisa_bayar' => $sisa_bayar,
            'status' => 'Menunggu Pembayaran', // Status berubah
            'alasan_batal' => null
        ]);

        // Arahkan ke halaman upload struk DP
        return redirect()->route('reservasi.bayar', $reservasi->id);
    }

    // 7. Menampilkan halaman upload struk DP
    public function bayarDp($id)
    {
        $reservasi = reservasi::findOrFail($id);

        // Pastikan keamanan: Cuma bisa diakses sama yang punya reservasi & statusnya "Menunggu Pembayaran"
        if($reservasi->user_id != Auth::id() || $reservasi->status != 'Menunggu Pembayaran') {
            return redirect()->route('dashboard.pelanggan')->with('error', 'Akses ditolak atau tagihan sudah dibayar.');
        }

        return view('dashboard.bayar_dp', compact('reservasi'));
    }

    // 8. Mesin Proses Upload Struk DP
    public function uploadBuktiDp(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran_dp' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ]);

        $reservasi = reservasi::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran_dp')) {
            $pathFoto = $request->file('bukti_pembayaran_dp')->store('bukti_dp', 'public');

            $reservasi->bukti_pembayaran_dp = $pathFoto;
            $reservasi->status = 'Menunggu Konfirmasi Admin'; // Ubah status biar admin ngecek
            $reservasi->save();
        }

        return redirect()->route('dashboard.pelanggan')->with('success', 'Bukti transfer DP berhasil dikirim! Silakan tunggu konfirmasi dari admin Paw Center.');
    }
}
