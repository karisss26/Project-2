@extends('layouts.app')

@section('title', 'Kelola Layanan Klinik')

@section('content')
<style>
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .admin-header h2 { color: var(--purple-900); font-weight: 700; }
    .admin-card { background: var(--white); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05); border: 1px solid var(--purple-100); margin-bottom: 30px; }
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: var(--purple-50); color: var(--purple-900); padding: 12px 15px; text-align: left; font-size: 14px; }
    .admin-table td { padding: 15px; border-bottom: 1px solid var(--purple-50); font-size: 14px; color: var(--text-main); }
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; cursor: pointer; border: none; font-weight: 600; text-decoration: none; display: inline-block;}
    .btn-acc { background: var(--purple-600); color: white; }
    .btn-tolak { background: #dc3545; color: white; }

    /* Modal & Form Styling */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fff; margin: 5% auto; padding: 20px; border-radius: 12px; width: 50%; max-width: 500px; }
    .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: var(--purple-900); }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
</style>

<div class="content">
    <div class="admin-header">
        <h2>Kelola Layanan Klinik 🩺</h2>
        <button onclick="document.getElementById('modalTambah').style.display='block'" class="btn-acc" style="padding: 10px 20px; border-radius: 8px; border:none; cursor:pointer; font-weight:bold;">+ Tambah Layanan Baru</button>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Layanan</th>
                        <th>Harga Estimasi</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" width="60" style="border-radius: 8px; border: 1px solid var(--purple-100);">
                            @else
                                <span style="color: #ccc; font-style: italic;">Tidak ada foto</span>
                            @endif
                        </td>
                        <td><strong>{{ $item->nama_layanan }}</strong></td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td><small>{{ Str::limit($item->deskripsi, 50) }}</small></td>
                        <td style="display: flex; gap: 5px;">
                            <button onclick="bukaModalEdit({{ $item }})" class="btn-sm btn-acc">Edit</button>
                            <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini dari klinik?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-tolak">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada layanan klinik yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('modalTambah').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 20px; color: var(--purple-900);">Tambah Layanan Baru</h3>
        <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" class="form-control" placeholder="Contoh: Vaksinasi Kucing" required>
            </div>
            <div class="form-group">
                <label>Harga Estimasi (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Layanan</label>
                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Gambar Layanan (Opsional)</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <button type="submit" class="btn-acc" style="width: 100%; padding: 12px; border-radius: 8px; border:none; font-weight:bold; cursor:pointer;">Simpan Layanan</button>
        </form>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('modalEdit').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 20px; color: var(--purple-900);">Edit Layanan</h3>
        <form id="formEdit" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga Estimasi (Rp)</label>
                <input type="number" name="harga" id="edit_harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Layanan</label>
                <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Ganti Gambar (Opsional)</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <button type="submit" class="btn-acc" style="width: 100%; padding: 12px; border-radius: 8px; border:none; font-weight:bold; cursor:pointer;">Update Layanan</button>
        </form>
    </div>
</div>

<script>
    function bukaModalEdit(item) {
        document.getElementById('modalEdit').style.display = 'block';
        document.getElementById('edit_nama').value = item.nama_layanan;
        document.getElementById('edit_harga').value = item.harga;
        document.getElementById('edit_deskripsi').value = item.deskripsi;
        document.getElementById('formEdit').action = `/admin/layanan/update/${item.id}`;
    }
</script>
@endsection
