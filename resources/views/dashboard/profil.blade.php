@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
    .info-group { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    .info-label { font-size: 14px; color: #888; margin-bottom: 5px; }
    .info-value { font-size: 18px; font-weight: bold; color: #333; }
    .btn-edit { background: #800080; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; margin-top: 20px; }

    /* Modal Style */
    .modal-custom { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; }
    .modal-content { background: white; padding: 25px; border-radius: 12px; width: 100%; max-width: 450px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
</style>

<div class="profile-card">
    <div style="text-align: center; margin-bottom: 25px;">
        <div style="width: 80px; height: 80px; background: #E6E6FA; color: #800080; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 10px;">👤</div>
        <h2 style="color: #800080;">Profil Pribadi</h2>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center;">✅ {{ session('success') }}</div>
    @endif

    <div class="info-group">
        <div class="info-label">Nama Lengkap</div>
        <div class="info-value">{{ Auth::user()->name }}</div>
    </div>

    <div class="info-group">
        <div class="info-label">Alamat Email</div>
        <div class="info-value">{{ Auth::user()->email }}</div>
    </div>

    <div class="info-group">
        <div class="info-label">Kata Sandi</div>
        <div class="info-value">••••••••</div>
    </div>

    <button class="btn-edit" onclick="openModal()">Edit Profil & Password</button>
</div>

<div id="modalEditProfil" class="modal-custom">
    <div class="modal-content">
        <h3 style="margin-bottom: 20px; color: #800080;">Perbarui Profil</h3>
        <form action="{{ route('pelanggan.profil.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required>
            </div>
            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            <p style="font-size: 12px; color: #888; margin-bottom: 10px;">Kosongkan password jika tidak ingin diubah.</p>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
            </div>
            <button type="submit" class="btn-edit">Simpan Perubahan</button>
            <button type="button" onclick="closeModal()" style="width: 100%; background: none; border: none; color: #999; margin-top: 10px; cursor: pointer;">Batal</button>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('modalEditProfil').style.display = 'flex'; }
    function closeModal() { document.getElementById('modalEditProfil').style.display = 'none'; }

    window.onclick = function(event) {
        if (event.target.id === 'modalEditProfil') closeModal();
    }
</script>
@endsection
