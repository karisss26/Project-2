@extends('layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')
<style>
    .co-container { display: flex; gap: 30px; flex-wrap: wrap; }
    .co-left { flex: 2; min-width: 300px; }
    .co-right { flex: 1; min-width: 300px; background: #f8f9fa; padding: 25px; border-radius: 8px; border: 1px solid #E6E6FA; }

    .section-box { background: white; padding: 20px; border-radius: 8px; border: 1px solid #eee; margin-bottom: 20px; }
    .section-box h3 { color: #800080; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #E6E6FA; padding-bottom: 10px; }

    .item-list { width: 100%; border-collapse: collapse; }
    .item-list th, .item-list td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .item-list th { color: #555; }
    .item-price { text-align: right; font-weight: bold; }

    .total-box { margin-top: 20px; padding-top: 15px; border-top: 2px dashed #ccc; display: flex; justify-content: space-between; font-size: 20px; font-weight: bold; color: #800080; }
    .qris-box { text-align: center; margin: 20px 0; padding: 20px; background: white; border-radius: 8px; border: 1px dashed #800080; }
    .qris-box img { max-width: 200px; margin-bottom: 10px; }

    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
    .form-group input[type="file"], .form-group input[type="datetime-local"], .form-group textarea, .form-group input[type="text"] { width: 100%; padding: 10px; background: white; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }

    .btn-pay { width: 100%; padding: 15px; background: #800080; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
    .btn-pay:hover { background: #4B0082; }

    .qty-btn { background: #E6E6FA; color: #800080; border: none; width: 25px; height: 25px; border-radius: 4px; font-weight: bold; cursor: pointer; }
    .qty-btn:hover { background: #800080; color: white; }
    .remove-btn { background: none; border: none; color: #dc3545; font-size: 18px; cursor: pointer; transition: 0.2s; }
    .remove-btn:hover { transform: scale(1.2); }
    .qty-display { display: inline-block; width: 30px; text-align: center; font-weight: bold; }
    .flex-center { display: flex; align-items: center; justify-content: center; gap: 5px; }

    #map { height: 350px; width: 100%; border-radius: 8px; border: 1px solid #ccc; margin-bottom: 15px; }

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
                            <button type="submit" class="qty-btn" title="Kurangi">-</button>
                        </form>

                        <span class="qty-display">{{ $item['jumlah'] }}</span>

                        <form action="{{ route('cart.update') }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="action" value="plus">
                            <button type="submit" class="qty-btn" title="Tambah">+</button>
                        </form>
                    </div>
                </td>

                <td class="item-price">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>

                <td style="text-align: center;">
                    <form action="{{ route('cart.remove') }}" method="POST" style="margin:0;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="remove-btn" title="Hapus Item">🗑️</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #888;">
                    Keranjang kamu masih kosong nih. Yuk <a href="{{ route('dashboard.katalog') }}" style="color:#800080; font-weight:bold;">belanja dulu!</a>
                </td>
            </tr>
        @endforelse
            </table>
        </div>

        <div class="section-box">
            <h3>📍 Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> {{ Auth::user()->name ?? 'Pengguna' }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email ?? 'Email tidak tersedia' }}</p>
        </div>

        @if(!empty($cart))
        <div class="section-box">
            <h3>📦 Pengiriman / Pengambilan</h3>

            <div class="radio-group">
                <label>
                    <input type="radio" name="delivery_method" value="pickup" checked onchange="toggleDeliveryMethod()" form="form-checkout">
                    🛍️ Ambil di Klinik (Pick Up)
                </label>
                <label>
                    <input type="radio" name="delivery_method" value="delivery" onchange="toggleDeliveryMethod()" form="form-checkout">
                    🛵 Kirim ke Rumah (Delivery)
                </label>
            </div>

            <div id="delivery_area" style="display: none;">
                <div class="form-group">
                    <label for="pac-input">Cari Lokasi Pengiriman</label>
                    <input id="pac-input" type="text" placeholder="Ketik nama jalan, gedung, atau daerah...">
                </div>

                <div id="map"></div>

                <input type="hidden" name="latitude" id="lat" form="form-checkout">
                <input type="hidden" name="longitude" id="lng" form="form-checkout">
                <input type="hidden" name="ongkir" id="input_ongkir" value="0" form="form-checkout">
                <input type="hidden" name="jarak_km" id="input_jarak_km" value="0" form="form-checkout">

                <div class="form-group">
                    <label for="address">Detail Alamat</label>
                    <textarea name="address" id="address" rows="3" placeholder="Peta akan otomatis mengisi alamat di sini. Tambahkan patokan jika perlu (misal: Rumah warna biru pagar hitam)" form="form-checkout"></textarea>
                </div>
            </div>

            <div id="pickup_area">
                <div class="form-group">
                    <label for="pickup_time">Pilih Waktu Pengambilan ke Klinik</label>
                    <input type="datetime-local" name="pickup_time" id="pickup_time" form="form-checkout">
                </div>
            </div>

        </div>
        @endif
    </div>

    <div class="co-right">
        <h3 style="color: #333; margin-bottom: 10px;">Ringkasan Pembayaran</h3>
        <table style="width: 100%; color: #555; margin-bottom:15px;">
            <tr><td style="padding: 5px 0;">Total Produk</td><td style="text-align: right;">Rp {{ number_format($total_produk, 0, ',', '.') }}</td></tr>

            <tr id="row_ongkir" style="display: none;">
                <td style="padding: 5px 0;">
                    Ongkos Kirim
                    <span id="badge_jarak" class="jarak-badge">0 KM</span>
                </td>
                <td style="text-align: right; color: #d9534f; font-weight: bold;" id="display_ongkir">Rp 0</td>
            </tr>
        </table>

        <div class="total-box">
            <span>Total Tagihan</span>
            <span id="display_total_tagihan">Rp {{ number_format($total_produk, 0, ',', '.') }}</span>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" id="form-checkout">
            @csrf

            <hr style="border: 0; border-top: 1px solid #ccc; margin: 20px 0;">

            <h4 style="margin-bottom: 10px; color: #555;">Metode Pembayaran</h4>
            <div class="radio-group" style="flex-direction: column; gap: 10px; background: white;">
                <label>
                    <input type="radio" name="payment_method" value="transfer" checked onchange="togglePaymentMethod()">
                    💳 Transfer Bank / QRIS
                </label>
                <label id="cash_option_label">
                    <input type="radio" name="payment_method" value="cash" onchange="togglePaymentMethod()">
                    💵 Tunai (Bayar di Klinik / COD)
                </label>
            </div>

            <div id="transfer_area">
                <div class="qris-box">
                    <h4 style="margin-bottom: 10px; color: #800080;">Scan QRIS D&F Pets</h4>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QRIS Code">
                    <p style="font-size: 12px; color: #666;">Scan menggunakan m-Banking atau e-Wallet favorit Anda.</p>
                </div>

                <div class="form-group" style="position: relative;">
                    <label for="bukti_bayar">Unggah Bukti Pembayaran</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/png, image/jpeg, image/jpg" required onchange="cekFile(this)">
                        <button type="button" id="btn-batal-file" onclick="batalUpload()" style="display: none; background: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;">Batal</button>
                    </div>
                </div>
            </div>

            <div id="cash_area" style="display: none; text-align: center; padding: 20px; background: #e2e3e5; border-radius: 8px; margin-bottom: 20px;">
                <h4 style="color: #333; margin-bottom: 5px;">Pembayaran Tunai (Cash)</h4>
                <p style="font-size: 13px; color: #555;">
                    Silakan siapkan uang tunai sebesar <strong id="cash_display_total">Rp {{ number_format($total_produk, 0, ',', '.') }}</strong>. <br><br>
                    Bayarkan di meja kasir saat mengambil pesanan, atau kepada kurir kami saat pesanan diantar (COD).
                </p>
            </div>

            <button type="submit" class="btn-pay" @if(empty($cart)) style="background: #ccc; cursor: not-allowed;" disabled @endif>
                Konfirmasi Pesanan
            </button>
        </form>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5V_VOnPaboXlKYmpPD2rn5kx1b5pdY5M&libraries=places,geometry&callback=initMap" async defer></script>

<script>
    let baseTotal = {{ $total_produk }};
    let ongkirSekarang = 0;

    const CLINIC_LAT = -6.5612;
    const CLINIC_LNG = 107.7621;
    const TARIF_PER_KM = 5000;

    let map, marker, geocoder;

    function initMap() {
        const defaultLocation = { lat: CLINIC_LAT, lng: CLINIC_LNG };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 15,
            mapTypeControl: false,
        });

        marker = new google.maps.Marker({
            map: map,
            position: defaultLocation,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        geocoder = new google.maps.Geocoder();

        const input = document.getElementById("pac-input");
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                window.alert("Lokasi tidak ditemukan. Coba ketik lebih spesifik.");
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
            marker.setPosition(place.geometry.location);
            updateFormFromMarker(place.geometry.location, place.formatted_address);
        });

        marker.addListener("dragend", () => {
            const pos = marker.getPosition();
            geocodePosition(pos);
        });

        map.addListener("click", (e) => {
            marker.setPosition(e.latLng);
            geocodePosition(e.latLng);
        });
    }

    function geocodePosition(pos) {
        geocoder.geocode({ location: pos }, (results, status) => {
            if (status === "OK" && results[0]) {
                updateFormFromMarker(pos, results[0].formatted_address);
            } else {
                updateFormFromMarker(pos, "");
            }
        });
    }

    function updateFormFromMarker(location, address) {
        document.getElementById('lat').value = location.lat();
        document.getElementById('lng').value = location.lng();
        if (address) {
            document.getElementById('address').value = address;
        }
        hitungOngkirOtomatis(location);
    }

    function hitungOngkirOtomatis(destinationLocation) {
        const method = document.querySelector('input[name="delivery_method"]:checked');
        if (method && method.value === 'delivery') {
            const clinicLocation = new google.maps.LatLng(CLINIC_LAT, CLINIC_LNG);
            const distanceInMeters = google.maps.geometry.spherical.computeDistanceBetween(clinicLocation, destinationLocation);
            const distanceInKm = Math.ceil(distanceInMeters / 1000);

            ongkirSekarang = distanceInKm * TARIF_PER_KM;

            document.getElementById('badge_jarak').innerText = distanceInKm + ' KM';
            document.getElementById('input_jarak_km').value = distanceInKm;
            updateRingkasanTagihan();
        }
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka).replace('Rp', 'Rp ').replace(',00', '');
    }

    function updateRingkasanTagihan() {
        const totalAkhir = baseTotal + ongkirSekarang;

        document.getElementById('display_ongkir').innerText = formatRupiah(ongkirSekarang);
        document.getElementById('display_total_tagihan').innerText = formatRupiah(totalAkhir);
        document.getElementById('cash_display_total').innerText = formatRupiah(totalAkhir);
        document.getElementById('input_ongkir').value = ongkirSekarang;
    }

    function cekFile(input) {
        const btnBatal = document.getElementById('btn-batal-file');
        if (input.files && input.files[0]) {
            btnBatal.style.display = 'inline-block';
        }
    }

    function batalUpload() {
        const input = document.getElementById('bukti_bayar');
        const btnBatal = document.getElementById('btn-batal-file');
        input.value = '';
        btnBatal.style.display = 'none';
    }

    function toggleDeliveryMethod() {
        const method = document.querySelector('input[name="delivery_method"]:checked');
        if (!method) return;

        const deliveryArea = document.getElementById('delivery_area');
        const pickupArea = document.getElementById('pickup_area');
        const addressInput = document.getElementById('address');
        const pickupInput = document.getElementById('pickup_time');
        const rowOngkir = document.getElementById('row_ongkir');

        if (method.value === 'delivery') {
            deliveryArea.style.display = 'block';
            pickupArea.style.display = 'none';

            addressInput.setAttribute('required', 'required');
            if (pickupInput) pickupInput.removeAttribute('required');

            rowOngkir.style.display = 'table-row';

            if (typeof google !== 'undefined' && map && marker) {
                google.maps.event.trigger(map, "resize");
                map.setCenter(marker.getPosition());
                hitungOngkirOtomatis(marker.getPosition());
            }
        } else {
            deliveryArea.style.display = 'none';
            pickupArea.style.display = 'block';

            addressInput.removeAttribute('required');
            if (pickupInput) pickupInput.setAttribute('required', 'required');

            rowOngkir.style.display = 'none';
            ongkirSekarang = 0;
            updateRingkasanTagihan();
        }
    }

    function togglePaymentMethod() {
        const payMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!payMethod) return;

        const transferArea = document.getElementById('transfer_area');
        const cashArea = document.getElementById('cash_area');
        const buktiInput = document.getElementById('bukti_bayar');

        if (payMethod.value === 'transfer') {
            transferArea.style.display = 'block';
            cashArea.style.display = 'none';
            buktiInput.setAttribute('required', 'required');
        } else {
            transferArea.style.display = 'none';
            cashArea.style.display = 'block';
            buktiInput.removeAttribute('required');
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        toggleDeliveryMethod();
        togglePaymentMethod();
    });
</script>
@endsection
