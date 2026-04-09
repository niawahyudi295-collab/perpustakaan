@extends('petugas.layouts')

@section('title', 'Profil Saya')
@section('header', 'PROFIL SAYA')

@section('content')

<div style="max-width:500px;">

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div style="background:white; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1); padding:25px;">
        <form action="{{ route('petugas.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Foto --}}
            <div style="display:flex; flex-direction:column; align-items:center; margin-bottom:20px;">
                <div style="position:relative;">
                    @if($user->foto)
                        <img id="fotoPreview" src="{{ asset('images/' . $user->foto) }}"
                             style="width:96px; height:96px; border-radius:50%; object-fit:cover; border:4px solid #b57ba6;">
                    @else
                        <div id="fotoPlaceholder" style="width:96px; height:96px; border-radius:50%; background:#b57ba6; border:4px solid #b57ba6; display:flex; align-items:center; justify-content:center; color:white; font-size:2rem; font-weight:bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <img id="fotoPreview" src="" style="width:96px; height:96px; border-radius:50%; object-fit:cover; border:4px solid #b57ba6; display:none;">
                    @endif
                    <label for="fotoInput" style="position:absolute; bottom:0; right:0; width:28px; height:28px; border-radius:50%; background:#b57ba6; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:12px;">📷</label>
                </div>
                <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;" onchange="previewFoto(this)">
                <p style="font-size:12px; color:#999; margin-top:8px;">Klik ikon kamera untuk ganti foto</p>
            </div>

            <div style="margin-bottom:15px;">
                <label style="display:block; font-weight:bold; font-size:13px; margin-bottom:5px;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       style="width:100%; padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:13px;" required>
            </div>

            <div style="margin-bottom:15px;">
                <label style="display:block; font-weight:bold; font-size:13px; margin-bottom:5px;">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       style="width:100%; padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:13px;" required>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:bold; font-size:13px; margin-bottom:5px;">No. Telepon</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                       style="width:100%; padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:13px;">
            </div>

            <hr style="margin:15px 0;">
            <p style="font-size:12px; color:#999; margin-bottom:12px;">Kosongkan jika tidak ingin mengubah password.</p>

            <div style="margin-bottom:15px;">
                <label style="display:block; font-weight:bold; font-size:13px; margin-bottom:5px;">Password Baru</label>
                <input type="password" name="password"
                       style="width:100%; padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:13px;"
                       placeholder="Masukkan password baru">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:bold; font-size:13px; margin-bottom:5px;">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       style="width:100%; padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:13px;"
                       placeholder="Ulangi password baru">
            </div>

            <button type="submit"
                    style="width:100%; padding:10px; background:#b57ba6; color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview     = document.getElementById('fotoPreview');
            const placeholder = document.getElementById('fotoPlaceholder');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
