<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\hewan;
use App\Models\User;
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
public function batalkan(Request $request, $id)
{
    // Cari data reservasi berdasarkan ID yang diklik
    $reservasi = \App\Models\Reservasi::findOrFail($id);

    // Pastikan reservasi ini benar-benar milik user yang sedang login biar aman
    if ($reservasi->user_id == Auth::id()) {

        // Ubah statusnya jadi Dibatalkan
        $reservasi->status = 'Dibatalkan';

        // Simpan alasan batal yang dikirim dari form pop-up tadi
        $reservasi->alasan_batal = $request->alasan_batal;

        // Simpan perubahan ke database
        $reservasi->save();

        return back()->with('success', 'Jadwal berhasil dibatalkan. Terima kasih atas konfirmasinya.');
    }

    return back()->with('error', 'Gagal membatalkan jadwal. Data tidak ditemukan.');
}

    public function dataHewan()
    {
        $userId = Auth::id();

        // Ambil data dari database
        $semua_hewan = hewan::where('user_id', $userId)->get();

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
        // 1. Ambil data user spesifik langsung dari Model Database (Biar fitur save() ngebaca)
        $user = User::find(Auth::id());

        // 2. Validasi inputan dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // 3. Masukin data baru ke variabel
        $user->name = $request->name;
        $user->email = $request->email;

        // 4. Update password cuma kalau kolom passwordnya diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 5. Simpan ke database (Sekarang fungsi save() ini bakal jalan lancar)
        $user->save();

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman katalog layanan & produk untuk pelanggan
     */
    public function katalog()
    {
        // 1. Dummy Data Hewan Peliharaan (Buat dropdown pilih anabul)
        $hewan = [
            (object)['id' => 1, 'nama_hewan' => 'Mochi'],
            (object)['id' => 2, 'nama_hewan' => 'Boba'],
            (object)['id' => 3, 'nama_hewan' => 'Cimol']
        ];

        // 2. Dummy Data Layanan
        $layanan = [
            (object)['id' => 1, 'nama_layanan' => 'Grooming Basic', 'harga' => 50000],
            (object)['id' => 2, 'nama_layanan' => 'Grooming Lengkap', 'harga' => 85000],
            (object)['id' => 3, 'nama_layanan' => 'Pemeriksaan Dokter', 'harga' => 150000]
        ];

        // 3. Dummy Data Produk
        $produk = [
            (object)['id' => 1, 'nama_produk' => 'Makanan Kucing Premium', 'harga' => 75000, 'stok' => 15],
            (object)['id' => 2, 'nama_produk' => 'Pasir Kucing Wangi 5L', 'harga' => 45000, 'stok' => 20],
            (object)['id' => 3, 'nama_produk' => 'Mainan Tongkat Bulu', 'harga' => 15000, 'stok' => 50]
        ];

        return view('dashboard.katalog', compact('produk', 'layanan', 'hewan'));
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
