@extends('petugas.layouts')

@section('title', 'Dashboard')
@section('header', 'DASHBOARD')

@section('content')

<div style="text-align:center; font-size:22px; margin-bottom:40px; color:#333;">
    Hallo, Petugas Perpustakaan Digital
</div>

<div style="display:flex; justify-content:space-around; flex-wrap:wrap; gap:20px;">

    <a href="{{ route('petugas.peminjaman') }}" style="text-decoration:none; color:inherit;">
        <div style="width:300px; background:#e7c6d3; padding:25px; border-radius:10px; cursor:pointer;">
            <h3 style="margin-bottom:10px; font-size:16px;">Peminjaman Saat Ini</h3>
            <p style="font-size:32px; font-weight:bold;">{{ $peminjaman }}</p>
        </div>
    </a>

    <a href="{{ route('petugas.peminjaman') }}" style="text-decoration:none; color:inherit;">
        <div style="width:300px; background:#e7c6d3; padding:25px; border-radius:10px; cursor:pointer;">
            <h3 style="margin-bottom:10px; font-size:16px;">Keterlambatan</h3>
            <p style="font-size:32px; font-weight:bold;">{{ $terlambat }}</p>
        </div>
    </a>

</div>

@endsection
