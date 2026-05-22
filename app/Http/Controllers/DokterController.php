<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservasi; // Sesuaikan dengan model yang kamu pakai

class DokterController extends Controller
{
    // === FITUR PEMERIKSAAN ===
    public function pemeriksaanIndex()
    {
        // Filter untuk membuang layanan staff (grooming & hotel)
        $excludeStaff = function($query) {
            $query->where('nama_layanan', 'NOT LIKE', '%grooming%')
                  ->where('nama_layanan', 'NOT LIKE', '%hotel%')
                  ->where('nama_layanan', 'NOT LIKE', '%penitipan%');
        };

        // Ambil semua data pemeriksaan medis gabungan dengan pagination
        // Diurutkan agar status Diproses & Dikonfirmasi muncul paling atas, baru yang Selesai
        $semuaPemeriksaan = \App\Models\reservasi::where($excludeStaff)
            ->orderByRaw("FIELD(status, 'Diproses', 'Dikonfirmasi', 'Menunggu Jadwal', 'Selesai') ASC")
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->paginate(10); // Menampilkan 10 data per halaman biar rapi

        return view('dokter.pemeriksaan', compact('semuaPemeriksaan'));
    }

    public function pemeriksaanDetail($id) {
        $pemeriksaan = reservasi::with(['hewan', 'user'])->findOrFail($id);
        return view('dokter.pemeriksaan_detail', compact('pemeriksaan'));
    }

    public function simpanRM(Request $request) {
        // Nanti logic simpan ke DB kita masukin sini
        return back()->with('success', 'Rekam Medis berhasil disimpan!');
    }

    // === FITUR REKAM MEDIS ===
    public function rekamMedisIndex() {
        $rekamMedis = collect(); // Nanti diganti query beneran
        return view('dokter.rekam_medis', compact('rekamMedis'));
    }

    public function rekamMedisDetail($id) {
        // Nanti diganti query beneran
        return view('dokter.rekam_medis_detail');
    }

    public function rekamMedisPdf($id) {
        // Nanti diisi logic return PDF
    }

    // === FITUR LAPORAN ===
    public function laporanIndex() {
        return view('dokter.laporan');
    }

    public function laporanPrint() {
        // Nanti diisi logic return PDF
    }

    // === OPSI REKAM MEDIS & API ===
    public function opsiRmIndex() {
        $kategoriList = ['nafsu_makan' => 'Nafsu Makan', 'kondisi_tubuh' => 'Kondisi Tubuh']; // Contoh
        $opsiPerKategori = collect(['nafsu_makan' => collect(), 'kondisi_tubuh' => collect()]); // Contoh
        return view('dokter.opsi_rm', compact('kategoriList', 'opsiPerKategori'));
    }

    public function opsiRmApi() {
        return response()->json(['success' => true, 'data' => []]);
    }

    public function reservasiRealtime(Request $request) {
        $data = reservasi::with(['hewan', 'user'])->whereIn('status', ['Dikonfirmasi', 'Diproses'])->get();
        return response()->json(['success' => true, 'data' => $data]);
    }
}