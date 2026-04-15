@extends('Anggota.layouts')

@section('title', 'Peminjaman')
@section('header', 'PEMINJAMAN BUKU')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-sm">{{ session('success') }}</div>
@endif

<div class="flex justify-between items-center mb-4">
    <h2 class="font-bold text-gray-700 text-lg"> Peminjaman Saya</h2>
    <a href="{{ route('anggota.buku.index') }}"
       class="text-white px-4 py-2 rounded text-sm font-semibold"
      style="background-color:#C8A850; color:#2A2520;">+ Pinjam Buku</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr  style="background-color:#C8A850;" class="text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                <th class="px-4 py-3 text-center">Tgl Jatuh Tempo</th>
                <th class="px-4 py-3 text-center">Tgl Kembali</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Denda</th>
                <th class="px-4 py-3 text-center">Aksi</th>
                
            </tr>
        </thead>
        <tbody>
        @forelse($peminjaman as $i => $p)
            @php
                $tglJatuhTempo = $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo) : null;
                $hariTerlambat = ($tglJatuhTempo && $p->status === 'dipinjam' && now()->gt($tglJatuhTempo))
                                    ? (int) now()->diffInDays($tglJatuhTempo) : 0;
            @endphp
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium">{{ $p->judul_buku }}</td>
                <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center {{ $hariTerlambat > 0 ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                    @if(!$tglJatuhTempo)
                        <span class="text-gray-400 text-xs">Menunggu petugas</span>
                    @else
                        {{ $tglJatuhTempo->format('d/m/Y') }}
                    @endif
                </td>
                <td class="px-4 py-3 text-center text-gray-700">
                    {{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') : '-' }}
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'menunggu')
                        <span style="background:#e3d4f0;color:#6a1b9a;padding:3px 10px;border-radius:20px;font-size:11px;">⏳ Menunggu</span>
                    @elseif($p->status === 'dipinjam' && $hariTerlambat > 0)
                        <span style="background:#f8d7da;color:#721c24;padding:3px 10px;border-radius:20px;font-size:11px;">⚠️ Terlambat</span>
                    @elseif($p->status === 'terlambat')
                        <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:11px;">Dipinjam</span>
                    @elseif($p->status === 'mengembalikan')
                        <span style="background:#cce5ff;color:#004085;padding:3px 10px;border-radius:20px;font-size:11px;">🔄 Menunggu Konfirmasi</span>
                    @else
                        <span style="background:#d4edda;color:#155724;padding:3px 10px;border-radius:20px;font-size:11px;">✅ Dikembalikan</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center {{ $p->denda > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                    {{ $p->denda > 0 ? 'Rp '.number_format($p->denda,0,',','.') : '-' }}
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'dipinjam')
                        <form action="{{ route('anggota.peminjaman.kembalikan', $p) }}" method="POST"
                              onsubmit="return confirm('Ajukan pengembalian buku ini?')">
                            @csrf @method('PATCH')
                            <button class="text-white px-3 py-1 rounded text-xs font-semibold"
                                    style="background:#5cb85c;">Kembalikan</button>
                        </form>
                    @elseif($p->status === 'mengembalikan')
                        <span class="text-xs text-blue-400">Menunggu konfirmasi petugas</span>
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
