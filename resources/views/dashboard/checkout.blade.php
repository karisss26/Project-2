@extends('layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .co-container { display: flex; gap: 30px; flex-wrap: wrap; }
    .co-left { flex: 2; min-width: 300px; }
    .co-right { flex: 1; min-width: 300px; background: #f8f9fa; padding: 25px; border-radius: 8px; border: 1px solid #E6E6FA; }

    .section-box { background: white; padding: 20px; border-radius: 8px; border: 1px solid #eee; margin-bottom: 20px; }
.section-box h3 { color: #36005E; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #F7F1FF; padding-bottom: 10px; }

    .item-list { width: 100%; border-collapse: collapse; }
    .item-list th, .item-list td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .item-list th { color: #555; }
    .item-price { text-align: right; font-weight: bold; }

.total-box { margin-top: 20px; padding-top: 15px; border-top: 2px dashed #ccc; display: flex; justify-content: space-between; font-size: 20px; font-weight: bold; color: #36005E; }
.qris-box { text-align: center; margin: 20px 0; padding: 20px; background: white; border-radius: 8px; border: 1px dashed #36005E; }
    .qris-box img { max-width: 200px; margin-bottom: 10px; }

    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
    .form-group input[type="file"], .form-group input[type="datetime-local"], .form-group textarea, .form-group input[type="text"] { width: 100%; padding: 10px; background: white; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }

.btn-pay { width: 100%; padding: 15px; background: #36005E; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
.btn-pay:hover { background: #2c004f; }

.qty-btn { background: #F7F1FF; color: #36005E; border: none; width: 25px; height: 25px; border-radius: 4px; font-weight: bold; cursor: pointer; }
.qty-btn:hover { background: #36005E; color: white; }
    .remove-btn { background: none; border: none; color: #dc3545; font-size: 18px; cursor: pointer; transition: 0.2s; }
    .remove-btn:hover { transform: scale(1.2); }
    .qty-display { display: inline-block; width: 30px; text-align: center; font-weight: bold; }
    .flex-center { display: flex; align-items: center; justify-content: center; gap: 5px; }

    /* Map Style */
    #map { height: 350px; width: 100%; border-radius: 8px; border: 1px solid #ccc; margin-bottom: 15px; z-index: 1; }

    .radio-group { display: flex; gap: 15px; padding: 15px; background: #f8f9fa; border-radius: 6px; border: 1px solid #eee; margin-bottom: 15px;}
    .radio-group label { margin: 0; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: normal;}
    .jarak-badge { display: inline-block; background: #e2e3e5; color: #333; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-left: 10px; font-weight: normal;}
</style>

@if(session('success'))
    <div style="background-color: #d4edda; border-left: 5px solid #28a745; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        ✅ <strong>Berhasil!</strong> {{ session('success') }}
    </div>
@endif

<div class="co-container">
    <div class="co-left">
        <div class="section-box">
            <h3>📝 Rincian Pesanan Anda</h3>
            <table class="item-list">
                <tr>
                    <th>Nama Item</th>
                    <th style="text-align: center;">Harga</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                    <th style="text-align: center;">Hapus</th>
                </tr>

        @php $total_produk = 0; @endphp

        @forelse($cart as $id => $item)
            @php $total_produk += $item['harga'] * $item['jumlah']; @endphp
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td style="text-align: center;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <div class="flex-center">
                        <form action="{{ route('cart.update') }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="action" value="minus">
                            <button type="submit" class="qty-btn">-</button>
                        </form>
                        <span class="qty-display">{{ $item['jumlah'] }}</span>
                        <form action="{{ route('cart.update') }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="action" value="plus">
                            <button type="submit" class="qty-btn">+</button>
                        </form>
                    </div>
                </td>
                <td class="item-price">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <form action="{{ route('cart.remove') }}" method="POST" style="margin:0;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="remove-btn">🗑️</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #888;">Keranjang kosong.</td>
            </tr>
        @endforelse
            </table>
        </div>

        <div class="section-box">
            <h3>📍 Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> {{ Auth::user()->name ?? 'Pengguna' }}</p>
            <p><strong>No. Telp:</strong> {{ Auth::user()->no_hp ?? '-' }}</p>
        </div>

        @if(!empty($cart))
        <div class="section-box">
            <h3>📦 Pengiriman / Pengambilan</h3>
            <div class="radio-group">
                <label><input type="radio" name="delivery_method" value="pickup" checked onchange="toggleDeliveryMethod()" form="form-checkout"> 🛍️ Ambil di Klinik</label>
                <label><input type="radio" name="delivery_method" value="delivery" onchange="toggleDeliveryMethod()" form="form-checkout"> 🛵 Kirim ke Rumah</label>
            </div>

            <div id="delivery_area" style="display: none;">
                <div class="form-group">
                    <label>Cari Lokasi / Klik di Peta</label>
                    <div style="display: flex; gap: 5px;">
                        <input id="search-input" type="text" placeholder="Ketik daerah (Contoh: Subang)">
<button type="button" onclick="searchLocation()" style="background: #36005E; color: white; border: none; padding: 0 15px; border-radius: 4px; cursor: pointer;">Cari</button>
                    </div>
                </div>
                <div id="map"></div>
                <input type="hidden" name="latitude" id="lat" form="form-checkout">
                <input type="hidden" name="longitude" id="lng" form="form-checkout">
                <input type="hidden" name="ongkir" id="input_ongkir" value="0" form="form-checkout">
                <input type="hidden" name="jarak_km" id="input_jarak_km" value="0" form="form-checkout">
                <div class="form-group">
                    <label>Detail Alamat (Otomatis terisi saat klik peta)</label>
                    <textarea name="address" id="address" rows="3" placeholder="Contoh: Rumah pagar hitam samping warung" form="form-checkout"></textarea>
                </div>
            </div>

            <div id="pickup_area">
                <div class="form-group">
                    <label>Pilih Waktu Pengambilan</label>
                    <input type="datetime-local" name="pickup_time" id="pickup_time" form="form-checkout">
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="co-right">
        <h3>Ringkasan Pembayaran</h3>
        <table style="width: 100%; color: #555; margin-bottom:15px;">
            <tr><td>Total Produk</td><td style="text-align: right;">Rp {{ number_format($total_produk, 0, ',', '.') }}</td></tr>
            <tr id="row_ongkir" style="display: none;">
                <td>Ongkos Kirim <span id="badge_jarak" class="jarak-badge">0 KM</span></td>
                <td style="text-align: right; color: #d9534f; font-weight: bold;" id="display_ongkir">Rp 0</td>
            </tr>
        </table>
        <div class="total-box">
            <span>Total Tagihan</span>
            <span id="display_total_tagihan">Rp {{ number_format($total_produk, 0, ',', '.') }}</span>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" id="form-checkout">
            @csrf
            <h4 style="margin: 20px 0 10px; color: #555;">Metode Pembayaran</h4>
            <div class="radio-group" style="flex-direction: column; gap: 10px; background: white;">
                <label><input type="radio" name="payment_method" value="transfer" checked onchange="togglePaymentMethod()"> 💳 Transfer / QRIS</label>
                <label id="cash_option_label"><input type="radio" name="payment_method" value="cash" onchange="togglePaymentMethod()"> 💵 Tunai / COD</label>
            </div>

            <div id="transfer_area">
                <div class="qris-box">
                    <h4>Scan QRIS D&F Pets</h4>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg">
                </div>
                <div class="form-group">
                    <label>Unggah Bukti Bayar</label>
                    <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/*" required>
                </div>
            </div>

            <div id="cash_area" style="display: none; padding: 15px; background: #e9ecef; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                Siapkan uang tunai sebesar <strong id="cash_display_total">Rp {{ number_format($total_produk, 0, ',', '.') }}</strong>.
            </div>

            <button type="submit" class="btn-pay" @if(empty($cart)) disabled style="background:#ccc" @endif>Konfirmasi Pesanan</button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let baseTotal = {{ $total_produk }};
    let ongkirSekarang = 0;
    const CLINIC_COORDS = [-6.5612, 107.7621]; // Subang
    const TARIF_PER_KM = 1000;

    let map, marker;

    function initMap() {
        map = L.map('map').setView(CLINIC_COORDS, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker khusus Klinik (Tujuan Pick Up)
        L.marker(CLINIC_COORDS).addTo(map).bindPopup("Lokasi Klinik D&F Pets").openPopup();

        // Marker Pengiriman (Draggable)
        marker = L.marker(CLINIC_COORDS, { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            updateLocation(marker.getLatLng());
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updateLocation(e.latlng);
        });
    }

    function updateLocation(latlng) {
        document.getElementById('lat').value = latlng.lat;
        document.getElementById('lng').value = latlng.lng;

        // Reverse Geocoding (Cari Nama Alamat) pake Nominatim (Gratis)
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`)
            .then(res => res.json())
            .then(data => {
                if (data.display_name) document.getElementById('address').value = data.display_name;
            });

        // Hitung Jarak
        const distance = map.distance(CLINIC_COORDS, [latlng.lat, latlng.lng]);
        const distanceKm = Math.ceil(distance / 1000);

        ongkirSekarang = distanceKm * TARIF_PER_KM;
        document.getElementById('badge_jarak').innerText = distanceKm + ' KM';
        document.getElementById('input_jarak_km').value = distanceKm;
        updateRingkasanTagihan();
    }

    function searchLocation() {
        const query = document.getElementById('search-input').value;
        if (!query) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    const latlng = { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon) };
                    map.setView(latlng, 15);
                    marker.setLatLng(latlng);
                    updateLocation(latlng);
                } else {
                    alert("Lokasi tidak ditemukan.");
                }
            });
    }

    function updateRingkasanTagihan() {
        const totalAkhir = baseTotal + ongkirSekarang;
        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

        document.getElementById('display_ongkir').innerText = formatter.format(ongkirSekarang);
        document.getElementById('display_total_tagihan').innerText = formatter.format(totalAkhir);
        document.getElementById('cash_display_total').innerText = formatter.format(totalAkhir);
        document.getElementById('input_ongkir').value = ongkirSekarang;
    }

    function toggleDeliveryMethod() {
        const method = document.querySelector('input[name="delivery_method"]:checked').value;
        const deliveryArea = document.getElementById('delivery_area');
        const pickupArea = document.getElementById('pickup_area');
        const rowOngkir = document.getElementById('row_ongkir');

        if (method === 'delivery') {
            deliveryArea.style.display = 'block';
            pickupArea.style.display = 'none';
            rowOngkir.style.display = 'table-row';
            setTimeout(() => map.invalidateSize(), 200); // Penting buat Leaflet di elemen hidden
        } else {
            deliveryArea.style.display = 'none';
            pickupArea.style.display = 'block';
            rowOngkir.style.display = 'none';
            ongkirSekarang = 0;
            updateRingkasanTagihan();
        }
    }

    function togglePaymentMethod() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        document.getElementById('transfer_area').style.display = method === 'transfer' ? 'block' : 'none';
        document.getElementById('cash_area').style.display = method === 'cash' ? 'block' : 'none';
        document.getElementById('bukti_bayar').required = method === 'transfer';
    }

    document.addEventListener("DOMContentLoaded", function() {
        initMap();
        toggleDeliveryMethod();
        togglePaymentMethod();
    });
</script>
@endsection
