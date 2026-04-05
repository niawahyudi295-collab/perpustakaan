@extends('petugas.layouts')

@section('title', 'Tambah Peminjaman')
@section('header', 'TAMBAH PEMINJAMAN')

@section('content')

<div style="max-width:500px; background:white; padding:25px; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.peminjaman.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Anggota</label>
            <select name="anggota_id" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach($anggota as $a)
                <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Judul Buku</label>
            <select name="judul_buku" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($buku as $b)
                <option value="{{ $b->judul }}" {{ old('judul_buku') == $b->judul ? 'selected' : '' }}>{{ $b->judul }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam', date('Y-m-d')) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" value="{{ old('tgl_kembali') }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit"
                    style="flex:1; padding:10px; background:#b57ba6; color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                Simpan
            </button>
            <a href="{{ route('petugas.peminjaman') }}"
               style="flex:1; padding:10px; background:#eee; border-radius:8px; text-align:center; text-decoration:none; color:#333;">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
