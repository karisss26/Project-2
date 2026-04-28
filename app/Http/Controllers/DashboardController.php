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
        $menungguKonfirmasi = reservasi::where('status', 'Menunggu')->count();
        $pesananDiproses = reservasi::where('status', 'Dikonfirmasi')->count();

        $antreanPembayaran = reservasi::with('user')
                                      ->where('status', 'Menunggu')
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        $pesananAktif = reservasi::with('user')
                                 ->whereIn('status', ['Dikonfirmasi'])
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
        $user = User::findOrFail(Auth::id());
        $user->update($request->only('name', 'email', 'no_hp', 'alamat'));

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profil', 'public');
            $user->update(['foto_profil' => $path]);
        }

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Update Profil',
            'deskripsi' => Auth::user()->name . ' memperbarui informasi profilnya.'
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function owner() { return view('dashboard.owner'); }
    public function dokter() { return view('dashboard.dokter'); }
    public function staff() { return view('dashboard.staff'); }
    public function dataHewan() { return view('dashboard.hewan'); }
    public function profil() { return view('dashboard.profil'); }
}
