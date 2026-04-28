@extends('layouts.app')

@section('title', 'Kelola Katalog Produk')

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

    /* Modal & Form */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fff; margin: 5% auto; padding: 20px; border-radius: 12px; width: 50%; max-width: 500px; }
    .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: var(--purple-900); }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
</style>

<div class="content">
    <div class="admin-header">
        <h2>Kelola Katalog Produk 📦</h2>
        <button onclick="document.getElementById('modalTambah').style.display='block'" class="btn-acc" style="padding: 10px 20px; border-radius: 8px; border:none; cursor:pointer; font-weight:bold;">+ Tambah Produk Baru</button>
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
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" width="50" style="border-radius: 5px;">
                            @else
                                <span style="color: #ccc;">No Image</span>
                            @endif
                        </td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->stok }}</td>
                        <td style="display: flex; gap: 5px;">
                            <button onclick="bukaModalEdit({{ $item }})" class="btn-sm btn-acc">Edit</button>
                            <form action="{{ route('admin.katalog.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-tolak">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada produk di katalog.</td>
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
        <h3 style="margin-bottom: 20px;">Tambah Produk Baru</h3>
        <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group"><label>Nama Produk</label><input type="text" name="nama_produk" class="form-control" required></div>
            <div class="form-group"><label>Harga</label><input type="number" name="harga" class="form-control" required></div>
            <div class="form-group"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
            <div class="form-group"><label>Gambar Produk</label><input type="file" name="gambar" class="form-control"></div>
            <button type="submit" class="btn-acc" style="width: 100%; padding: 12px; border-radius: 8px; border:none; font-weight:bold;">Simpan Produk</button>
        </form>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('modalEdit').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 20px;">Edit Produk</h3>
        <form id="formEdit" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group"><label>Nama Produk</label><input type="text" name="nama_produk" id="edit_nama" class="form-control" required></div>
            <div class="form-group"><label>Harga</label><input type="number" name="harga" id="edit_harga" class="form-control" required></div>
            <div class="form-group"><label>Stok</label><input type="number" name="stok" id="edit_stok" class="form-control" required></div>
            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" id="edit_deskripsi" class="form-control"></textarea></div>
            <div class="form-group"><label>Gambar Baru (Opsional)</label><input type="file" name="gambar" class="form-control"></div>
            <button type="submit" class="btn-acc" style="width: 100%; padding: 12px; border-radius: 8px; border:none; font-weight:bold;">Update Produk</button>
        </form>
    </div>
</div>

<script>
    function bukaModalEdit(item) {
        document.getElementById('modalEdit').style.display = 'block';
        document.getElementById('edit_nama').value = item.nama_produk;
        document.getElementById('edit_harga').value = item.harga;
        document.getElementById('edit_stok').value = item.stok;
        document.getElementById('edit_deskripsi').value = item.deskripsi;
        document.getElementById('formEdit').action = `/admin/katalog/update/${item.id}`;
    }
</script>
@endsection
