@extends('layouts.app')

@section('title', 'Dashboard Dokter - Paw Center')

@section('content')
<style>
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .btn-profile { background: #f3e5f5; color: #800080; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; border: 1px solid #e1bee7; transition: all 0.3s; }
    .btn-profile:hover { background: #e1bee7; color: #4a004a; }
    .grid-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
    .card-dokter { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #E6E6FA; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .card-full { grid-column: span 2; }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .badge-dikonfirmasi { background: #E6F4EA; color: #1E8E3E; }
    .badge-diproses { background: #FEF7E0; color: #F9AB00; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { color: #888; font-size: 13px; text-transform: uppercase; }
    .btn-update { background: #800080; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 13px; }
    .btn-update:hover { background: #600060; }
    .doctor-schedule { display: flex; gap: 15px; margin-top: 15px; }
    .doc-box { background: #fafafa; border: 1px solid #eee; padding: 15px; border-radius: 8px; flex: 1; }
    .doc-name { color: #800080; font-weight: bold; font-size: 15px; margin-bottom: 5px; }
    .doc-time { color: #666; font-size: 13px; }
</style>

<div class="container">
    <div class="dashboard-header">
        <h2 style="color: #333; margin: 0;">Halo, drh. {{ Auth::user()->name }}! 🩺</h2>
        <a href="{{ route('profil.umum') }}" class="btn-profile">⚙️ Pengaturan Profil</a>
    </div>

    <div class="card-dokter card-full">
        <h3 style="font-size: 18px; color: #800080; border-bottom: 2px solid #F3E5F5; padding-bottom: 10px; margin-top:0;">👨‍⚕️ Jadwal Praktik Dokter</h3>
        <div class="doctor-schedule">
            @foreach($listDokter as $dokter)
            <div class="doc-box">
                <div class="doc-name">drh. {{ $dokter->name }}</div>
                <div class="doc-time">🕒 Shift Pagi: 09:00 - 15:00 WIB</div>
                <div class="doc-time">📍 Poli Umum & Spesialis</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid-container">

        <div class="card-dokter">
            <h3 style="font-size: 18px; color: #800080; border-bottom: 2px solid #F3E5F5; padding-bottom: 10px; margin-top:0;">📅 Antrean Klinik Hari Ini</h3>
            <table>
                <thead>
                    <tr>
                        <th>Pasien (Hewan)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalLayanan as $jadwal)
                    <tr>
                        <td>
                            <strong>{{ $jadwal->hewan->nama_hewan ?? 'N/A' }}</strong><br>
                            <span style="font-size: 12px; color: #666;">{{ $jadwal->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td>
                            <span class="status-badge badge-{{ strtolower($jadwal->status) }}">
                                {{ $jadwal->status }}
                            </span>
                        </td>
                        <td>
                        @if($jadwal->hewan)
                            <button class="btn-update" onclick="openModal('{{ $jadwal->hewan->id }}', '{{ $jadwal->hewan->nama_hewan }}')">
                                Update Medis
                            </button>
                        @else
                            <span style="color: #dc3545; font-size: 12px;">Data dihapus</span>
                        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #999;">Yeay, belum ada antrean saat ini! ☕</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-dokter">
            <h3 style="font-size: 18px; color: #333; border-bottom: 2px solid #F3E5F5; padding-bottom: 10px; margin-top:0;">📝 Riwayat Rekam Medis</h3>
            <table>
                <thead>
                    <tr>
                        <th>Hewan</th>
                        <th>Diagnosa</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis as $rm)
                    <tr>
                        <td><strong>{{ $rm->hewan->nama_hewan }}</strong></td>
                        <td>{{ \Illuminate\Support\Str::limit($rm->diagnosa, 20) }}</td>
                        <td style="font-size: 13px; color: #666;">{{ $rm->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="rmModal" style="display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; margin:5% auto; padding:25px; width:40%; border-radius:12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 id="modalTitle" style="color: #800080; margin-top:0;">Update Rekam Medis</h3>
        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

        <form action="{{ route('dokter.simpanRM') }}" method="POST">
            @csrf
            <input type="hidden" name="hewan_id" id="hewan_id">

            <div style="margin-bottom:15px;">
                <label style="font-weight: bold; font-size: 14px;">Keluhan Utama</label><br>
                <textarea name="keluhan" style="width:100%; border:1px solid #ccc; border-radius:8px; padding:10px; margin-top:5px;" rows="2" placeholder="Gejala yang dialami..." required></textarea>
            </div>
            <div style="margin-bottom:15px;">
                <label style="font-weight: bold; font-size: 14px;">Diagnosa</label><br>
                <input type="text" name="diagnosa" style="width:100%; border:1px solid #ccc; border-radius:8px; padding:10px; margin-top:5px;" placeholder="Hasil diagnosa..." required>
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-weight: bold; font-size: 14px;">Tindakan / Terapi</label><br>
                <textarea name="tindakan" style="width:100%; border:1px solid #ccc; border-radius:8px; padding:10px; margin-top:5px;" rows="3" placeholder="Obat / Treatment yang diberikan..." required></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-update" style="flex: 1; padding:12px; font-weight: bold;">Simpan Data</button>
                <button type="button" onclick="closeModal()" style="flex: 1; background:#f1f3f5; color:#333; border:none; padding:12px; border-radius:6px; cursor: pointer; font-weight: bold;">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id, nama) {
        document.getElementById('rmModal').style.display = 'block';
        document.getElementById('hewan_id').value = id;
        document.getElementById('modalTitle').innerText = 'Update Medis Pasien: ' + nama;
    }
    function closeModal() {
        document.getElementById('rmModal').style.display = 'none';
    }
</script>
@endsection
