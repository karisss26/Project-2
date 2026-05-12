<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Ticket Reservasi</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #111827; }
        .container { padding: 24px; }
        .header { display: flex; align-items: center; justify-content: space-between; }
        .title { font-size: 20px; font-weight: 800; color: #6d28d9; }
        .brand { font-size: 14px; color: #374151; }
        .badge { display: inline-block; padding: 6px 10px; border-radius: 999px; background: #f3f4f6; font-size: 12px; font-weight: 700; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px; }
        .card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; }
        .k { font-size: 12px; color: #6b7280; margin-bottom: 6px; }
        .v { font-size: 14px; font-weight: 700; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table th, .table td { border-bottom: 1px solid #e5e7eb; padding: 10px 0; text-align: left; font-size: 13px; }
        .table th { color: #6b7280; font-weight: 700; }
        .footer { margin-top: 18px; font-size: 12px; color: #6b7280; }
        .qr { margin-top: 14px; }
        .watermark { position: fixed; bottom: 18px; right: 18px; font-size: 10px; color: #d1d5db; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <div class="title">E-Ticket Reservasi</div>
            <div class="brand">Paw Center (D&F Pets)</div>
        </div>
        <div style="text-align:right;">
            <div class="badge">Reservasi #{{ $reservasi->id }}</div>
            <div style="margin-top:6px; font-size:12px; color:#6b7280;">Status: {{ $reservasi->status }}</div>
        </div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="k">Nama Layanan</div>
            <div class="v">{{ $reservasi->nama_layanan }}</div>
        </div>
        <div class="card">
            <div class="k">Tanggal & Waktu</div>
            <div class="v">
                {{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}<br>
                {{ $reservasi->waktu }} WIB
            </div>
        </div>

        <div class="card">
            <div class="k">Nama Pemilik</div>
            <div class="v">{{ $user->name ?? '-' }}</div>
            <div style="margin-top:8px; font-size:12px; color:#6b7280;">No HP: {{ $user->no_hp ?? '-' }}</div>
        </div>
        <div class="card">
            <div class="k">Hewan</div>
            <div class="v">{{ $reservasi->pet_name ?? '-' }}</div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Rincian Pembayaran</th>
            <th style="text-align:right;">Nilai</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Harga Total</td>
            <td style="text-align:right; font-weight:700;">Rp {{ number_format($reservasi->harga_total ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>DP (30%)</td>
            <td style="text-align:right; font-weight:700;">Rp {{ number_format($reservasi->dp ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Sisa Bayar (Di Klinik)</td>
            <td style="text-align:right; font-weight:700;">Rp {{ number_format($reservasi->sisa_bayar ?? 0, 0, ',', '.') }}</td>
        </tr>
        </tbody>
    </table>

    <div class="footer">
        Harap datang tepat waktu. Tunjukkan e-ticket ini pada petugas Paw Center.
    </div>

    <div class="watermark">Generated on {{ now()->format('d M Y H:i') }}</div>
</div>
</body>
</html>

