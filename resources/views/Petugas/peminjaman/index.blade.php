@extends('petugas.layouts')

@section('title', 'Peminjaman')
@section('header', 'DATA PEMINJAMAN')

@section('content')

<div style="margin-bottom:15px;">
    <span style="font-size:18px; font-weight:bold;">Daftar Peminjaman</span>
</div>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#b57ba6; color:white;">
            <th style="padding:12px;">No</th>
            <th style="padding:12px;">Nama Anggota</th>
            <th style="padding:12px;">Judul Buku</th>
            <th style="padding:12px;">Tgl Pinjam</th>
            <th style="padding:12px;">Tgl Kembali</th>
            <th style="padding:12px;">Jatuh Tempo</th>
            <th style="padding:12px;">Status</th>
            <th style="padding:12px;">Denda</th>
            <th style="padding:12px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($peminjaman as $i => $p)
        @php
            $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo ?? \Carbon\Carbon::parse($p->tgl_kembali)->addDays(3));
            $terlambat     = $p->status === 'dipinjam' && now()->gt($tglJatuhTempo);
            $hariTerlambat = $terlambat ? now()->diffInDays($tglJatuhTempo) : 0;
            $denda         = $hariTerlambat * 5000;
            $sisaHari      = $p->status === 'dipinjam' ? now()->diffInDays($tglJatuhTempo, false) : null;
        @endphp
        <tr style="background:{{ $i % 2 == 0 ? '#f9f9f9' : '#eee' }}; text-align:center;">
            <td style="padding:10px;">{{ $i + 1 }}</td>
            <td style="padding:10px;">{{ $p->anggota->name ?? '-' }}</td>
            <td style="padding:10px;">{{ $p->judul_buku }}</td>
            <td style="padding:10px;">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
            <td style="padding:10px;">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
            <td style="padding:10px;">
                @if($p->status === 'menunggu')
                    <span style="color:#888;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @elseif($p->status === 'dikembalikan')
                    <span style="color:#999;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @elseif($terlambat)
                    <span style="color:red; font-weight:bold;">{{ $tglJatuhTempo->format('d/m/Y') }}<br><small>Terlambat {{ $hariTerlambat }} hari</small></span>
                @elseif($sisaHari <= 3)
                    <span style="color:orange; font-weight:bold;">{{ $tglJatuhTempo->format('d/m/Y') }}<br><small>{{ $sisaHari }} hari lagi</small></span>
                @else
                    <span style="color:green;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @endif
            </td>
            <td style="padding:10px;">
                @if($p->status === 'menunggu')
                    <span style="background:#e3d4f0;color:#6a1b9a;padding:3px 10px;border-radius:20px;font-size:12px;">⏳ Menunggu</span>
                @elseif($p->status === 'dipinjam')
                    <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:12px;">Dipinjam</span>
                @else
                    <span style="background:#d4edda;color:#155724;padding:3px 10px;border-radius:20px;font-size:12px;">Dikembalikan</span>
                @endif
            </td>
            <td style="padding:10px; color:{{ $denda > 0 ? 'red' : '#555' }}; font-weight:{{ $denda > 0 ? 'bold' : 'normal' }};">
                {{ $denda > 0 ? 'Rp '.number_format($denda,0,',','.') : '-' }}
            </td>
            <td style="padding:10px;">
                @if($p->status === 'menunggu')
                    <form action="{{ route('petugas.peminjaman.konfirmasi', $p) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Konfirmasi peminjaman ini?')">
                        @csrf @method('PATCH')
                        <button style="background:#b57ba6;color:white;padding:5px 12px;border:none;border-radius:5px;cursor:pointer;font-size:12px;">
                            Konfirmasi
                        </button>
                    </form>
                @elseif($p->status === 'dipinjam')
                    <form action="{{ route('petugas.peminjaman.kembalikan', $p) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                        @csrf @method('PATCH')
                        <button style="background:#5cb85c;color:white;padding:5px 12px;border:none;border-radius:5px;cursor:pointer;font-size:12px;">
                            Kembalikan
                        </button>
                    </form>
                @else
                    <span style="color:#999;font-size:12px;">-</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="padding:15px;text-align:center;color:#999;">Belum ada data peminjaman.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection
