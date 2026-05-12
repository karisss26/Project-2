# TODO - POS Kasir (Admin)

## Step 1

- [x] Analisis repo (route/controller/view/status transaksi)

## Step 2

- [ ] Edit `routes/web.php`: tambah route POS untuk role `admin,kasir`

## Step 3

- [ ] Buat controller POS `PosKasirController` (show produk, proses checkout tunai/transfer)

## Step 4

- [ ] Buat view POS `resources/views/dashboard/admin/pos.blade.php` (produk list + qty + metode bayar)

## Step 5

- [ ] Update sidebar `resources/views/layouts/app.blade.php`: sambungkan menu “Aplikasi Kasir (POS)” ke route POS

## Step 6

- [ ] Jalankan & test:
    - [ ] Tunai -> status `Menunggu Pembayaran`
    - [ ] Transfer/QRIS -> status `Menunggu Konfirmasi Admin`
    - [ ] Detil transaksi masuk ke `detil_transaksi_produk`
