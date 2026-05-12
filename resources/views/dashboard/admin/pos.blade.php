@extends('layouts.app')

@section('title', 'POS Kasir')

@section('content')
<style>
    .pos-layout { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 18px; }
    @media (max-width: 1000px) { .pos-layout { grid-template-columns: 1fr; } }

    .section { background: #fff; border-radius: 12px; border: 1px solid #E6E6FA; padding: 18px; }
    .section h3 { margin: 0 0 12px; color: #36005E; font-size: 18px; border-bottom: 2px dashed #F7F1FF; padding-bottom: 10px; }

    .product-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    @media (max-width: 680px) { .product-grid { grid-template-columns: 1fr; } }

    .product-card { border: 1px solid #eee; border-radius: 12px; padding: 12px; }
    .product-name { font-weight: 800; color: #4c1d95; }
    .product-meta { font-size: 12px; color: #6b7280; margin-top: 3px; }

    .btn { padding: 10px 12px; border-radius: 10px; border: none; cursor: pointer; font-weight: 800; }
    .btn-add { background: #36005E; color: #fff; width: 100%; margin-top: 10px; }

    .qty-controls { display:flex; gap: 8px; align-items:center; justify-content: flex-end; }
    .qty-btn { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #E6E6FA; background: #F7F1FF; cursor:pointer; font-weight:900; }

    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 10px 6px; border-bottom: 1px solid #f1f1f1; font-size: 13px; }
    .table th { text-align: left; color: #4c1d95; }

    .summary-row { display:flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
    .total { font-size: 18px; font-weight: 900; color: #36005E; }

    .btn-primary { background: #36005E; color: white; width: 100%; padding: 14px; border-radius: 12px; }
    .btn-secondary { background: #6b7280; color: white; width: 100%; padding: 12px; border-radius: 12px; }

    .empty-state { color:#6b7280; font-size: 14px; padding: 14px; border: 1px dashed #e5e7eb; border-radius: 12px; }
</style>

<div class="pos-layout">
    <div class="section">
        <h3>🧾 Produk</h3>

        <form method="GET" action="{{ route('admin.pos.index') }}" style="margin-bottom: 14px;">
            <div style="display:flex; gap:10px; align-items:center;">
                <input type="text" name="search" value="{{ $query }}" placeholder="Cari produk / kategori..." style="flex:1; padding: 12px 14px; border: 1px solid #ddd; border-radius: 10px;" />
                <button class="btn" style="background:#36005E; color:#fff; padding: 12px 16px; border-radius:10px;" type="submit">Cari</button>
            </div>
        </form>

        <div class="product-grid">
            @forelse($produks as $p)
                <div class="product-card">
                    <div class="product-name">{{ $p->nama_produk }}</div>
                    <div class="product-meta">Kategori: {{ $p->kategori ?? '-' }}</div>
                    <div class="product-meta">Harga: Rp {{ number_format($p->harga, 0, ',', '.') }}</div>

                    <input type="hidden" class="product-id" value="{{ $p->id }}">
                    <button type="button" class="btn btn-add" onclick="addItem({{ $p->id }}, '{{ addslashes($p->nama_produk) }}', {{ (float)$p->harga }})">+ Tambah</button>
                </div>
            @empty
                <div class="empty-state">Produk tidak ditemukan.</div>
            @endforelse
        </div>
    </div>

    <div class="section">
        <h3>🧺 Keranjang & Pembayaran</h3>

        @if(session('success'))
            <div style="background:#d4edda; border-left:5px solid #28a745; padding: 12px 14px; border-radius: 10px; color:#155724; font-weight:800; margin-bottom: 12px;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da; border-left:5px solid #dc3545; padding: 12px 14px; border-radius: 10px; color:#721c24; font-weight:800; margin-bottom: 12px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        @error('items')
            <div style="background:#f8d7da; border-left:5px solid #dc3545; padding: 12px 14px; border-radius: 10px; color:#721c24; font-weight:800; margin-bottom: 12px;">{{ $message }}</div>
        @enderror

        <div style="max-height: 360px; overflow:auto; border: 1px solid #f1f1f1; border-radius: 12px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align:right;">Qty</th>
                        <th style="text-align:right;">Subtotal</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                </tbody>
            </table>
            <div id="cart-empty" class="empty-state" style="display:block; border:none;" >Keranjang kosong. Tambahkan produk dari sisi kiri.</div>
        </div>

        <form method="POST" action="{{ route('admin.pos.checkout') }}" enctype="multipart/form-data" id="pos-form" style="margin-top: 14px;">
            @csrf

            <input type="hidden" name="payment_method" id="payment_method" value="cash">

            {{-- items harus array (akan di-parse server) --}}
            <input type="hidden" name="items_json" id="items-json" value="[]">

            <input type="hidden" name="items" id="items-hidden" value="[]">


            <div style="margin-bottom: 12px;">
                <div style="font-weight: 900; color:#4c1d95; margin-bottom: 6px;">Metode bayar</div>
                <div style="display:flex; gap:10px; flex-direction: column;">
                    <label style="display:flex; gap:10px; align-items:center;">
                        <input type="radio" name="payment_method_radio" value="cash" checked onclick="setPayment('cash')"> 💵 Tunai / COD
                    </label>
                    <label style="display:flex; gap:10px; align-items:center;">
                        <input type="radio" name="payment_method_radio" value="transfer" onclick="setPayment('transfer')"> 💳 Transfer / QRIS
                    </label>
                </div>
            </div>

            <div id="transfer-area" style="display:none; margin-bottom: 12px;">
                <div style="font-weight: 900; color:#4c1d95; margin-bottom: 6px;">Upload bukti pembayaran (opsional)</div>
                <input type="file" name="bukti_bayar" accept="image/*" style="width:100%; padding: 10px; border:1px solid #ddd; border-radius: 10px;" />
            </div>

            {{-- items JSON ke input hidden --}}
            <input type="hidden" name="items" id="items-hidden" value="[]">

            <div class="summary-row"><span>Total</span><span class="total" id="total-display">Rp 0</span></div>

            <button type="submit" class="btn-primary btn" id="checkout-btn" disabled style="opacity:0.6;">Buat Transaksi</button>
        </form>

        <button type="button" class="btn-secondary btn" style="margin-top: 10px;" onclick="clearCart()">Kosongkan</button>
    </div>
</div>

<script>
    const cart = new Map(); // produk_id => {produk_id,nama,harga,qty}

    function formatIDR(n) {
        return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', maximumFractionDigits:0 }).format(n);
    }

    function setPayment(method) {
        document.getElementById('payment_method').value = method;
        const transferArea = document.getElementById('transfer-area');
        transferArea.style.display = method === 'transfer' ? 'block' : 'none';
    }

    function addItem(produkId, nama, harga) {
        if (cart.has(produkId)) {
            cart.get(produkId).qty += 1;
        } else {
            cart.set(produkId, { produk_id: produkId, nama: nama, harga: harga, qty: 1 });
        }
        renderCart();
    }

    function changeQty(produkId, delta) {
        if (!cart.has(produkId)) return;
        const row = cart.get(produkId);
        row.qty += delta;
        if (row.qty <= 0) cart.delete(produkId);
        renderCart();
    }

    function clearCart() {
        cart.clear();
        renderCart();
    }

    function renderCart() {
        const tbody = document.getElementById('cart-body');
        tbody.innerHTML = '';

        const empty = document.getElementById('cart-empty');
        const checkoutBtn = document.getElementById('checkout-btn');

        const itemsArr = [];
        let total = 0;

        cart.forEach((row, key) => {
            const subtotal = row.harga * row.qty;
            total += subtotal;

            itemsArr.push({ produk_id: row.produk_id, qty: row.qty });

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.nama}</td>
                <td style="text-align:right;">
                    <div class="qty-controls">
                        <button type="button" class="qty-btn" onclick="changeQty(${row.produk_id}, -1)">-</button>
                        <span style="min-width:28px; text-align:center; font-weight:900;">${row.qty}</span>
                        <button type="button" class="qty-btn" onclick="changeQty(${row.produk_id}, 1)">+</button>
                    </div>
                </td>
                <td style="text-align:right; font-weight:900; color:#36005E;">${formatIDR(subtotal)}</td>
                <td style="text-align:right;">
                    <button type="button" class="qty-btn" onclick="changeQty(${row.produk_id}, -999)">🗑️</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('items-hidden').value = JSON.stringify(itemsArr);
        document.getElementById('total-display').innerText = formatIDR(total);

        if (cart.size === 0) {
            empty.style.display = 'block';
            checkoutBtn.disabled = true;
            checkoutBtn.style.opacity = 0.6;
        } else {
            empty.style.display = 'none';
            checkoutBtn.disabled = false;
            checkoutBtn.style.opacity = 1;
        }
    }

    // init
    renderCart();
    setPayment('cash');

    document.getElementById('pos-form').addEventListener('submit', function(e) {
        // items-hidden sudah terisi
        if (cart.size === 0) {
            e.preventDefault();
            alert('Keranjang masih kosong.');
        }
    });
</script>
@endsection

