    /* Override card styling on receipt page */
    .card {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #f5f5f5;
    }

    /* Ensure proper layout context */
    @supports (display: grid) {
        body {
            display: block !important;
        }
    }

    #receipt-page {
        padding: 20px;
        margin: 0;
    }

    .content {
        background: transparent !important;
        padding: 0 !important;
    }

    .receipt-container {
        max-width: 80mm;
        width: 80mm;
        margin: 0;
        padding: 0;
        background-color: white;
        border-radius: 0;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: block;
    }

    .receipt-header {
        background: linear-gradient(135deg, #800080 0%, #a020f0 100%);
        color: white;
        padding: 15px 10px;
        text-align: center;
        border-bottom: 2px dashed rgba(255, 255, 255, 0.3);
    }

    .receipt-header h1 {
        font-size: 16px;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .receipt-header p {
        font-size: 11px;
        opacity: 0.95;
        margin-bottom: 3px;
    }

    .receipt-body {
        padding: 12px 10px;
    }

    .receipt-section {
        margin-bottom: 12px;
    }

    .receipt-section-title {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        color: #800080;
        margin-bottom: 8px;
        padding-bottom: 5px;
        border-bottom: 1px solid #e0e0e0;
        letter-spacing: 0.5px;
    }

    .receipt-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .receipt-info-row label {
        color: #666;
        font-weight: 500;
    }

    .receipt-info-row .value {
        font-weight: 600;
        color: #333;
        text-align: right;
    }

    .receipt-items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-size: 10px;
    }

    .receipt-items-table thead {
        border-bottom: 1px solid #e0e0e0;
    }

    .receipt-items-table th {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        color: #800080;
        padding: 5px 0;
        text-align: left;
        letter-spacing: 0.3px;
    }

    .receipt-items-table th:nth-child(2),
    .receipt-items-table th:nth-child(3),
    .receipt-items-table th:nth-child(4) {
        text-align: right;
    }

    .receipt-items-table tbody tr {
        border-bottom: 1px dotted #f0f0f0;
    }

    .receipt-items-table td {
        padding: 5px 0;
        font-size: 10px;
        color: #333;
    }

    .receipt-items-table td:nth-child(2),
    .receipt-items-table td:nth-child(3),
    .receipt-items-table td:nth-child(4) {
        text-align: right;
    }

    .receipt-items-table .product-name {
        font-weight: 600;
        max-width: 120px;
        word-wrap: break-word;
    }

    .receipt-summary {
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 4px;
        border-left: 3px solid #800080;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .summary-row:last-child {
        margin-bottom: 0;
    }

    .summary-row label {
        color: #666;
        font-weight: 500;
    }

    .summary-row .value {
        font-weight: 600;
        color: #333;
    }

    .summary-row.total {
        font-size: 13px;
        padding-top: 8px;
        margin-top: 8px;
        border-top: 1px solid #ddd;
    }

    .summary-row.total label {
        color: #800080;
        font-weight: 700;
    }

    .summary-row.total .value {
        color: #800080;
        font-size: 14px;
        font-weight: 900;
    }

    .payment-method {
        background-color: #f0f0f0;
        padding: 8px;
        border-radius: 4px;
        margin-top: 8px;
        font-size: 11px;
    }

    .payment-method label {
        color: #666;
        display: block;
        margin-bottom: 3px;
        font-weight: 600;
    }

    .payment-method .value {
        color: #800080;
        font-weight: 700;
        font-size: 12px;
    }

    .kembalian-section {
        background-color: #e8f5e9;
        border-left: 3px solid #28a745;
        padding: 8px;
        border-radius: 4px;
        margin-top: 8px;
        font-size: 11px;
    }

    .kembalian-section label {
        color: #2e7d32;
        display: block;
        margin-bottom: 3px;
        font-weight: 600;
    }

    .kembalian-section .value {
        color: #28a745;
        font-weight: 700;
        font-size: 12px;
    }

    .receipt-footer {
        background-color: #f5f5f5;
        padding: 12px 10px;
        text-align: center;
        border-top: 1px dashed #ddd;
    }

    .receipt-footer p {
        font-size: 10px;
        color: #666;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .receipt-footer-text {
        font-size: 11px;
        color: #800080;
        font-weight: 700;
        margin-top: 6px;
        padding: 6px;
        background-color: white;
        border-radius: 4px;
        border: 1px solid #e0e0e0;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        padding: 15px;
    }

    .btn {
        flex: 1;
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-print {
        background: linear-gradient(135deg, #800080 0%, #a020f0 100%);
        color: white;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(128, 0, 128, 0.3);
    }

    .btn-next {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
    }

    .btn-next:hover {
        background-color: #e0e0e0;
    }

    @media print {
        html, body {
            width: 80mm !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            line-height: 1.4 !important;
        }

        body {
            background-color: white !important;
        }

        /* Hide sidebar */
        .sidebar, .sidebar-header, .menu-items, .logout-btn-sidebar {
            display: none !important;
        }

        /* Hide header with user greeting */
        .header, [class*="topbar"], [class*="navbar"], nav {
            display: none !important;
        }

        /* Show main content but remove card styling */
        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 80mm !important;
        }

        .content {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 80mm !important;
            background: transparent !important;
        }

        /* Hide card wrapper if present */
        .card {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 80mm !important;
        }

        /* Hide action buttons */
        .action-buttons, .buttons, .controls {
            display: none !important;
        }

        #receipt-page {
            padding: 0 !important;
            margin: 0 !important;
            width: 80mm !important;
            max-width: 80mm !important;
        }

        .receipt-container {
            max-width: 80mm !important;
            width: 80mm !important;
            margin: 0 !important;
            padding: 12px !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            page-break-after: avoid;
        }

        .receipt-header {
            padding: 10px !important;
            margin: 0 0 12px 0 !important;
            line-height: 1.3 !important;
        }

        .receipt-header h1 {
            margin: 0 0 4px 0 !important;
            line-height: 1.2 !important;
        }

        .receipt-header p {
            margin: 2px 0 !important;
            line-height: 1.2 !important;
        }

        .receipt-body {
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1.4 !important;
        }

        .receipt-section {
            margin-bottom: 10px !important;
            padding: 0 !important;
        }

        .receipt-section-title {
            margin: 8px 0 6px 0 !important;
            padding: 0 0 4px 0 !important;
            line-height: 1.2 !important;
        }

        .receipt-info-row {
            margin-bottom: 4px !important;
            padding: 2px 0 !important;
            line-height: 1.3 !important;
        }

        .receipt-items-table {
            margin-bottom: 10px !important;
            border-collapse: collapse;
        }

        .receipt-items-table th {
            padding: 4px 0 !important;
            line-height: 1.2 !important;
        }

        .receipt-items-table td {
            padding: 3px 0 !important;
            line-height: 1.2 !important;
        }

        .receipt-summary {
            padding: 8px !important;
            margin: 0 0 10px 0 !important;
        }

        .summary-row {
            margin-bottom: 4px !important;
            padding: 2px 0 !important;
            line-height: 1.2 !important;
        }

        .summary-row.total {
            margin: 6px 0 !important;
            padding: 6px 0 !important;
            line-height: 1.3 !important;
        }

        .payment-method {
            padding: 6px !important;
            margin: 8px 0 !important;
            line-height: 1.3 !important;
        }

        .payment-method label {
            margin: 0 0 2px 0 !important;
        }

        .kembalian-section {
            padding: 6px !important;
            margin: 6px 0 !important;
            line-height: 1.3 !important;
        }

        .receipt-footer {
            padding: 10px !important;
            margin: 12px 0 0 0 !important;
            line-height: 1.3 !important;
        }

        .receipt-footer p {
            margin: 4px 0 !important;
            line-height: 1.2 !important;
        }

        .receipt-footer-text {
            padding: 6px !important;
            margin: 6px 0 !important;
            line-height: 1.3 !important;
        }

        .receipt-header,
        .receipt-body,
        .receipt-footer {
            page-break-inside: avoid;
        }

        @page {
            margin: 0 !important;
            size: 80mm auto !important;
        }
    }
</style>

<div id="receipt-page">
<!-- Receipt Container -->
<div class="receipt-container">
    <!-- Header -->
    <div class="receipt-header">
        <h1>🧾 STRUK PENJUALAN</h1>
        <p>D&F Pet Shop</p>
        <p>Struk #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <!-- Body -->
    <div class="receipt-body">
        <!-- Info Transaksi -->
        <div class="receipt-section">
            <div class="receipt-section-title">Informasi Transaksi</div>
            <div class="receipt-info-row">
                <label>No. Struk</label>
                <span class="value">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="receipt-info-row">
                <label>Tanggal & Jam</label>
                <span class="value">{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="receipt-info-row">
                <label>Kasir</label>
                <span class="value">{{ $transaksi->user->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Items -->
        <div class="receipt-section">
            <div class="receipt-section-title">Detail Barang</div>
            <table class="receipt-items-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->detilProduk as $detail)
                    <tr>
                        <td class="product-name">{{ $detail->produk->nama_produk ?? 'N/A' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="receipt-section">
            <div class="receipt-summary">
                <div class="summary-row">
                    <label>Subtotal</label>
                    <span class="value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row total">
                    <label>Total Pembayaran</label>
                    <span class="value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="receipt-section">
            <div class="payment-method">
                <label>💳 Metode Pembayaran</label>
                <div class="value">
                    @if($transaksi->metode_pembayaran === 'cash')
                        💵 Tunai / COD
                    @elseif($transaksi->metode_pembayaran === 'transfer')
                        💳 Transfer / QRIS
                    @else
                        {{ ucfirst($transaksi->metode_pembayaran) }}
                    @endif
                </div>
            </div>

            @if($transaksi->metode_pembayaran === 'cash' && $transaksi->kembalian)
            <div class="kembalian-section">
                <label>💰 Kembalian</label>
                <div class="value">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="receipt-footer">
        <p>✨ Terima kasih sudah berbelanja di D&F ✨</p>
        <div class="receipt-footer-text">
            Semoga hewan kesayangan Anda sehat dan bahagia!
        </div>
        <p style="margin-top: 15px; font-size: 11px; color: #999;">
            {{ now()->format('d/m/Y H:i:s') }}
        </p>
    </div>
</div>
</div>

<!-- Action Buttons -->
<div class="action-buttons">
    <button type="button" class="btn btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-next">Kelola Transaksi →</a>
</div>

<script>
    // Auto print on page load (optional)
    // window.print();
</script>
@endsection
