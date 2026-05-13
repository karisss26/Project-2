# TODO - Admin Sales Report (Laporan Penjualan)

## Checklist
- [ ] Tambah route baru admin: `/admin/laporan-penjualan`.
- [ ] Tambah method controller `adminLaporanPenjualan(Request $request)` untuk:
  - [ ] Hitung revenue per interval (day=30 hari, month=12 bulan, year=5 tahun) dari transaksi `status=Selesai` (total_harga) + reservasi `status=Selesai` (harga_total).
  - [ ] Hitung top 10 produk terjual berdasarkan jumlah dari `detil_transaksi_produk` pada transaksi selesai dalam interval terpilih.
  - [ ] Siapkan data untuk chart.js (labels + series) + data pie.
  - [ ] Siapkan tabel transaksi terbaru sesuai interval.
- [ ] Buat view: `resources/views/dashboard/admin/laporan_penjualan.blade.php` dengan:
  - [ ] Filter mode day/month/year
  - [ ] Chart.js revenue (line/bar)
  - [ ] Chart.js produk terjual (pie)
  - [ ] Tabel transaksi
- [ ] Tambahkan link tombol di `resources/views/dashboard/admin.blade.php` ke halaman laporan penjualan.
- [x] Verifikasi route dan tampilkan halaman di browser.


