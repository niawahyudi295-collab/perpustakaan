@extends('petugas.layouts')

@section('title', 'Dashboard Petugas')

@section('header')
Selamat Datang, Petugas 👋
@endsection

@section('content')
<div class="cards">
    <div class="card">
        <h3>📚 Kelola Buku</h3>
        <p>Tambah, edit, dan hapus buku</p>
        <a href="{{ route('bukupetugas.create') }}" class="btn-tambah">+Tambah Buku</a>
    </div>

    <div class="card">
        <h3>📂 Kategori</h3>
        <p>Atur kategori buku</p>
        <a href="/kategori">Masuk</a>
    </div>

    <div class="card">
        <h3>📖 Peminjaman</h3>
        <p>Kelola peminjaman buku</p>
        <a href="/peminjaman">Masuk</a>
    </div>

    <div class="card">
        <h3>👥 Anggota</h3>
        <p>Data anggota perpustakaan</p>
        <a href="/anggota">Masuk</a>
    </div>

    <div class="card">
        <h3>📕 Katalog</h3>
        <p>Lihat daftar buku</p>
        <a href="/katalog">Masuk</a>
    </div>
</div>
@endsection