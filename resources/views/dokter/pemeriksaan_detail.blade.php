@extends('layouts.app')

@section('title', 'Detail Pemeriksaan - Paw Center')

@section('content')
<style>
    .card-dokter { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #E6E6FA; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .label { color:#666; font-size:13px; margin-top:10px; }
    .value { color:#222; font-size:15px; font-weight:600; }
    .btn { display: inline-block; padding: 10px 14px; border-radius: 8px; border: none; cursor: pointer; font-size: 13px; text-decoration: none; }
    .btn-primary { background: #800080; color:#fff; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
    textarea.form-control { resize: vertical; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
</style>

<div class="container">
    <h2 style="color:#333;margin-bottom:20px;">🧾 Detail Pemeriksaan</h2>

    <div class="card-dokter" style="margin-bottom:25px;">
        <div class="grid">
            <div>
                <div class="label">Waktu Reservasi</div>
                <div class="value">{{ optional($pemeriksaan->created_at)->format('d/m/Y H:i') }}</div>
            </div>
            <div>
                <div class="label">Status</div>
                <div class="value">{{ $pemeriksaan->status }}</div>
            </div>
            <div>
                <div class="label">Nama Hewan</div>
                <div class="value">{{ $pemeriksaan->hewan->nama_hewan ?? $pemeriksaan->pet_name ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="label">Jenis Hewan</div>
                <div class="value">{{ $pemeriksaan->hewan->jenis_hewan ?? 'N/A' }} ({{ $pemeriksaan->hewan->jenis_kelamin ?? '-' }})</div>
            </div>
            <div>
                <div class="label">Pemilik</div>
                <div class="value">{{ $pemeriksaan->user->name ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="label">Dokter</div>
                <div class="value">{{ optional($pemeriksaan->dokter)->name ?? Auth::user()->name }}</div>
            </div>
        </div>
    </div>



    <div class="card-dokter">
        <h3 style="color:#800080;margin-bottom:10px;">✍️ Catat Rekam Medis</h3>

        @php
            // Auto-detect tindakan dari nama layanan reservasi
            $namaLayanan = strtolower($pemeriksaan->nama_layanan ?? '');
            if (str_contains($namaLayanan, 'vaksin')) {
                $autoTindakan = 'Vaksinasi';
            } elseif (str_contains($namaLayanan, 'steril')) {
                $autoTindakan = 'Sterilisasi';
            } elseif (str_contains($namaLayanan, 'rawat inap') || str_contains($namaLayanan, 'rawat-inap')) {
                $autoTindakan = 'Rawat Inap';
            } else {
                $autoTindakan = '';
            }
            // Prioritaskan old() jika ada (validasi gagal), fallback ke auto-detect
            $activeTindakan = old('tindakan', $autoTindakan);
        @endphp

        <form action="{{ route('dokter.simpanRM') }}" method="POST">
            @csrf
            <input type="hidden" name="hewan_id" value="{{ $pemeriksaan->hewan_id }}">
            <input type="hidden" name="reservasi_id" value="{{ $pemeriksaan->id }}">

            @if($errors->any())
                <div style="margin-bottom:15px; padding: 12px; background: #FFEBEE; border: 1px solid #F44336; color: #C62828; border-radius: 10px;">
                    <strong>Gagal menyimpan:</strong>
                    <ul style="margin: 8px 0 0 18px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div style="margin-bottom:15px; padding: 12px; background: #E6FFFA; border: 1px solid #81E6D9; color: #2C7A7B; border-radius: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Field rekam medis harus sesuai dengan yang dipakai di menu jadwal pemeriksaan --}}
            <div style="margin-bottom:15px;">
                <label class="label">Berat Badan (kg)</label>
                <input type="number" name="bb_kg" class="form-control" step="0.01" min="0" value="{{ old('bb_kg') }}" required>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Suhu Tubuh (°C)</label>
                <input type="number" name="suhu_tubuh_c" class="form-control" step="0.1" value="{{ old('suhu_tubuh_c') }}" required>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Detak Jantung (bpm)</label>
                <input type="number" name="detak_jantung_bpm" class="form-control" step="1" min="0" value="{{ old('detak_jantung_bpm') }}" required>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Nafsu Makan</label>
                <select name="nafsu_makan" id="sel_nafsu_makan" data-kategori="nafsu_makan" class="form-control" required>
                    <option value="">Memuat opsi...</option>
                </select>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Kondisi Tubuh</label>
                <select name="kondisi_tubuh" id="sel_kondisi_tubuh" data-kategori="kondisi_tubuh" class="form-control" required>
                    <option value="">Memuat opsi...</option>
                </select>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Kondisi Mata</label>
                <select name="kondisi_mata" id="sel_kondisi_mata" data-kategori="kondisi_mata" class="form-control" required>
                    <option value="">Memuat opsi...</option>
                </select>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Kondisi Kulit/Bulu</label>
                <select name="kondisi_kulit_bulu" id="sel_kondisi_kulit_bulu" data-kategori="kondisi_kulit_bulu" class="form-control" required>
                    <option value="">Memuat opsi...</option>
                </select>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Pernapasan</label>
                <select name="pernapasan" id="sel_pernapasan" data-kategori="pernapasan" class="form-control" required>
                    <option value="">Memuat opsi...</option>
                </select>
            </div>

            <input type="hidden" name="kondisi_fisik_hewan" id="kondisi_fisik_hewan" value="{{ old('kondisi_fisik_hewan') }}">
            <script>
                (function () {
                    const el = (id) => document.getElementById(id);
                    const inputs = {
                        bb_kg: el('bb_kg'),
                    };
                })();
            </script>

            <div style="margin-bottom:15px;">
                <label class="label">Keluhan Utama</label>
                <textarea name="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Diagnosa</label>
                <input type="text" name="diagnosa" class="form-control" value="{{ old('diagnosa') }}" required>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Tindakan / Terapi</label>
                <select name="tindakan" id="tindakan" class="form-control searchable" required>
                    <option value="" disabled {{ $activeTindakan ? '' : 'selected' }}>Pilih atau ketik...</option>
                    <option value="Vaksinasi"    {{ $activeTindakan === 'Vaksinasi'    ? 'selected' : '' }}>Vaksinasi</option>
                    <option value="Sterilisasi"  {{ $activeTindakan === 'Sterilisasi'  ? 'selected' : '' }}>Sterilisasi</option>
                    <option value="Operasi Besar" {{ $activeTindakan === 'Operasi Besar' ? 'selected' : '' }}>Operasi Besar</option>
                    <option value="Operasi Kecil" {{ $activeTindakan === 'Operasi Kecil' ? 'selected' : '' }}>Operasi Kecil</option>
                    <option value="Rawat Inap"   {{ $activeTindakan === 'Rawat Inap'   ? 'selected' : '' }}>Rawat Inap</option>
                    <option value="Lainnya"      {{ $activeTindakan === 'Lainnya'      ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Bagian Form Vaksinasi (Hidden by default, auto-show jika tindakan = Vaksinasi) -->
            <div id="form-vaksinasi" style="display: {{ $activeTindakan === 'Vaksinasi' ? 'block' : 'none' }}; padding: 15px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; background-color: #fcfcfc;">
                <h4 style="margin-top: 0; color: #800080;">Detail Vaksinasi</h4>
                <div style="margin-bottom:15px;">
                    <label class="label">Jenis Vaksin</label>
                    <select name="jenis_vaksin" id="jenis_vaksin" data-kategori="jenis_vaksin" class="form-control">
                        <option value="">Memuat opsi...</option>
                    </select>
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Tanggal Vaksin</label>
                    <input type="date" name="tanggal_vaksin" class="form-control" value="{{ old('tanggal_vaksin') }}">
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Dosis (ml)</label>
                    <input type="number" step="0.1" name="dosis_vaksin" class="form-control" value="{{ old('dosis_vaksin') }}">
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Kondisi Hewan Saat Vaksin</label>
                    <select name="kondisi_vaksin" id="kondisi_vaksin" data-kategori="kondisi_vaksin" class="form-control">
                        <option value="">Memuat opsi...</option>
                    </select>
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Catatan Vaksin</label>
                    <textarea name="catatan_vaksin" class="form-control" rows="2">{{ old('catatan_vaksin') }}</textarea>
                </div>
            </div>

            <!-- Bagian Form Sterilisasi (Hidden by default, auto-show jika tindakan = Sterilisasi) -->
            <div id="form-sterilisasi" style="display: {{ $activeTindakan === 'Sterilisasi' ? 'block' : 'none' }}; padding: 15px; border: 1px solid #f0c4f0; border-radius: 8px; margin-bottom: 15px; background-color: #fdf5ff;">
                <h4 style="margin-top: 0; color: #800080;">🔪 Detail Sterilisasi</h4>
                <div style="margin-bottom:15px;">
                    <label class="label">Jenis Sterilisasi</label>
                    <div style="display: flex; gap: 24px; margin-top: 8px; flex-wrap: wrap;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; font-weight: 600; color: #444;">
                            <input type="radio" name="jenis_sterilisasi" value="Sterilisasi Jantan"
                                {{ old('jenis_sterilisasi') === 'Sterilisasi Jantan' ? 'checked' : '' }}
                                style="accent-color: #800080; width: 16px; height: 16px;">
                            ♂ Sterilisasi Jantan (Kastrasi)
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; font-weight: 600; color: #444;">
                            <input type="radio" name="jenis_sterilisasi" value="Sterilisasi Betina"
                                {{ old('jenis_sterilisasi') === 'Sterilisasi Betina' ? 'checked' : '' }}
                                style="accent-color: #800080; width: 16px; height: 16px;">
                            ♀ Sterilisasi Betina (Ovariohisterektomi)
                        </label>
                    </div>
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Kondisi Pasca Operasi</label>
                    <select name="kondisi_pasca_operasi" id="kondisi_pasca_operasi" data-kategori="kondisi_pasca_operasi" class="form-control">
                        <option value="">Memuat opsi...</option>
                    </select>
                </div>
            </div>

            <!-- Bagian Form Rawat Inap (Hidden by default, auto-show jika tindakan = Rawat Inap) -->
            <div id="form-rawat-inap" style="display: {{ $activeTindakan === 'Rawat Inap' ? 'block' : 'none' }}; padding: 15px; border: 1px solid #b3d9ff; border-radius: 8px; margin-bottom: 15px; background-color: #f0f8ff;">
                <h4 style="margin-top: 0; color: #1a6fbf;">🏥 Detail Rawat Inap</h4>
                <div style="margin-bottom:15px;">
                    <label class="label">Kandang / Ruangan</label>
                    <select name="kandang_ruangan" id="kandang_ruangan" data-kategori="kandang_ruangan" class="form-control">
                        <option value="">Memuat opsi...</option>
                    </select>
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Status Rawat Inap</label>
                    <select name="status_rawat_inap" id="status_rawat_inap" data-kategori="status_rawat_inap" class="form-control">
                        <option value="">Memuat opsi...</option>
                    </select>
                </div>
                <div style="margin-bottom:15px;">
                    <label class="label">Tanggal Keluar</label>
                    <small style="color:#888; display:block; margin-bottom:6px;">Diisi ketika pasien sudah diperbolehkan pulang.</small>
                    <input type="date" name="jadwal_pulang" id="jadwal_pulang_ri" class="form-control"
                        value="{{ old('jadwal_pulang') }}">
                </div>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Detail Tindakan</label>
                <textarea name="detail" class="form-control" rows="4" required>{{ old('detail') }}</textarea>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Jenis Obat</label>
                <select name="jenis_obat" id="sel_jenis_obat" data-kategori="jenis_obat" class="form-control" required>
                    <option value="">Memuat opsi...</option>
                </select>
            </div>

            <div style="margin-bottom:15px;">
                <label class="label">Dosis Obat</label>
                <input type="text" name="dosis_obat" class="form-control" value="{{ old('dosis_obat') }}" required placeholder="Contoh: 2x sehari 1 tablet">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; display:block; text-align:center; line-height: 40px; color:#fff;">
                simpan rekam medis
            </button>

        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    .ts-control {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        min-height: 40px;
        box-shadow: none;
    }
    .ts-wrapper.single .ts-control {
        background: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    // ── Nilai dari PHP untuk auto-detect tindakan & pre-select old() ──
    const autoTindakan = '{{ $autoTindakan }}';
    const API_URL      = '{{ route("dokter.opsi-rm.api") }}';

    // Nilai old() per field (untuk pre-select saat validasi gagal)
    const OLD = {
        nafsu_makan:           '{{ old("nafsu_makan") }}',
        kondisi_tubuh:         '{{ old("kondisi_tubuh") }}',
        kondisi_mata:          '{{ old("kondisi_mata") }}',
        kondisi_kulit_bulu:    '{{ old("kondisi_kulit_bulu") }}',
        pernapasan:            '{{ old("pernapasan") }}',
        jenis_vaksin:          '{{ old("jenis_vaksin") }}',
        kondisi_vaksin:        '{{ old("kondisi_vaksin") }}',
        kondisi_pasca_operasi: '{{ old("kondisi_pasca_operasi") }}',
        kandang_ruangan:       '{{ old("kandang_ruangan") }}',
        status_rawat_inap:     '{{ old("status_rawat_inap") }}',
        jenis_obat:            '{{ old("jenis_obat") }}',
    };

    // ── Sinkronisasi tampilan section sub-form ──
    function syncSections(value) {
        document.getElementById('form-vaksinasi').style.display   = (value === 'Vaksinasi')   ? 'block' : 'none';
        document.getElementById('form-sterilisasi').style.display = (value === 'Sterilisasi') ? 'block' : 'none';
        document.getElementById('form-rawat-inap').style.display  = (value === 'Rawat Inap')  ? 'block' : 'none';
        if (value !== 'Sterilisasi') {
            document.querySelectorAll('input[name="jenis_sterilisasi"]').forEach(r => r.checked = false);
        }
    }

    // ── Populate select + init TomSelect ──
    function populateSelect(el, options, oldVal) {
        // Hapus semua opsi lama
        el.innerHTML = '';

        // Placeholder
        const placeholder = new Option('Pilih atau ketik...', '', true, false);
        placeholder.disabled = true;
        if (!oldVal) placeholder.selected = true;
        el.appendChild(placeholder);

        // Tambahkan opsi dari API
        options.forEach(function(val) {
            const opt = new Option(val, val, false, val === oldVal);
            el.appendChild(opt);
        });

        // Inisialisasi TomSelect
        return new TomSelect(el, {
            create: false,
            sortField: { field: 'text', direction: 'asc' },
            placeholder: 'Pilih atau ketik...',
        });
    }

    document.addEventListener('DOMContentLoaded', function () {

        // ── 1. Init dropdown TINDAKAN (statis, tidak dari API) ──
        let tindakanTs = null;
        const tindakanEl = document.getElementById('tindakan');
        if (tindakanEl) {
            tindakanTs = new TomSelect(tindakanEl, {
                create: false,
                sortField: { field: 'text', direction: 'asc' }
            });
            tindakanTs.on('change', function (value) {
                syncSections(value);
            });
            const curVal = tindakanTs.getValue();
            if (!curVal && autoTindakan) {
                tindakanTs.setValue(autoTindakan);
                syncSections(autoTindakan);
            } else if (curVal) {
                syncSections(curVal);
            }
        }

        // ── 2. Fetch semua opsi dari API → populate semua select[data-kategori] ──
        fetch(API_URL, {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        })
        .then(function (res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function (json) {
            if (!json.success) throw new Error('API error');

            document.querySelectorAll('select[data-kategori]').forEach(function (el) {
                const kat     = el.getAttribute('data-kategori');
                const options = json.data[kat] || [];
                const oldVal  = OLD[kat] || '';
                populateSelect(el, options, oldVal);
            });
        })
        .catch(function (err) {
            console.warn('[OpsiRM] Gagal memuat opsi dari API:', err);
            // Fallback: init TomSelect dengan opsi kosong agar form tetap bisa jalan
            document.querySelectorAll('select[data-kategori]').forEach(function (el) {
                el.innerHTML = '<option value="" disabled selected>Gagal memuat — ketik manual</option>';
                new TomSelect(el, { create: true });
            });
        });
    });
</script>
@endpush

