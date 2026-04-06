@extends('Anggota.layouts')

@section('title', 'Dashboard')
@section('header', 'DASHBOARD')

@section('content')

{{-- Greeting --}}
<div class="text-center text-2xl font-semibold text-gray-700 mb-2 mt-2">
    Hai! Selamat Datang di Perpustakaan Digital 🙂
</div>
<div class="text-center text-gray-500 text-sm mb-8">
    Silakan mulai mencari buku, meminjam, atau melihat status peminjamanmu.
</div>

{{-- Aktivitas Terbaru --}}
<div class="bg-white rounded-xl shadow p-5 mb-8">
    <h3 class="font-bold text-gray-700 mb-4 text-base flex items-center gap-2">
        🔔 Aktivitas Peminjaman Terbaru
    </h3>

    @if($aktivitas->isEmpty())
        <p class="text-gray-400 text-sm text-center py-3">Belum ada aktivitas peminjaman.</p>
    @else
        <div class="space-y-2">
            @foreach($aktivitas as $a)
            @php
                $isMe = $a->anggota_id === Auth::id();
                $waktu = \Carbon\Carbon::parse($a->created_at)->diffForHumans();
            @endphp
            <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background-color: #b57ba6;">
                    {{ strtoupper(substr($a->anggota->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 text-sm">
                    <span class="font-semibold text-gray-800">
                        {{ $isMe ? 'Kamu' : ($a->anggota->name ?? '-') }}
                    </span>
                    @if($a->status === 'dipinjam')
                        <span class="text-gray-600"> meminjam </span>
                        <span class="font-semibold" style="color:#b57ba6;">{{ $a->judul_buku }}</span>
                    @elseif($a->status === 'mengembalikan')
                        <span class="text-gray-600"> mengajukan pengembalian </span>
                        <span class="font-semibold text-blue-500">{{ $a->judul_buku }}</span>
                    @elseif($a->status === 'menunggu')
                        <span class="text-gray-600"> mengajukan pinjam </span>
                        <span class="font-semibold text-purple-500">{{ $a->judul_buku }}</span>
                    @else
                        <span class="text-gray-600"> mengembalikan </span>
                        <span class="font-semibold text-green-600">{{ $a->judul_buku }}</span>
                    @endif
                </div>
                <div class="text-xs text-gray-400 flex-shrink-0">{{ $waktu }}</div>
                @if($a->status === 'dipinjam')
                    <span style="background:#fff3cd; color:#856404; padding:2px 8px; border-radius:20px; font-size:11px;">Dipinjam</span>
                @elseif($a->status === 'mengembalikan')
                    <span style="background:#cce5ff; color:#004085; padding:2px 8px; border-radius:20px; font-size:11px;">Minta Kembali</span>
                @elseif($a->status === 'menunggu')
                    <span style="background:#e3d4f0; color:#6a1b9a; padding:2px 8px; border-radius:20px; font-size:11px;">Menunggu</span>
                @else
                    <span style="background:#d4edda; color:#155724; padding:2px 8px; border-radius:20px; font-size:11px;">Dikembalikan</span>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Info Peminjaman Saya --}}
<div class="grid grid-cols-3 gap-4">
    <div class="bg-white rounded-xl shadow p-5 text-center">
        <div class="text-gray-500 text-sm mb-1">Buku Dipinjam</div>
        <div class="text-3xl font-bold" style="color:#b57ba6;">{{ $dipinjam }}</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center">
        <div class="text-gray-500 text-sm mb-1">Jatuh Tempo</div>
        <div class="text-2xl font-bold {{ $sisaHari !== null && $sisaHari < 0 ? 'text-red-500' : 'text-yellow-500' }}">
            @if($sisaHari === null) -
            @elseif($sisaHari < 0) {{ abs($sisaHari) }} Hari Terlambat
            @else {{ $sisaHari }} Hari Lagi
            @endif
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 text-center">
        <div class="text-gray-500 text-sm mb-1">Total Denda</div>
        <div class="text-2xl font-bold text-red-500">
            Rp {{ number_format($totalDenda, 0, ',', '.') }}
        </div>
    </div>
</div>

@endsection
