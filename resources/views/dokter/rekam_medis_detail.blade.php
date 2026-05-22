@extends('layouts.app')

@section('title', 'Detail Rekam Medis - Paw Center')

@section('content')
<style>
    .card-dokter { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #E6E6FA; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .muted { color:#6b7280; font-size:12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    td { padding: 10px 8px; border-bottom: 1px solid #eee; vertical-align: top; }
    td.k { width: 160px; color:#6b7280; font-size:12px; text-transform: uppercase; }
    .v { font-weight: 600; }
    .actions { display:flex; gap: 12px; flex-wrap: wrap; margin-top: 16px; }
    .btn-primary { display:inline-block; padding:10px 16px; border-radius:10px; background:#800080; color:#fff; text-decoration:none; }
    .btn-secondary { display:inline-block; padding:10px 16px; border-radius:10px; background:#eee; color:#333; text-decoration:none; }
    .back { margin-bottom: 14px; }
</style>

<div class="container">
    <div class="back">
        <a class="btn-secondary" href="{{ route('dokter.rekam-medis.index') }}">← Kembali ke Rekam Medis</a>
    </div>

    <div class="card-dokter">
        <h2 style="color:#333;margin:0 0 6px;">🧾 Detail Rekam Medis</h2>
        <div class="muted">ID: {{ $rekamMedis->id }}</div>

        @php
            $tanggalPeriksaFormatted = null;
            if (!empty($rekamMedis->tanggal_periksa)) {
                try {
                    $tanggalPeriksaFormatted = \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d/m/Y H:i');
                } catch (\Throwable $e) {
                    $tanggalPeriksaFormatted = (string) $rekamMedis->tanggal_periksa;
                }
            }
        @endphp

        @php
            $jadwalPulangFormatted = null;
            if (!empty($rekamMedis->jadwal_pulang)) {
                try {
                    $jadwalPulangFormatted = \Carbon\Carbon::parse($rekamMedis->jadwal_pulang)->format('d/m/Y H:i');
                } catch (\Throwable $e) {
                    $jadwalPulangFormatted = (string) $rekamMedis->jadwal_pulang;
                }
            }
        @endphp

        <table>
            <tr>
                <td class="k">Tanggal Periksa</td>
                <td>{{ $tanggalPeriksaFormatted ?? (optional($rekamMedis->created_at)->format('d/m/Y H:i') ?? '-') }}</td>
            </tr>
            <tr>
                <td class="k">Hewan</td>
                <td><span class="v">{{ $rekamMedis->hewan->nama_hewan ?? 'N/A' }}</span> ({{ $rekamMedis->hewan->jenis_hewan ?? 'N/A' }} - {{ $rekamMedis->hewan->jenis_kelamin ?? 'N/A' }})</td>
            </tr>
            <tr>
                <td class="k">Pemilik</td>
                <td>{{ optional(optional($rekamMedis->hewan)->user)->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="k">Dokter</td>
                <td>{{ $rekamMedis->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="k">Diagnosa</td>
                <td>{{ $rekamMedis->diagnosa ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Tindakan</td>
                <td>{{ $rekamMedis->tindakan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Keluhan</td>
                <td>{{ $rekamMedis->keluhan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Detail</td>
                <td style="white-space: pre-line;">{{ $rekamMedis->detail ?? '-' }}</td>
            </tr>
            <tr>
                <td class="k">Resep Obat</td>
                <td style="white-space: pre-line;">{{ $rekamMedis->resep_obat ?? '-' }}</td>
            </tr>

            <!-- NEW: rawat inap -->
            <tr>
                <td class="k">Jadwal Pulang</td>
                <td>{{ $jadwalPulangFormatted ?? 'N/A' }}</td>
            </tr>

            <!-- NEW: catatan dokter -->
            <tr>
                <td class="k">Catatan Dokter</td>
                <td style="white-space: pre-line;">{{ $rekamMedis->catatan_dokter ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="actions">
            <a class="btn-secondary" href="{{ route('dokter.rekam-medis.index') }}">← Kembali</a>
            <a class="btn-primary" href="{{ route('dokter.rekam-medis.pdf', ['id' => $rekamMedis->id]) }}">⬇ Cetak PDF</a>
        </div>
    </div>
</div>
@endsection
