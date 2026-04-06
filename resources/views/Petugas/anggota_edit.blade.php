@extends('petugas.layouts')

@section('title', 'Edit Anggota')
@section('header', 'EDIT ANGGOTA')

@section('content')

<div style="max-width:500px; background:white; padding:25px; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.anggota.update', $user) }}" method="POST">
        @csrf @method('PUT')

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">No. Telepon</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Alamat</label>
            <textarea name="alamat" rows="3"
                      style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;">{{ old('alamat', $user->alamat) }}</textarea>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit"
                    style="flex:1; padding:10px; background:#b57ba6; color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                Simpan
            </button>
            <a href="{{ route('petugas.anggota') }}"
               style="flex:1; padding:10px; background:#eee; border-radius:8px; text-align:center; text-decoration:none; color:#333;">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
