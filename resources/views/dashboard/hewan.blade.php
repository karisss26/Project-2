@extends('layouts.app')

@section('title', 'Data Hewan Peliharaan')

@section('content')
<style>
    .modal-custom { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 450px; }
    .form-group { margin-bottom: 12px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; font-size: 14px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
    .btn-save { width: 100%; padding: 12px; background: #800080; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; margin-top: 10px; }
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="color: #800080;">🐾 Data Hewan Peliharaan</h2>
    <button onclick="openModal('modalTambah')" style="background: #800080; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">+ Tambah Anabul</button>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 8px; border-left: 5px solid #28a745;">
        ✅ {{ session('success') }}
    </div>
@endif

<div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
        <thead>
            <tr style="border-bottom: 2px solid #E6E6FA; text-align: left; color: #555;">
                <th style="padding: 12px;">No</th>
                <th style="padding: 12px;">Nama Anabul</th>
                <th style="padding: 12px;">Jenis</th>
                <th style="padding: 12px;">Ras</th>
                <th style="padding: 12px;">Umur</th>
                <th style="padding: 12px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($semua_hewan as $key => $h)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">{{ $key + 1 }}</td>
                <td style="padding: 12px; font-weight: bold; color: #800080;">{{ $h->nama_hewan }}</td>
                <td style="padding: 12px;">{{ $h->jenis_hewan }}</td>
                <td style="padding: 12px; color: #666;">{{ $h->ras ?? '-' }}</td>
                <td style="padding: 12px; color: #666;">{{ $h->umur ?? '-' }}</td>
                <td style="padding: 12px; text-align: center; display: flex; justify-content: center; gap: 8px;">
                    <button onclick="openEditModal('{{ $h->id }}', '{{ $h->nama_hewan }}', '{{ $h->jenis_hewan }}', '{{ $h->ras }}', '{{ $h->umur }}')" style="background: #ffc107; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">✏️</button>

                    <form action="{{ route('hewan.hapus', $h->id) }}" method="POST" onsubmit="return confirm('Hapus data {{ $h->nama_hewan }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer;">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center; padding: 30px; color: #888;">Belum ada data hewan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalTambah" class="modal-custom">
    <div class="modal-content">
        <h3 style="margin-bottom: 15px; color: #800080;">Tambah Anabul Baru</h3>
        <form action="{{ route('hewan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Anabul</label>
                <input type="text" name="nama_hewan" required placeholder="Contoh: Mochi">
            </div>
            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                    <label>Jenis</label>
                    <select name="jenis_hewan" required>
                        <option value="Kucing">Kucing</option>
                        <option value="Anjing">Anjing</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Umur</label>
                    <input type="text" name="umur" required placeholder="Contoh: 2 Tahun">
                </div>
            </div>
            <div class="form-group">
                <label>Ras / Keturunan</label>
                <input type="text" name="ras" required placeholder="Contoh: Persia, Golden Retriever">
            </div>
            <button type="submit" class="btn-save">Simpan Anabul</button>
            <button type="button" onclick="closeModal('modalTambah')" style="width: 100%; background: none; border: none; color: #999; margin-top: 10px; cursor: pointer;">Batal</button>
        </form>
    </div>
</div>

<div id="modalEdit" class="modal-custom">
    <div class="modal-content">
        <h3 style="margin-bottom: 15px; color: #ffc107;">Edit Data Anabul</h3>
        <form id="formEdit" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Anabul</label>
                <input type="text" name="nama_hewan" id="edit_nama" required>
            </div>
            <div style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                    <label>Jenis</label>
                    <select name="jenis_hewan" id="edit_jenis" required>
                        <option value="Kucing">Kucing</option>
                        <option value="Anjing">Anjing</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Umur</label>
                    <input type="text" name="umur" id="edit_umur" required>
                </div>
            </div>
            <div class="form-group">
                <label>Ras / Keturunan</label>
                <input type="text" name="ras" id="edit_ras" required>
            </div>
            <button type="submit" class="btn-save" style="background: #ffc107;">Update Data</button>
            <button type="button" onclick="closeModal('modalEdit')" style="width: 100%; background: none; border: none; color: #999; margin-top: 10px; cursor: pointer;">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    function openEditModal(id, nama, jenis, ras, umur) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('edit_ras').value = ras;
        document.getElementById('edit_umur').value = umur;
        document.getElementById('formEdit').action = "/data-hewan/update/" + id;
        openModal('modalEdit');
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal-custom') {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
