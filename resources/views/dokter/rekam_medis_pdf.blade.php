<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekam Medis Dokter</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            line-height: 1.35;
        }
        h2 { margin: 0 0 10px 0; font-size: 18px; }
        .meta { margin-bottom: 14px; color:#444; font-size: 12px; }

        .grid {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }
        .box {
            border: 1px solid #e5e7eb;
            padding: 10px 12px;
            flex: 1 1 220px;
            border-radius: 6px;
        }
        .k {
            color:#6b7280;
            font-size: 11px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .02em;
        }
        .v { font-weight: 700; font-size: 13px; }

        table {
            width:100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        td {
            border: 1px solid #e5e7eb;
            padding: 10px 10px;
            vertical-align: top;
            word-break: break-word;
        }
        .nowrap { white-space: nowrap; }
        .pre { white-space: pre-line; font-family: DejaVu Sans, Arial, sans-serif; }
        .label { width: 160px; color:#374151; font-weight: 700; }
    </style>
</head>
<body>
    <h2>🧾 Rekam Medis Dokter</h2>
    <div class="meta">
        ID Rekam Medis: <b>{{ $rekamMedis->id }}</b>
    </div>

    @php
        $tanggalPeriksaFormatted = null;
        if (!empty($rekamMedis->tanggal_periksa)) {
            try {
                $tanggalPeriksaFormatted = \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d/m/Y H:i');
            } catch (\Throwable $e) {
                $tanggalPeriksaFormatted = (string)$rekamMedis->tanggal_periksa;
            }
        }

        $jadwalPulangFormatted = null;
        if (!empty($rekamMedis->jadwal_pulang)) {
            try {
                $jadwalPulangFormatted = \Carbon\Carbon::parse($rekamMedis->jadwal_pulang)->format('d/m/Y H:i');
            } catch (\Throwable $e) {
                $jadwalPulangFormatted = (string)$rekamMedis->jadwal_pulang;
            }
        }
    @endphp

    <div class="grid">
        <div class="box">
            <div class="k">Tanggal Periksa</div>
            <div class="v">
                {{ $tanggalPeriksaFormatted ?? (optional($rekamMedis->created_at)->format('d/m/Y H:i') ?? '-') }}
            </div>
        </div>
        <div class="box">
            <div class="k">Hewan</div>
            <div class="v">{{ $rekamMedis->hewan->nama_hewan ?? 'N/A' }} ({{ $rekamMedis->hewan->jenis_hewan ?? 'N/A' }} - {{ $rekamMedis->hewan->jenis_kelamin ?? 'N/A' }})</div>
        </div>
        <div class="box">
            <div class="k">Pemilik</div>
            <div class="v">{{ optional(optional($rekamMedis->hewan)->user)->name ?? 'N/A' }}</div>
        </div>
        <div class="box">
            <div class="k">Dokter</div>
            <div class="v">{{ $rekamMedis->user->name ?? 'N/A' }}</div>
        </div>
    </div>

    <table>
        <tr>
            <td class="label">Jadwal Pulang</td>
            <td>{{ $jadwalPulangFormatted ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Catatan Dokter</td>
            <td class="pre">{{ $rekamMedis->catatan_dokter ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Diagnosa</td>
            <td>{{ $rekamMedis->diagnosa ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tindakan</td>
            <td>{{ $rekamMedis->tindakan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Detail</td>
            <td class="pre">{{ $rekamMedis->detail ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Resep Obat</td>
            <td class="pre">{{ $rekamMedis->resep_obat ?? '-' }}</td>
        </tr>
    </table>
</body>
</html>
