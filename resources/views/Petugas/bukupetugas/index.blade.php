@extends('petugas.layouts')

@section('title', 'Data Buku')
@section('header', 'DATA BUKU')

@section('content')

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-bottom:15px;">
    <a href="{{ route('petugas.bukupetugas.create') }}"
       style="background:#b57ba6; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-size:14px;">
        + Tambah Buku
    </a>
</div>

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#b57ba6; color:white;">
            <th style="padding:12px;">Cover</th>
            <th style="padding:12px;">Judul</th>
            <th style="padding:12px;">Kategori</th>
            <th style="padding:12px;">Penulis</th>
            <th style="padding:12px;">Penerbit</th>
            <th style="padding:12px;">Tahun</th>
            <th style="padding:12px;">Stok</th>
            <th style="padding:12px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($buku as $b)
        <tr style="background:#f9f9f9; text-align:center; border-bottom:1px solid #eee;">
            <td style="padding:8px;">
                @if($b->cover)
                    <img src="{{ asset('images/' . $b->cover) }}" alt="cover"
                         style="width:50px; height:65px; object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                @else
                    <span style="color:#ccc; font-size:12px;">-</span>
                @endif
            </td>
            <td style="padding:10px; text-align:left;">{{ $b->judul }}</td>
            <td style="padding:10px;">{{ $b->kategori ?? '-' }}</td>
            <td style="padding:10px;">{{ $b->penulis ?? '-' }}</td>
            <td style="padding:10px;">{{ $b->penerbit }}</td>
            <td style="padding:10px;">{{ $b->tahun ?? '-' }}</td>
            <td style="padding:10px;">{{ $b->stok ?? $b->jumlah }}</td>
            <td style="padding:10px;">
                <a href="{{ route('petugas.bukupetugas.edit', $b->id) }}"
                   style="background:#f0ad4e; color:white; padding:5px 10px; text-decoration:none; border-radius:5px; font-size:12px;">Edit</a>
                <form action="{{ route('petugas.bukupetugas.destroy', $b->id) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Hapus buku ini?')">
                    @csrf @method('DELETE')
                    <button style="background:red; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="padding:15px; text-align:center; color:#999;">Belum ada data buku.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
