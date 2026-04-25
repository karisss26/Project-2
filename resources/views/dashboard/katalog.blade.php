<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - D&P Pet Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ungu: {
                            DEFAULT: '#7c3aed',
                            gelap: '#6d28d9',
                            muda: '#e9d5ff',
                            terang: '#f3e8ff',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-4">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-ungu rounded-full flex items-center justify-center">
                        <i class="fas fa-paw text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-ungu leading-tight">D&P Pet Shop</h1>
                        <p class="text-xs text-gray-500">Peliharaan Sehat, Pemilik Senang</p>
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl">
                    <div class="relative">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Cari produk atau layanan..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-full border-2 border-ungu-muda focus:border-ungu focus:outline-none bg-ungu-terang/30 text-sm transition-colors"
                        >
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-ungu"></i>
                    </div>
                </div>

                <!-- Icons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('checkout') }}" class="relative p-2 hover:bg-ungu-terang rounded-full transition-colors group">
                        <i class="fas fa-shopping-cart text-ungu text-xl group-hover:scale-110 transition-transform"></i>
                        <span id="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">0</span>
                    </a>
                    <button class="p-2 hover:bg-ungu-terang rounded-full transition-colors relative">
                        <i class="fas fa-bell text-ungu text-xl"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <a href="{{ route('pelanggan') }}" class="p-2 hover:bg-ungu-terang rounded-full transition-colors group">
                        <i class="fas fa-user-circle text-ungu text-2xl group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-ungu to-ungu-gelap py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Katalog Produk & Layanan</h2>
            <p class="text-ungu-muda text-lg mb-8">Temukan kebutuhan terbaik untuk hewan peliharaan kesayangan Anda</p>
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 bg-white text-ungu px-6 py-3 rounded-full font-semibold hover:bg-ungu-muda transition-colors shadow-lg">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>
    </section>

    <!-- Produk Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Produk</h3>
                    <p class="text-gray-500 mt-1">Pilihan produk berkualitas untuk peliharaan Anda</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-ungu text-white rounded-lg text-sm font-medium hover:bg-ungu-gelap transition-colors">Semua</button>
                    <button class="px-4 py-2 bg-ungu-terang text-ungu rounded-lg text-sm font-medium hover:bg-ungu-muda transition-colors">Makanan</button>
                    <button class="px-4 py-2 bg-ungu-terang text-ungu rounded-lg text-sm font-medium hover:bg-ungu-muda transition-colors">Aksesoris</button>
                </div>
            </div>

            <div id="produkContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Produk 1 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Royal Canin Kitten Makanan Kucing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Royal+Canin" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 left-3 bg-ungu text-white text-xs px-2 py-1 rounded-full font-medium">Terlaris</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Royal Canin Kitten Makanan Kucing</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-xs text-gray-500">(4.5)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 45.000</span>
                            <span class="text-xs text-gray-400">1 kg</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 2 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Whiskas Adult Makanan Kucing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Whiskas" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Whiskas Adult Makanan Kucing Rasa Tuna</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500">(4.0)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 28.500</span>
                            <span class="text-xs text-gray-400">1.2 kg</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 3 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Pedigree Adult Makanan Anjing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Pedigree" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Diskon 10%</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Pedigree Adult Makanan Anjing Rasa Beef</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500">(5.0)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-ungu">Rp 52.000</span>
                                <span class="text-xs text-gray-400 line-through ml-1">Rp 57.800</span>
                            </div>
                            <span class="text-xs text-gray-400">3 kg</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 4 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Cat Choize Kitten Makanan Kucing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Cat+Choize" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Cat Choize Kitten Makanan Kucing</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500">(4.2)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 35.000</span>
                            <span class="text-xs text-gray-400">800 gr</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 5 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Bolt Dog Food Makanan Anjing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Bolt" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Bolt Dog Food Makanan Anjing Rasa Ayam</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500">(3.8)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 42.000</span>
                            <span class="text-xs text-gray-400">2.5 kg</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 6 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Pro Plan Adult Makanan Kucing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Pro+Plan" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 left-3 bg-ungu text-white text-xs px-2 py-1 rounded-full font-medium">Premium</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Pro Plan Adult Makanan Kucing Sterilized</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500">(4.9)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 85.000</span>
                            <span class="text-xs text-gray-400">1.5 kg</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 7 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Tali Leher Kucing Aksesoris">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Tali+Leher" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Tali Leher Kucing Adjustable Motif Lucu</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500">(4.3)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 18.000</span>
                            <span class="text-xs text-gray-400">1 pcs</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>

                <!-- Produk 8 -->
                <div class="search-item group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-ungu-muda transition-all duration-300 overflow-hidden" data-name="Mainan Tikus Kucing">
                    <div class="relative overflow-hidden">
                        <img src="https://placehold.co/300x250/e9d5ff/7c3aed?text=Mainan+Tikus" alt="Produk" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 right-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">Baru</span>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-1 line-clamp-2">Mainan Tikus Kucing Bisa Bunyi Interactive</h4>
                        <div class="flex items-center gap-1 mb-2">
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-xs text-gray-500">(4.7)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-ungu">Rp 25.000</span>
                            <span class="text-xs text-gray-400">1 pcs</span>
                        </div>
                        <button onclick="addToCart(this)" class="w-full mt-3 bg-ungu-terang text-ungu font-semibold py-2 rounded-xl hover:bg-ungu hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-bag text-sm"></i>
                            Masuk Keranjang
                        </button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <button class="px-8 py-3 bg-ungu text-white rounded-full font-semibold hover:bg-ungu-gelap transition-colors shadow-lg hover:shadow-xl">
                    Selengkapnya
                </button>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    <section class="py-12 bg-ungu-terang/30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-bold text-gray-800">Layanan</h3>
                <p class="text-gray-500 mt-2">Layanan profesional untuk kesehatan dan kebersihan peliharaan Anda</p>
            </div>

            <div id="layananContainer" class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Layanan 1: Grooming -->
                <div class="search-item group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-ungu" data-name="Grooming">
                    <div class="h-48 bg-gradient-to-br from-ungu-muda to-ungu-terang flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-cut text-6xl text-ungu group-hover:scale-110 transition-transform duration-300"></i>
                        <div class="absolute inset-0 bg-ungu opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xl font-bold text-gray-800">Grooming</h4>
                            <span class="bg-ungu-terang text-ungu text-xs px-3 py-1 rounded-full font-semibold">Tersedia</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                            Layanan perawatan kebersihan dan penampilan lengkap termasuk mandi, potong kuku, bersihkan telinga, dan styling bulu.
                        </p>
                        <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
                            <i class="fas fa-clock text-ungu"></i>
                            <span>60 - 90 menit</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-xs text-gray-400">Mulai dari</span>
                                    <p class="text-2xl font-bold text-ungu">Rp 75.000</p>
                                </div>
                                <div class="text-right">
                                    <div class="flex text-yellow-400 text-xs">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">(128 ulasan)</span>
                                </div>
                            </div>
                            <button onclick="openReservasiModal('Grooming', 75000)" class="w-full bg-ungu text-white font-semibold py-3 rounded-xl hover:bg-ungu-gelap transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-ungu/30">
                                <i class="fas fa-calendar-check"></i>
                                Reservasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Layanan 2: Konsultasi Klinik -->
                <div class="search-item group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-ungu" data-name="Konsultasi Klinik">
                    <div class="h-48 bg-gradient-to-br from-ungu-muda to-ungu-terang flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-user-md text-6xl text-ungu group-hover:scale-110 transition-transform duration-300"></i>
                        <div class="absolute inset-0 bg-ungu opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xl font-bold text-gray-800">Konsultasi Klinik</h4>
                            <span class="bg-ungu-terang text-ungu text-xs px-3 py-1 rounded-full font-semibold">Tersedia</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                            Konsultasi kesehatan dengan dokter hewan berpengalaman. Termasuk pemeriksaan umum, vaksinasi, dan resep obat.
                        </p>
                        <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
                            <i class="fas fa-clock text-ungu"></i>
                            <span>30 - 45 menit</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-xs text-gray-400">Mulai dari</span>
                                    <p class="text-2xl font-bold text-ungu">Rp 100.000</p>
                                </div>
                                <div class="text-right">
                                    <div class="flex text-yellow-400 text-xs">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">(96 ulasan)</span>
                                </div>
                            </div>
                            <button onclick="openReservasiModal('Konsultasi Klinik', 100000)" class="w-full bg-ungu text-white font-semibold py-3 rounded-xl hover:bg-ungu-gelap transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-ungu/30">
                                <i class="fas fa-calendar-check"></i>
                                Reservasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Layanan 3: Pet Hotel -->
                <div class="search-item group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-ungu" data-name="Pet Hotel">
                    <div class="h-48 bg-gradient-to-br from-ungu-muda to-ungu-terang flex items-center justify-center relative overflow-hidden">
                        <i class="fas fa-hotel text-6xl text-ungu group-hover:scale-110 transition-transform duration-300"></i>
                        <div class="absolute inset-0 bg-ungu opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xl font-bold text-gray-800">Pet Hotel</h4>
                            <span class="bg-ungu-terang text-ungu text-xs px-3 py-1 rounded-full font-semibold">Tersedia</span>
                        </div>
                        <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                            Penitipan hewan peliharaan dengan fasilitas nyaman, monitoring 24 jam, makanan terjadwal, dan area bermain.
                        </p>
                        <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
                            <i class="fas fa-clock text-ungu"></i>
                            <span>24 jam / hari</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-xs text-gray-400">Mulai dari</span>
                                    <p class="text-2xl font-bold text-ungu">Rp 150.000<span class="text-sm font-normal text-gray-400">/hari</span></p>
                                </div>
                                <div class="text-right">
                                    <div class="flex text-yellow-400 text-xs">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">(84 ulasan)</span>
                                </div>
                            </div>
                            <button onclick="openReservasiModal('Pet Hotel', 150000)" class="w-full bg-ungu text-white font-semibold py-3 rounded-xl hover:bg-ungu-gelap transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-ungu/30">
                                <i class="fas fa-calendar-check"></i>
                                Reservasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Reservasi -->
    <div id="reservasiModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl transform transition-all scale-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Reservasi Layanan</h3>
                <button onclick="closeReservasiModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>

            <form id="reservasiForm" onsubmit="submitReservasi(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                    <input type="text" id="modalLayanan" readonly class="w-full px-4 py-2 bg-ungu-terang/30 border border-ungu-muda rounded-xl text-ungu font-semibold focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="text" id="modalHarga" readonly class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-semibold focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Reservasi</label>
                    <input type="date" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:border-ungu focus:outline-none focus:ring-2 focus:ring-ungu-muda">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                    <select required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:border-ungu focus:outline-none focus:ring-2 focus:ring-ungu-muda">
                        <option value="">Pilih Waktu</option>
                        <option value="09:00">09:00 WIB</option>
                        <option value="10:00">10:00 WIB</option>
                        <option value="11:00">11:00 WIB</option>
                        <option value="13:00">13:00 WIB</option>
                        <option value="14:00">14:00 WIB</option>
                        <option value="15:00">15:00 WIB</option>
                        <option value="16:00">16:00 WIB</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Hewan</label>
                    <input type="text" placeholder="Masukkan nama hewan peliharaan" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:border-ungu focus:outline-none focus:ring-2 focus:ring-ungu-muda">
                </div>

                <button type="submit" class="w-full bg-ungu text-white font-semibold py-3 rounded-xl hover:bg-ungu-gelap transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    Konfirmasi Reservasi
                </button>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 bg-ungu text-white px-6 py-3 rounded-xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300 z-50 flex items-center gap-3">
        <i class="fas fa-check-circle text-green-300"></i>
        <span id="toastMessage">Berhasil ditambahkan!</span>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Tentang Kami -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-ungu rounded-full flex items-center justify-center">
                            <i class="fas fa-paw text-white text-sm"></i>
                        </div>
                        <h4 class="font-bold text-lg">D&P Pet Shop</h4>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        D&P Pet Shop hadir untuk memenuhi kebutuhan hewan peliharaan kesayangan Anda dengan produk berkualitas dan layanan profesional.
                    </p>
                    <p class="text-gray-500 text-xs">© 2025 D&P Pets. All rights reserved.</p>
                </div>

                <!-- Layanan Kami -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Layanan Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-ungu-muda transition-colors">Grooming</a></li>
                        <li><a href="#" class="hover:text-ungu-muda transition-colors">Konsultasi Klinik</a></li>
                        <li><a href="#" class="hover:text-ungu-muda transition-colors">Pet Hotel</a></li>
                        <li><a href="#" class="hover:text-ungu-muda transition-colors">Pet Training</a></li>
                    </ul>
                </div>

                <!-- Hubungi Kami -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-ungu mt-1"></i>
                            <span>Jl. Sudirman No. 123, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-ungu"></i>
                            <span>0812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-ungu"></i>
                            <span>cs@dnppets.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Ikuti Kami -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-ungu transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-ungu transition-colors">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-ungu transition-colors">
                            <i class="fab fa-tiktok text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-6 text-center">
                <p class="text-gray-500 text-sm">© 2025 D&P Pets. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        const searchItems = document.querySelectorAll('.search-item');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            searchItems.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(searchTerm)) {
                    item.style.display = '';
                    item.style.opacity = '1';
                } else {
                    item.style.display = 'none';
                    item.style.opacity = '0';
                }
            });
        });

        // Cart Functionality
        let cartCount = 0;
        const cartCountEl = document.getElementById('cartCount');

        function addToCart(button) {
            cartCount++;
            cartCountEl.textContent = cartCount;

            // Animation
            cartCountEl.classList.add('scale-125');
            setTimeout(() => cartCountEl.classList.remove('scale-125'), 200);

            // Button feedback
            const originalHTML = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i> Ditambahkan';
            button.classList.remove('bg-ungu-terang', 'text-ungu');
            button.classList.add('bg-green-500', 'text-white');

            showToast('Produk berhasil masuk keranjang!');

            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.add('bg-ungu-terang', 'text-ungu');
                button.classList.remove('bg-green-500', 'text-white');
            }, 2000);
        }

        // Reservasi Modal
        const modal = document.getElementById('reservasiModal');

        function openReservasiModal(layanan, harga) {
            document.getElementById('modalLayanan').value = layanan;
            document.getElementById('modalHarga').value = 'Rp ' + harga.toLocaleString('id-ID');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeReservasiModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitReservasi(e) {
            e.preventDefault();
            closeReservasiModal();
            showToast('Reservasi berhasil dibuat! Silakan cek email Anda.');
            document.getElementById('reservasiForm').reset();
        }

        // Close modal on outside click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeReservasiModal();
            }
        });

        // Toast Notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;

            toast.classList.remove('translate-y-20', 'opacity-0');

            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }
    </script>
</body>
</html>
