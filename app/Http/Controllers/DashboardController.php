<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\hewan;
use App\Models\User;
use App\Models\reservasi;
use App\Models\Produk;
use App\Models\LogAktivitas;
use App\Notifications\ReservasiNotification;
class DashboardController extends Controller
{
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

    public function batalkan(Request $request, $id)
    {
        $reservasi = reservasi::findOrFail($id);
        $reservasi->update([
            'status' => 'Dibatalkan',
            'alasan_batal' => $request->alasan_batal
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Pembatalan Reservasi',
            'deskripsi' => Auth::user()->name . ' membatalkan reservasi #' . $id . ' dengan alasan: ' . $request->alasan_batal
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

public function admin()
    {
        $totalPengguna = User::where('role', 'pelanggan')->count();

        // 1. Kita perluas pencarian statusnya biar pesanan pelanggan pasti ketangkep!
        $menungguKonfirmasi = reservasi::whereIn('status', ['Menunggu', 'Menunggu Pembayaran', 'Pending'])->count();
        $pesananDiproses = reservasi::where('status', 'Dikonfirmasi')->count();

        // 2. Tangkap data untuk Antrean Pembayaran
        $antreanPembayaran = reservasi::with('user')
                                      ->whereIn('status', ['Menunggu', 'Menunggu Pembayaran', 'Pending'])
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        // 3. Tangkap data Pesanan yang Sedang Aktif / Diproses
        $pesananAktif = reservasi::with('user')
                                 ->whereIn('status', ['Dikonfirmasi', 'Diproses'])
                                 ->orderBy('updated_at', 'desc')
                                 ->get();

        $riwayatAktivitas = LogAktivitas::with('user')
                                        ->orderBy('created_at', 'desc')
                                        ->take(10)
                                        ->get();

        return view('dashboard.admin', compact(
            'totalPengguna',
            'menungguKonfirmasi',
            'pesananDiproses',
            'antreanPembayaran',
            'pesananAktif',
            'riwayatAktivitas'
        ));
    }

    public function storeHewan(Request $request)
    {
        $hewan = hewan::create($request->all());

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Tambah Hewan',
            'deskripsi' => Auth::user()->name . ' menambahkan data hewan baru: ' . $hewan->nama_hewan
        ]);

        return redirect()->back()->with('success', 'Data hewan berhasil ditambahkan.');
    }

    public function updateHewan(Request $request, $id)
    {
        $hewan = hewan::findOrFail($id);
        $hewan->update($request->all());

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Update Hewan',
            'deskripsi' => Auth::user()->name . ' memperbarui data hewan: ' . $hewan->nama_hewan
        ]);

        return redirect()->back()->with('success', 'Data hewan berhasil diperbarui.');
    }

    public function hapusHewan($id)
    {
        $hewan = hewan::findOrFail($id);
        $nama = $hewan->nama_hewan;
        $hewan->delete();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Hapus Hewan',
            'deskripsi' => Auth::user()->name . ' menghapus data hewan: ' . $nama
        ]);

        return redirect()->back()->with('success', 'Data hewan berhasil dihapus.');
    }

    public function updateProfil(Request $request)
    {
        // 1. Ambil data user yang sedang login langsung dari database
        $user = User::find(auth()->user()->id);

        // 2. Validasi semua input dari form profil.blade.php kamu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed' // 'confirmed' akan otomatis mengecek input 'password_confirmation'
        ]);

        // 3. Masukkan data ke model secara manual (ini bypass error $fillable)
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;

        // Simpan username jika ada inputnya
        if ($request->has('username')) {
            $user->username = $request->username;
        }

        // 4. Jika user mengisi password baru, kita enkripsi (Hash) lalu simpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 5. Proses ganti foto profil
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama di storage jika sebelumnya sudah ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            // Simpan foto baru
            $user->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }

        // 6. Simpan permanen ke database!
        $user->save();

        return redirect()->back()->with('success', 'Hore! Profil kamu berhasil diperbarui.');
    }

    public function setujuiReservasi($id) {
    $reservasi = reservasi::findOrFail($id);
    $reservasi->update(['status' => 'Dikonfirmasi']);

    // Kirim notifikasi ke pelanggan
    $reservasi->user->notify(new ReservasiNotification($reservasi, 'Dikonfirmasi'));

    return back()->with('success', 'Reservasi disetujui!');
    }

    public function tolakReservasi($id) {
    $reservasi = reservasi::findOrFail($id);
    $reservasi->update(['status' => 'Dibatalkan']);

    // Kirim notifikasi ke pelanggan
    $reservasi->user->notify(new ReservasiNotification($reservasi, 'Ditolak'));

    return back()->with('success', 'Reservasi ditolak.');
    }

    public function owner() { return view('dashboard.owner'); }
    public function dokter() { return view('dashboard.dokter'); }
    public function staff() { return view('dashboard.staff'); }
    public function dataHewan() { return view('dashboard.hewan'); }
    public function profil() { return view('dashboard.profil'); }
}
