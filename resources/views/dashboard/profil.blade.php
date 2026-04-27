@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <h2 style="color: #800080; margin-bottom: 20px; text-align: center;">👤 Profil Saya</h2>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 8px; border-left: 5px solid #28a745;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('pelanggan.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="text-align: center; margin-bottom: 25px;">
            <img id="preview-foto" src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=800080&color=fff' }}" alt="Foto Profil" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #E6E6FA; margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto;">

            <label style="font-size: 14px; font-weight: bold; color: white; background: #800080; padding: 8px 15px; border-radius: 20px; cursor: pointer; transition: 0.3s;">
                📷 Ganti Foto
                <input type="file" name="foto_profil" accept="image/jpeg, image/png, image/jpg" style="display: none;" onchange="previewImage(event)">
            </label>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #555;">Nama Lengkap</label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #555;">Username</label>
                <input type="text" name="username" value="{{ Auth::user()->username }}" placeholder="Contoh: mochi_lover" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #555;">No. Handphone</label>
                <input type="text" name="no_hp" value="{{ Auth::user()->no_hp }}" placeholder="Contoh: 081234567890" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #555;">Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #ffc107;">
            <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #555;">Ubah Password <small style="font-weight: normal; color: #888;">(Kosongkan jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" placeholder="Password Baru" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 10px;">
            <input type="password" name="password_confirmation" placeholder="Ketik Ulang Password Baru" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #800080; color: white; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(128, 0, 128, 0.2);">Simpan Perubahan Profil</button>
    </form>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview-foto');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
