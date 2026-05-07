@extends('layouts.app')

@section('title', 'Dashboard Dokter - Paw Center')

@section('content')
<style>
    .card-dokter { background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #E6E6FA; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .badge-dikonfirmasi { background: #E6F4EA; color: #1E8E3E; }
    .badge-diproses { background: #FEF7E0; color: #F9AB00; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { color: #888; font-size: 13px; text-transform: uppercase; }
    .btn-update { background: #800080; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 13px; }
</style>

<div class="container">
    <h2 style="color: #333; margin-bottom: 20px;">Halo, drh. {{ Auth::user()->name }}! 🩺</h2>

    <div class="card-dokter">
        <h3 style="font-size: 18px; color: #800080; border-bottom: 2px solid #F3E5F5; padding-bottom: 10px;">📅 Jadwal Layanan & Antrean</h3>
        <table>
            <thead>
                <tr>
                    <th>Waktu Reservasi</th>
                    <th>Nama Hewan</th>
                    <th>Pemilik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalLayanan as $jadwal)
                <tr>
                    <td>{{ $jadwal->created_at->format('H:i') }} WIB</td>
                    <td><strong>{{ $jadwal->hewan->nama_hewan ?? 'N/A' }}</strong></td>
                    <td>{{ $jadwal->user->name ?? 'N/A' }}</td>
                    <td>
                        <span class="status-badge badge-{{ strtolower($jadwal->status) }}">
                            {{ $jadwal->status }}
                        </span>
                    </td>
                    <td>
                    @if($jadwal->hewan)
                        <button class="btn-update" onclick="openModal('{{ $jadwal->hewan->id }}', '{{ $jadwal->hewan->nama_hewan }}')">
                            Update Rekam Medis
                        </button>
                    @else
                        <span style="color: #dc3545; font-size: 12px; font-weight: bold;">
                            ⚠️ Data hewan tidak ditemukan/dihapus
                        </span>
                    @endif
                                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Tidak ada jadwal layanan untuk saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-dokter">
        <h3 style="font-size: 18px; color: #333;">📝 Rekam Medis Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hewan</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekamMedis as $rm)
                <tr>
                    <td>{{ $rm->created_at->format('d/m/Y') }}</td>
                    <td>{{ $rm->hewan->nama_hewan }}</td>
                    <td>{{ $rm->diagnosa }}</td>
                    <td>{{ $rm->tindakan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="rmModal" style="display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; margin:10% auto; padding:20px; width:50%; border-radius:12px;">
        <h3 id="modalTitle">Update Rekam Medis</h3>
        <form action="{{ route('dokter.simpanRM') }}" method="POST">
            @csrf
            <input type="hidden" name="hewan_id" id="hewan_id">
            <div style="margin-bottom:15px;">
                <label>Keluhan Utama</label><br>
                <textarea name="keluhan" style="width:100%; border:1px solid #ddd; border-radius:8px;" rows="2" required></textarea>
            </div>
            <div style="margin-bottom:15px;">
                <label>Diagnosa</label><br>
                <input type="text" name="diagnosa" style="width:100%; border:1px solid #ddd; border-radius:8px; padding:8px;" required>
            </div>
            <div style="margin-bottom:15px;">
                <label>Tindakan / Terapi</label><br>
                <textarea name="tindakan" style="width:100%; border:1px solid #ddd; border-radius:8px;" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn-update" style="width:100%; padding:12px;">Simpan Data Medis</button>
            <button type="button" onclick="closeModal()" style="width:100%; margin-top:10px; background:#eee; border:none; padding:8px; border-radius:8px;">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(id, nama) {
        document.getElementById('rmModal').style.display = 'block';
        document.getElementById('hewan_id').value = id;
        document.getElementById('modalTitle').innerText = 'Update Rekam Medis: ' + nama;
    }
    function closeModal() {
        document.getElementById('rmModal').style.display = 'none';
    }
</script>
@endsection
