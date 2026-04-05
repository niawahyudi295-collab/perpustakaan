@extends('Anggota.layouts')

@section('title', 'Peminjaman')
@section('header', 'PEMINJAMAN BUKU')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-sm">{{ session('success') }}</div>
@endif

<div class="flex justify-between items-center mb-4">
    <h2 class="font-bold text-gray-700 text-lg">Riwayat Peminjaman Saya</h2>
    <a href="{{ route('anggota.buku.index') }}"
       class="text-white px-4 py-2 rounded text-sm font-semibold"
       style="background-color:#b57ba6;">+ Pinjam Buku</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#b57ba6;" class="text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                <th class="px-4 py-3 text-center">Tgl Kembali</th>
                <th class="px-4 py-3 text-center">Jatuh Tempo</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Denda</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($peminjaman as $i => $p)
            @php
                $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo ?? \Carbon\Carbon::parse($p->tgl_kembali)->addDays(3));
                $hariTerlambat = ($p->status === 'dipinjam' && now()->gt($tglJatuhTempo))
                                    ? now()->diffInDays($tglJatuhTempo) : 0;
                $denda = $hariTerlambat * 5000;
            @endphp
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium">{{ $p->judul_buku }}</td>
                <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center {{ $hariTerlambat > 0 ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                    {{ $tglJatuhTempo->format('d/m/Y') }}
                    @if($hariTerlambat > 0)
                        <br><span class="text-xs">({{ $hariTerlambat }} hari terlambat)</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'menunggu')
                        <span style="background:#e3d4f0;color:#6a1b9a;padding:3px 10px;border-radius:20px;font-size:11px;">⏳ Menunggu</span>
                    @elseif($p->status === 'dipinjam' && $hariTerlambat > 0)
                        <span style="background:#f8d7da;color:#721c24;padding:3px 10px;border-radius:20px;font-size:11px;">Terlambat</span>
                    @elseif($p->status === 'dipinjam')
                        <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:11px;">Dipinjam</span>
                    @else
                        <span style="background:#d4edda;color:#155724;padding:3px 10px;border-radius:20px;font-size:11px;">Dikembalikan</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center {{ $denda > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                    {{ $denda > 0 ? 'Rp '.number_format($denda,0,',','.') : '-' }}
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'dipinjam')
                        <form action="{{ route('anggota.peminjaman.kembalikan', $p) }}" method="POST"
                              onsubmit="return confirm('Kembalikan buku ini?')">
                            @csrf @method('PATCH')
                            <button class="text-white px-3 py-1 rounded text-xs font-semibold"
                                    style="background:#5cb85c;">Kembalikan</button>
                        </form>
                    @elseif($p->status === 'menunggu')
                        <span class="text-xs text-purple-400">Menunggu konfirmasi</span>
                    @else
                        <span class="text-gray-400 text-xs">-</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-400">Belum ada riwayat peminjaman.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
