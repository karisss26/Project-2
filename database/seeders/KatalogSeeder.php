<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Layanan;

class KatalogSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. DATA DUMMY PRODUK (MAKANAN & AKSESORIS)
        // ==========================================
        $dataProduk = [
            [
                'nama_produk' => 'Royal Canin Kitten 2Kg',
                'kategori' => 'Makanan',
                'harga' => 275000,
                'deskripsi' => 'Makanan kering khusus anak kucing usia 1-4 bulan. Mendukung sistem imun tubuh dan pencernaan yang sehat.',
                'gambar' => 'https://images.unsplash.com/photo-1589924691995-400dc9ecc119?q=80&w=400&auto=format&fit=crop',
            ],
            [
                'nama_produk' => 'Cat Choize Adult 800g',
                'kategori' => 'Makanan',
                'harga' => 26000,
                'deskripsi' => 'Makanan kucing dewasa dengan rasa Tuna. Tanpa pewarna buatan, baik untuk kesehatan mata dan gigi.',
                'gambar' => 'https://images.unsplash.com/photo-1623366302587-bcaad5cfdb66?q=80&w=400&auto=format&fit=crop',
            ],
            [
                'nama_produk' => 'Pasir Kucing Gumpal Wangi 5L (Kopi)',
                'kategori' => 'Aksesoris',
                'harga' => 45000,
                'deskripsi' => 'Pasir gumpal wangi premium aroma kopi. Menggumpal dengan cepat dan menyerap bau kotoran anabul.',
                'gambar' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=400&auto=format&fit=crop',
            ],
            [
                'nama_produk' => 'Kalung Lonceng Kucing Motif Pita',
                'kategori' => 'Aksesoris',
                'harga' => 15000,
                'deskripsi' => 'Kalung kucing kain lembut dengan lonceng berdering nyaring. Bisa diatur panjang pendeknya.',
                'gambar' => 'https://images.unsplash.com/photo-1535930891776-0c2dfb7fda1a?q=80&w=400&auto=format&fit=crop',
            ],
        ];

        foreach ($dataProduk as $produk) {
            Produk::create($produk);
        }


        // ==========================================
        // 2. DATA DUMMY LAYANAN (KLINIK, GROOMING, HOTEL)
        // ==========================================
        $dataLayanan = [
            [
                'nama_layanan' => 'Grooming Sehat (Mandi & Kutu)',
                'kategori' => 'Grooming',
                'harga' => 90000,
                'deskripsi' => 'Layanan mandi bersih, potong kuku, bersihkan telinga, dan pengobatan anti kutu dasar.',
                'gambar' => 'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?q=80&w=400&auto=format&fit=crop',
            ],
            [
                'nama_layanan' => 'Konsultasi Dokter Hewan Umum',
                'kategori' => 'Klinik',
                'harga' => 100000,
                'deskripsi' => 'Pengecekan kesehatan menyeluruh oleh dokter hewan profesional D&F Pets.',
                'gambar' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?q=80&w=400&auto=format&fit=crop',
            ],
            [
                'nama_layanan' => 'Vaksinasi Tricat (Kucing)',
                'kategori' => 'Klinik',
                'harga' => 180000,
                'deskripsi' => 'Vaksinasi wajib untuk kucing mencegah virus Panleukopenia, Rhinotracheitis, dan Calicivirus.',
                'gambar' => 'https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?q=80&w=400&auto=format&fit=crop',
            ],
            [
                'nama_layanan' => 'Penitipan Kamar VIP (AC)',
                'kategori' => 'Pet Hotel',
                'harga' => 120000,
                'deskripsi' => 'Harga per malam. Fasilitas kamar luas ber-AC, update foto/video harian, free snack, dan jam bermain.',
                'gambar' => 'https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?q=80&w=400&auto=format&fit=crop',
            ],
        ];

        foreach ($dataLayanan as $layanan) {
            Layanan::create($layanan);
        }
    }
}
