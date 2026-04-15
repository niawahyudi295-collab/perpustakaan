@extends('petugas.layouts')

@section('title', 'Daftar Anggota')
@section('header', 'DAFTAR ANGGOTA')

@section('content')

@if(session('success'))
    <div style="background:#504840; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#977868; color:white; font-weight:bold;">
            <th style="padding:12px;">No</th>
            <th style="padding:12px;">Nama</th>
            <th style="padding:12px;">Email</th>
            <th style="padding:12px;">No. HP</th>
            <th style="padding:12px;">Alamat</th>
            <th style="padding:12px;">Aksi</th>
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
            <td style="padding:10px;">

                <form action="{{ route('petugas.anggota.destroy', $a) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Hapus anggota {{ $a->name }}?')">
                    @csrf @method('DELETE')
                    <button style="background:#d9534f;color:white;padding:5px 12px;border:none;border-radius:5px;cursor:pointer;font-size:12px;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="padding:15px; text-align:center; color:#999;">Belum ada anggota terdaftar.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
