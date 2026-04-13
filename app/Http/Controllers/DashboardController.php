<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\hewan;
use App\Models\reservasi;


class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard pelanggan
     */
    public function pelanggan()
    {
        $userId = Auth::id();

        // 1. Hitung jumlah anabul milik user dari tabel 'hewan'
        $petCount = hewan::where('user_id', $userId)->count();

        // 2. Hitung jumlah reservasi aktif (Menunggu/Dikonfirmasi)
        $activeReservationsCount = reservasi::where('user_id', $userId)
                                            ->whereIn('status', ['Menunggu', 'Dikonfirmasi'])
                                            ->count();

        // 3. Hitung jumlah item di keranjang dari session
        $cart = session('cart', []);
        $cartCount = count($cart);

        // 4. Ambil 5 jadwal terdekat yang belum selesai
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
    public function batalkan($id)
    {
        // Cari data di tabel reservasi berdasarkan ID
        $data = reservasi::find($id);

        // Validasi: Data ada dan milik user yang sedang login
        if ($data && $data->user_id == Auth::id()) {

            // Cek jika status sudah dibatalkan sebelumnya
            if ($data->status == 'Dibatalkan') {
                return redirect()->back()->with('error', 'Jadwal ini sudah dibatalkan sebelumnya.');
            }

            $data->status = 'Dibatalkan';
            $data->save();

            return redirect()->back()->with('success', 'Jadwal reservasi berhasil dibatalkan!');
        }

        return redirect()->back()->with('error', 'Maaf, data reservasi tidak ditemukan atau Anda tidak memiliki akses.');
    }


    public function dataHewan()
    {
        $userId = Auth::id();

        // Ambil data dari database
        $semua_hewan = \App\Models\hewan::where('user_id', $userId)->get();

        // PENTING: compact('semua_hewan') ini yang ngirim data ke file Blade
        return view('dashboard.hewan', compact('semua_hewan'));
    }

    public function storeHewan(Request $request) {
        $request->validate([
            'nama_hewan' => 'required',
            'jenis_hewan' => 'required',
            'ras' => 'required', // Tambah ini
            'umur' => 'required'  // Tambah ini
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
        // 1. Ambil data user yang lagi login (WAJIB ADA)
        $user = Auth::user();

        // 2. Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // 3. Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // 4. Update password kalau diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 5. Simpan ke database
        $user->save(); // Harusnya di sini udah aman

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }
}
