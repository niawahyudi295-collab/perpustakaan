@extends('Petugas.layouts')

@section('title', 'Dashboard')

@section('header', 'DASHBOARD')

@section('content')

<div style="text-align:center; font-size:25px; margin-bottom:40px;">
    Hallo, Petugas Perpustakaan Digital
</div>

<div style="display:flex; justify-content:space-around;">

    <div style="width:300px; background:#e7c6d3; padding:20px; border-radius:10px;">
        <h3>Peminjaman Saat Ini</h3>
        <p>{{ 2}}</p>
    </div>

    <div style="width:300px; background:#e7c6d3; padding:20px; border-radius:10px;">
        <h3>Keterlambatan</h3>
        <p>{{ 3}}</p>
    </div>

</div>

@endsection