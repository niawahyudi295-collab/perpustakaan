@extends('Anggota.layouts')

@section('title', 'Pinjam Buku')

@section('content')

<h2>Form Peminjaman Buku</h2>

<form action="/buku/pinjam" method="POST">
    @csrf

    <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

    <p><b>Judul Buku:</b> {{ $buku->judul }}</p>

    <label>Tanggal Kembali:</label><br>
    <input type="date" name="tanggal_kembali" required>

    <br><br>

    <button type="submit">Pinjam</button>
</form>

@endsection