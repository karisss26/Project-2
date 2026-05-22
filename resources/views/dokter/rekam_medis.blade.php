@extends('layouts.app')

@section('title', 'Rekam Medis Dokter - Paw Center')

@section('content')
<style>
    .card-dokter { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #E6E6FA; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .table-toolbar { display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; margin-bottom: 16px; }
    .field { display:flex; flex-direction:column; gap:6px; }
    .label-soft { color:#6b7280; font-size:12px; }
    input[type="text"], select {
        padding: 10px 12px; border: 1px solid #ddd; border-radius: 10px; min-width: 220px;
    }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { color: #888; font-size: 13px; text-transform: uppercase; }
    .btn-primary { display: inline-block; padding: 10px 16px; border-radius: 10px; background: #800080; color: white; text-decoration: none; border:none; cursor:pointer; }
    .btn-secondary { display: inline-block; padding: 10px 16px; border-radius: 10px; background: #eee; color: #333; text-decoration: none; border:none; cursor:pointer; }
    .no-data { text-align:center;color:#999; }
    @media (max-width: 768px) {
        input[type="text"], select { min-width: 100%; }
    }
</style>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
        <div>
            <h2 style="color: #333; margin-bottom: 8px;">🩷 Rekam Medis Dokter</h2>
            <p style="color: #555; margin: 0;">Lihat riwayat rekam medis. Gunakan pencarian & filter untuk mempercepat.</p>
        </div>

    </div>

    @if(session('success'))
        <div style="margin-bottom: 20px; padding: 16px; border-radius: 12px; background: #E6FFFA; border: 1px solid #81E6D9; color: #2C7A7B;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-dokter">
        <div class="table-toolbar">
            <div class="field">
                <div class="label-soft">Cari (nama hewan / dokter / diagnosa)</div>
                <input id="rm-search" type="text" placeholder="Ketik kata kunci..." value="{{ request('q') }}" />
            </div>

            <div class="field">
                <div class="label-soft">Dokter</div>
                <select id="rm-dokter" name="dokter">
                    <option value="all">Semua</option>
                    @php
                        $selectedDokterId = request('dokter');
                        $dokterList = $rekamMedis->pluck('user')->unique('id')->values()->all();
                    @endphp
                    @foreach($dokterList as $dokter)
                        @php
                            $dokterId = $dokter->id ?? null;
                            $name = $dokter->name ?? '';
                        @endphp
                        @if($dokterId)
                            <option value="{{ $dokterId }}" {{ (string)$selectedDokterId === (string)$dokterId ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="field">
                <div class="label-soft">Tahun</div>
                <select id="rm-tahun" name="tahun">
                    <option value="all">Semua</option>
                    @php
                        $years = $rekamMedis->map(fn($rm) => optional($rm->created_at)->format('Y'))->filter()->unique()->sort()->values();
                        $selectedYear = request('tahun');
                    @endphp
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ (string)$selectedYear === (string)$y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field" style="justify-content:flex-end;">
                <button id="rm-clear" class="btn-secondary" type="button">Reset</button>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hewan</th>
                    <th>Pemilik</th>
                    <th>Dokter</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Detail</th>
                    <th>Resep Obat</th>
                    <th>Jadwal Pulang</th>
                    <th>Catatan Dokter</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="rm-tbody">
                @forelse($rekamMedis as $rm)
                    @php
                        $dokterId = optional($rm->user)->id;
                        $tahun = optional($rm->created_at)->format('Y');
                        $hewanNama = $rm->hewan->nama_hewan ?? '';
                        $pemilikNama = optional(optional($rm->hewan)->user)->name ?? '';
                        $dokterNama = $rm->user->name ?? '';
                        $diagnosa = $rm->diagnosa ?? '';
                        $tindakan = $rm->tindakan ?? '';
                    @endphp
                    <tr class="rm-row"
                        data-q="{{ strtolower($hewanNama.' '.$dokterNama.' '.$diagnosa) }}"
                        data-dokter-id="{{ $dokterId }}"
                        data-tahun="{{ $tahun }}"
                    >
                        <td>{{ optional($rm->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $hewanNama ?: 'N/A' }}</td>
                        <td>{{ $pemilikNama ?: 'N/A' }}</td>
                        <td>{{ $dokterNama ?: 'N/A' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($diagnosa, 40) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($tindakan, 40) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($rm->detail ?? '', 40) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($rm->resep_obat ?? '', 40) }}</td>
                        <td>{{ $rm->jadwal_pulang ? (is_string($rm->jadwal_pulang) ? $rm->jadwal_pulang : \Illuminate\Support\Str::of($rm->jadwal_pulang)->toString()) : 'N/A' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($rm->catatan_dokter ?? '', 40) }}</td>
                        <td style="white-space:nowrap;">
                            <a class="btn-primary" style="padding:6px 10px;" href="{{ route('dokter.rekam-medis.detail', ['id' => $rm->id]) }}">Detail</a>
                            <a class="btn-secondary" style="padding:6px 10px; margin-left:8px;" href="{{ route('dokter.rekam-medis.pdf', ['id' => $rm->id]) }}">PDF</a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="11" class="no-data">Belum ada rekam medis yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
            (function(){
        const searchEl = document.getElementById('rm-search');
        const dokterEl = document.getElementById('rm-dokter');
        const tahunEl = document.getElementById('rm-tahun');
        const clearBtn = document.getElementById('rm-clear');
        const rows = Array.from(document.querySelectorAll('.rm-row'));

        function applyFilters(){
            const q = (searchEl?.value || '').trim().toLowerCase();
            const dokterId = dokterEl?.value || 'all';
            const tahun = tahunEl?.value || 'all';

            rows.forEach(row => {
                const rowQ = (row.dataset.q || '');
                const rowDokter = row.dataset.dokterId || '';
                const rowTahun = row.dataset.tahun || '';

                const matchQ = !q || rowQ.includes(q);
                const matchDokter = dokterId === 'all' || String(rowDokter) === String(dokterId);
                const matchTahun = tahun === 'all' || String(rowTahun) === String(tahun);

                row.style.display = (matchQ && matchDokter && matchTahun) ? '' : 'none';
            });
        }

        if (searchEl) searchEl.addEventListener('input', applyFilters);
        if (dokterEl) dokterEl.addEventListener('change', applyFilters);
        if (tahunEl) tahunEl.addEventListener('change', applyFilters);

        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (searchEl) searchEl.value = '';
                if (dokterEl) dokterEl.value = 'all';
                if (tahunEl) tahunEl.value = 'all';
                applyFilters();
            });
        }

        applyFilters();
    })();
</script>
@endsection
