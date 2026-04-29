<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $transaksi = Transaksi::with('user')->orderBy('created_at', 'desc')->get();
        return view('dashboard.admin.transaksi', compact('transaksi'));
    }

    // Fungsi mengubah status pesanan
    public function updateStatus(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = $request->status;
        $transaksi->save();

        return redirect()->back()->with('success', 'Status pesanan #' . $id . ' berhasil diubah menjadi: ' . $request->status);
    }
}
