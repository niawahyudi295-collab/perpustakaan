@extends('Anggota.layouts')

@section('title', 'Pengembalian')
@section('header', 'PENGEMBALIAN BUKU')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-sm">{{ session('success') }}</div>
@endif

<div class="mb-4">
    <h2 class="font-bold text-gray-700 text-lg">Ajukan Pengembalian Buku</h2>
    <p class="text-gray-500 text-sm mt-1">Pilih buku yang ingin dikembalikan. Pengembalian akan menunggu konfirmasi petugas.</p>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#b57ba6;" class="text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                <th class="px-4 py-3 text-center">Tgl Jatuh Tempo</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($peminjaman as $i => $p)
            @php
                $tglJatuhTempo = $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo) : null;
                $terlambat = $tglJatuhTempo && now()->gt($tglJatuhTempo);
                $hariTerlambat = $terlambat ? now()->diffInDays($tglJatuhTempo) : 0;
            @endphp
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium">{{ $p->judul_buku }}</td>
                <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center {{ $terlambat ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                    @if(!$tglJatuhTempo)
                        <span class="text-gray-400 text-xs">Belum ditentukan</span>
                    @else
                        {{ $tglJatuhTempo->format('d/m/Y') }}
                        @if($terlambat)
                            <br><span class="text-xs">({{ $hariTerlambat }} hari terlambat)</span>
                        @endif
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'dipinjam' && $terlambat)
                        <span style="background:#f8d7da;color:#721c24;padding:3px 10px;border-radius:20px;font-size:11px;">⚠️ Terlambat</span>
                    @elseif($p->status === 'dipinjam')
                        <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:11px;">Dipinjam</span>
                    @else
                        <span style="background:#cce5ff;color:#004085;padding:3px 10px;border-radius:20px;font-size:11px;">🔄 Menunggu Konfirmasi</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'dipinjam')
                        <form action="{{ route('anggota.peminjaman.kembalikan', $p) }}" method="POST"
                              onsubmit="return confirm('Ajukan pengembalian buku ini? Pengembalian akan dikonfirmasi oleh petugas.')">
                            @csrf @method('PATCH')
                            <button class="text-white px-3 py-1 rounded text-xs font-semibold"
                                    style="background:#5cb85c;">Kembalikan</button>
                        </form>
                    @else
                        <span class="text-xs text-blue-400">Menunggu konfirmasi petugas</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                    <div class="text-3xl mb-2">📚</div>
                    Tidak ada buku yang sedang dipinjam.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
