<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\hewan;
use App\Models\User;
use App\Models\reservasi;
use App\Models\Produk; // Pastikan model Produk dipanggil

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard pelanggan
     */
    public function pelanggan()
    {
        $userId = Auth::id();

        $petCount = hewan::where('user_id', $userId)->count();

        $activeReservationsCount = reservasi::where('user_id', $userId)
                                            ->whereIn('status', ['Menunggu', 'Dikonfirmasi'])
                                            ->count();

        $cart = session('cart', []);
        $cartCount = count($cart);

        $jadwalTerdekat = reservasi::where('user_id', $userId)
                                     ->whereIn('status', ['Menunggu', 'Dikonfirmasi'])
                                     ->orderBy('tanggal', 'asc')
                                     ->orderBy('waktu', 'asc')
                                     ->take(5)
                                     ->get();

        return view('dashboard.pelanggan', compact(
            'petCount',
            'activeReservationsCount',
            'cartCount',
            'jadwalTerdekat'
        ));
    }

    /**
     * Fitur untuk membatalkan reservasi
     */
    public function batalkan(Request $request, $id)
    {
        $reservasi = reservasi::findOrFail($id);

        if ($reservasi->user_id == Auth::id()) {
            $reservasi->status = 'Dibatalkan';
            $reservasi->alasan_batal = $request->alasan_batal;
            $reservasi->save();

            return back()->with('success', 'Jadwal berhasil dibatalkan.');
        }

        return back()->with('error', 'Gagal membatalkan jadwal.');
    }

    public function dataHewan()
    {
        $userId = Auth::id();
        $semua_hewan = hewan::where('user_id', $userId)->get();
        return view('dashboard.hewan', compact('semua_hewan'));
    }

    public function storeHewan(Request $request) {
        $request->validate([
            'nama_hewan' => 'required',
            'jenis_hewan' => 'required',
            'ras' => 'required',
            'umur' => 'required'
        ]);

        hewan::create([
            'user_id' => Auth::id(),
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis_hewan,
            'ras' => $request->ras,
            'umur' => $request->umur,
        ]);

        return back()->with('success', 'Anabul baru berhasil didaftarkan!');
    }

    public function updateHewan(Request $request, $id) {
        $h = hewan::findOrFail($id);
        $h->update([
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis_hewan,
            'ras' => $request->ras,
            'umur' => $request->umur,
        ]);

        return back()->with('success', 'Data anabul berhasil diperbarui!');
    }

    public function hapusHewan($id) {
        $h = hewan::findOrFail($id);
        $h->delete();

        return back()->with('success', 'Data anabul telah dihapus.');
    }

    public function profil() {
        return view('dashboard.profil');
    }

    public function updateProfil(Request $request) {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }

    // =========================================================================
    // PERBAIKAN: Fungsi storeProduk menggunakan kolom 'gambar'
    // =========================================================================
    public function storeProduk(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Menggunakan 'gambar' sesuai input
        ]);

        $pathFoto = null;

        if ($request->hasFile('gambar')) {
            // Simpan ke storage/app/public/produk
            $pathFoto = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'gambar' => $pathFoto, // Simpan ke kolom 'gambar'
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function owner()
    {
        return view('dashboard.owner');
    }

    public function dokter()
    {
        return view('dashboard.dokter');
    }

    public function staff()
    {
        return view('dashboard.staff');
    }
}
