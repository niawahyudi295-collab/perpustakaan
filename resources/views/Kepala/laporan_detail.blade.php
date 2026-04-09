@extends('Kepala.layouts')

@section('title', 'Detail Laporan')
@section('header', 'Detail Laporan Peminjaman')

@section('content')

<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('kepala.laporan') }}"
       class="text-sm text-gray-500 hover:underline">← Kembali ke Laporan</a>
    <div class="flex items-center gap-3">
        <span class="text-xs text-gray-400">Dilihat: {{ now()->format('d F Y, H:i:s') }} WIB</span>
        <a href="{{ route('kepala.laporan.pdf', $peminjaman->id) }}"
           style="background:#b57ba6; color:white; padding:8px 20px; border-radius:6px; text-decoration:none; font-size:14px; font-weight:bold;">
            🖨️ Cetak PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">

    <h3 class="text-lg font-bold mb-6 pb-3 border-b" style="color:#b57ba6;">Informasi Peminjaman #{{ $peminjaman->id }}</h3>

    <div class="grid grid-cols-2 gap-y-4 text-sm">
        <div class="text-gray-500 font-medium">Nama Anggota</div>
        <div class="font-semibold">{{ $peminjaman->anggota->name ?? '-' }}</div>

        <div class="text-gray-500 font-medium">Email Anggota</div>
        <div>{{ $peminjaman->anggota->email ?? '-' }}</div>

        <div class="text-gray-500 font-medium">Judul Buku</div>
        <div class="font-semibold">{{ $peminjaman->judul_buku }}</div>

        <div class="text-gray-500 font-medium">Tanggal Pinjam</div>
        <div>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}</div>

        <div class="text-gray-500 font-medium">Tanggal Kembali</div>
        <div class="{{ $peminjaman->hari_terlambat > 0 ? 'text-red-600 font-bold' : '' }}">
            {{ $peminjaman->status === 'dipinjam' ? '-' : \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') }}
        </div>

        <div class="text-gray-500 font-medium">Status</div>
        <div>
            @if($peminjaman->status === 'dipinjam' && $peminjaman->hari_terlambat > 0)
                <span style="background:#f8d7da; color:#721c24; padding:3px 12px; border-radius:20px;">
                    Terlambat {{ $peminjaman->hari_terlambat }} hari
                </span>
            @elseif($peminjaman->status === 'dipinjam')
                <span style="background:#fff3cd; color:#856404; padding:3px 12px; border-radius:20px;">Dipinjam</span>
            @else
                <span style="background:#d4edda; color:#155724; padding:3px 12px; border-radius:20px;">Dikembalikan</span>
            @endif
        </div>

        <div class="text-gray-500 font-medium">Keterlambatan</div>
        <div class="{{ $peminjaman->hari_terlambat > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
            {{ $peminjaman->hari_terlambat > 0 ? $peminjaman->hari_terlambat . ' hari' : '-' }}
        </div>

        <div class="text-gray-500 font-medium">Denda</div>
        <div class="{{ $peminjaman->denda > 0 ? 'text-red-600 font-bold text-base' : 'text-gray-400' }}">
            {{ $peminjaman->denda > 0 ? 'Rp ' . number_format($peminjaman->denda, 0, ',', '.') : 'Tidak ada denda' }}
        </div>
    </div>

    @if($peminjaman->denda > 0)
    <div class="mt-6 p-4 rounded-lg" style="background:#fff3cd; border:1px solid #ffc107;">
        <p class="text-sm font-semibold" style="color:#856404;">
            ⚠️ Anggota ini dikenakan denda sebesar
            <span class="text-red-600">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
            karena terlambat {{ $peminjaman->hari_terlambat }} hari
            (Rp 2.000 × {{ $peminjaman->hari_terlambat }} hari).
        </p>
    </div>
    @endif

</div>

@endsection
