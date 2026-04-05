@extends('petugas.layouts')

@section('title', 'Daftar Anggota')
@section('header', 'DAFTAR ANGGOTA')

@section('content')

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#b57ba6; color:white;">
            <th style="padding:12px;">No</th>
            <th style="padding:12px;">Nama</th>
            <th style="padding:12px;">Email</th>
            <th style="padding:12px;">No. HP</th>
            <th style="padding:12px;">Alamat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($anggota as $i => $a)
        <tr style="background:{{ $i % 2 == 0 ? '#f9f9f9' : '#eee' }}; text-align:center;">
            <td style="padding:10px;">{{ $i + 1 }}</td>
            <td style="padding:10px;">{{ $a->name }}</td>
            <td style="padding:10px;">{{ $a->email }}</td>
            <td style="padding:10px;">{{ $a->phone_number ?? '-' }}</td>
            <td style="padding:10px;">{{ $a->alamat ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="padding:15px; text-align:center; color:#999;">Belum ada anggota terdaftar.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
