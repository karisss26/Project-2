@extends('layouts.app')

@section('title', 'Kelola Akun Pengguna')

@section('content')
<style>
    .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .admin-header h2 { color: var(--purple-900); font-weight: 700; }
    .admin-card { background: var(--white); padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(124, 58, 237, 0.05); border: 1px solid var(--purple-100); margin-bottom: 30px; }
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { background: var(--purple-50); color: var(--purple-900); padding: 12px 15px; text-align: left; font-size: 14px; }
    .admin-table td { padding: 15px; border-bottom: 1px solid var(--purple-50); font-size: 14px; color: var(--text-main); }
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-aktif { background: #d4edda; color: #155724; }
    .badge-blokir { background: #f8d7da; color: #721c24; }
    .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; cursor: pointer; border: none; font-weight: 600; text-decoration: none; display: inline-block;}
    .btn-acc { background: var(--purple-600); color: white; }
    .btn-tolak { background: #dc3545; color: white; }
    .btn-warning { background: #ffc107; color: #212529; }

    /* Modal Styling Sederhana */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fff; margin: 10% auto; padding: 20px; border-radius: 12px; width: 50%; max-width: 500px; }
    .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: var(--purple-900); font-size: 14px; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
</style>

<div class="content">
    <div class="admin-header">
        <h2>Kelola Akun Pengguna 👥</h2>
        <button onclick="document.getElementById('modalTambah').style.display='block'" class="btn-acc" style="padding: 10px 20px; border-radius: 8px; border:none; cursor:pointer; font-weight:bold;">+ Tambah Akun Baru</button>
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
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span style="text-transform: uppercase; font-size: 12px; font-weight:bold; color: var(--purple-600);">{{ $user->role }}</span></td>
                        <td>
                            <span class="badge {{ $user->status == 'aktif' ? 'badge-aktif' : 'badge-blokir' }}">
                                {{ ucfirst($user->status ?? 'aktif') }}
                            </span>
                        </td>
                        <td style="display: flex; gap: 5px;">
                            @if($user->status == 'blokir')
                                <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-sm btn-warning">Pulihkan</button>
                                </form>
                            @endif

                            <button onclick="bukaModalEdit({{ $user }})" class="btn-sm btn-acc">Edit</button>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-tolak">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('modalTambah').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 20px; color: var(--purple-900);">Tambah Akun Baru</h3>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Role / Peran</label>
                <select name="role" class="form-control" required>
                    <option value="pelanggan">Pelanggan</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="dokter">Dokter</option>
                    <option value="staff">Staff</option>
                    <option value="owner">Owner</option>
                </select>
            </div>
            <button type="submit" class="btn-acc" style="width: 100%; padding: 12px; border-radius: 8px; border:none; cursor:pointer; font-weight:bold; margin-top: 10px;">Simpan Akun</button>
        </form>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('modalEdit').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 20px; color: var(--purple-900);">Edit Data Akun</h3>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password Baru (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Role / Peran</label>
                <select name="role" id="edit_role" class="form-control" required>
                    <option value="pelanggan">Pelanggan</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="dokter">Dokter</option>
                    <option value="staff">Staff</option>
                    <option value="owner">Owner</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status Akun</label>
                <select name="status" id="edit_status" class="form-control" required>
                    <option value="aktif">Aktif</option>
                    <option value="blokir">Blokir</option>
                </select>
            </div>
            <button type="submit" class="btn-acc" style="width: 100%; padding: 12px; border-radius: 8px; border:none; cursor:pointer; font-weight:bold; margin-top: 10px;">Update Data</button>
        </form>
    </div>
</div>

<script>
    // Script buat ngisi data ke dalam Modal Edit
    function bukaModalEdit(user) {
        document.getElementById('modalEdit').style.display = 'block';
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_status').value = user.status || 'aktif';

        // Ubah action form ke route update yang benar
        let form = document.getElementById('formEdit');
        form.action = `/admin/users/update/${user.id}`;
    }
</script>
@endsection
