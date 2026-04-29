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
use App\Models\DetilTransaksiProduk;
use App\Models\Transaksi;
class DashboardController extends Controller
{
public function pelanggan()
{
    $userId = Auth::id();
    $petCount = hewan::where('user_id', $userId)->count();
    $cartCount = count(session('cart', []));

    // Data untuk tabel 1: Reservasi Layanan
    $reservasiLayanan = reservasi::where('user_id', $userId)
                                              ->orderBy('created_at', 'desc')
                                              ->get();

    // Data untuk tabel 2: Pembelian Produk
    $pembelianProduk = \App\Models\Transaksi::where('user_id', $userId)
                                            ->orderBy('created_at', 'desc')
                                            ->get();

    // Hitung reservasi aktif (dicek admin atau disetujui)
    $activeReservationsCount = $reservasiLayanan->whereIn('status', ['Menunggu Konfirmasi Admin', 'Dikonfirmasi'])->count();

    return view('dashboard.pelanggan', compact(
        'petCount',
        'activeReservationsCount',
        'cartCount',
        'reservasiLayanan',
        'pembelianProduk'
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

public function storeHewan(Request $request)
    {
        // 1. Ambil semua request, TAPI kecualikan umur_angka dan umur_satuan
        $data = $request->except(['umur_angka', 'umur_satuan']);

        // 2. Gabungkan angka dan satuan menjadi satu string, lalu simpan ke kolom 'umur'
        $data['umur'] = $request->umur_angka . ' ' . $request->umur_satuan;

        // 3. Pastikan user_id (pemilik hewan) otomatis terisi oleh user yang sedang login
        $data['user_id'] = Auth::id();

        $hewan = hewan::create($data);

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

        $data = $request->except(['umur_angka', 'umur_satuan']);

        // Kalau user update umurnya juga, kita gabungkan lagi
        if ($request->has('umur_angka') && $request->has('umur_satuan')) {
            $data['umur'] = $request->umur_angka . ' ' . $request->umur_satuan;
        }

        $hewan->update($data);

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

    public function admin()
    {
        $totalPengguna = User::where('role', 'pelanggan')->count();

        $reservasi = reservasi::with('user')->get();
        $transaksi = Transaksi::with('user')->get();

        // [BARU] Bongkar keranjang belanja produk buat ditampilin ke Admin
        foreach($transaksi as $trx) {
            $trx->detail_belanja = DetilTransaksiProduk::where('transaksi_id', $trx->id)->get();
            foreach($trx->detail_belanja as $detail) {
                $produk = Produk::find($detail->produk_id);
                $detail->nama_produk = $produk ? $produk->nama_produk : 'Produk (Dihapus)';
            }
        }

        $semuaPesanan = $reservasi->concat($transaksi)->sortByDesc('created_at');

        $antreanPembayaran = $semuaPesanan->whereIn('status', ['Menunggu', 'Menunggu Pembayaran', 'Menunggu Konfirmasi Admin', 'Pending']);

        // Tambahan status "Menunggu Kurir" dan "Pesanan Diantar"
        $pesananAktif = $semuaPesanan->whereIn('status', ['Dikonfirmasi', 'Diproses', 'Menunggu Jadwal', 'Menunggu Kurir', 'Pesanan Diantar']);

        $menungguKonfirmasi = $antreanPembayaran->count();
        $pesananDiproses = $pesananAktif->count();

        $riwayatAktivitas = LogAktivitas::with('user')->orderBy('created_at', 'desc')->take(10)->get();

        return view('dashboard.admin', compact('totalPengguna', 'menungguKonfirmasi', 'pesananDiproses', 'antreanPembayaran', 'pesananAktif', 'riwayatAktivitas'));
    }

    public function setujuiReservasi(Request $request, $id)
    {
        // Cek apakah dia produk atau reservasi
        $pesanan = ($request->tipe == 'transaksi')
                    ? \App\Models\Transaksi::findOrFail($id)
                    : reservasi::findOrFail($id);

        $pesanan->update(['status' => 'Dikonfirmasi']);

        // Kirim notifikasi ke pelanggan (kalau transaksi belum ada relasi notif, bisa diabaikan dulu atau disesuaikan)
        if($request->tipe != 'transaksi'){
             $pesanan->user->notify(new ReservasiNotification($pesanan, 'Dikonfirmasi'));
        }

        return back()->with('success', 'Pesanan disetujui!');
    }

    public function tolakReservasi(Request $request, $id)
    {
        $pesanan = ($request->tipe == 'transaksi')
                    ? \App\Models\Transaksi::findOrFail($id)
                    : reservasi::findOrFail($id);

        $pesanan->update(['status' => 'Dibatalkan']);

        if($request->tipe != 'transaksi'){
            $pesanan->user->notify(new ReservasiNotification($pesanan, 'Ditolak'));
        }

        return back()->with('success', 'Pesanan ditolak.');
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = ($request->tipe == 'transaksi')
                    ? \App\Models\Transaksi::findOrFail($id)
                    : reservasi::findOrFail($id);

        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi: ' . $request->status);
    }

    public function uploadBukti(Request $request, $id)
{
    $request->validate([
        'bukti_pembayaran_dp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $reservasi = reservasi::findOrFail($id);

    if ($request->hasFile('bukti_pembayaran_dp')) {
        // Simpan file ke folder storage/app/public/bukti_dp
        $path = $request->file('bukti_pembayaran_dp')->store('bukti_dp', 'public');

        // Update status dan simpan nama filenya
        $reservasi->update([
            'bukti_pembayaran_dp' => $path,
            'status' => 'Menunggu Konfirmasi Admin'
        ]);
    }

    return redirect()->route('dashboard.pelanggan')->with('success', 'Bukti pembayaran berhasil diunggah, silakan tunggu konfirmasi admin.');
}

    public function owner() { return view('dashboard.owner'); }
    public function dokter() { return view('dashboard.dokter'); }
    public function staff() { return view('dashboard.staff'); }
    public function dataHewan()
    {
        // Ambil data hewan khusus milik pelanggan yang sedang login
        $semua_hewan = hewan::where('user_id', Auth::id())->get();

        // Bawa datanya ke halaman view
        return view('dashboard.hewan', compact('semua_hewan'));
    }
    public function profil() { return view('dashboard.profil'); }
}
