@extends('Anggota.layouts')

@section('title', 'Riwayat Peminjaman')
@section('header', 'RIWAYAT PEMINJAMAN')

@section('content')

<div class="mb-4">
    <h2 class="font-bold text-gray-700 text-lg">Riwayat Peminjaman Saya</h2>
    <p class="text-gray-500 text-sm mt-1">Daftar semua buku yang pernah dipinjam.</p>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#b57ba6;" class="text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                <th class="px-4 py-3 text-center">Tgl Jatuh Tempo</th>
                <th class="px-4 py-3 text-center">Tgl Kembali</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Denda</th>
            </tr>
        </thead>
        <tbody>
        @forelse($riwayat as $i => $p)
            @php
                $tglJatuhTempo = $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo) : null;
                $tglKembali    = $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali) : null;
                $terlambat     = $tglJatuhTempo && $tglKembali && $tglKembali->gt($tglJatuhTempo);
            @endphp
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 font-medium">{{ $p->judul_buku }}</td>
                <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center text-gray-700">
                    {{ $tglJatuhTempo ? $tglJatuhTempo->format('d/m/Y') : '-' }}
                </td>
                <td class="px-4 py-3 text-center {{ $terlambat ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                    {{ $tglKembali ? $tglKembali->format('d/m/Y') : '-' }}
                </td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'dikembalikan' && $terlambat)
                        <span style="background:#f8d7da;color:#721c24;padding:3px 10px;border-radius:20px;font-size:11px;">⚠️ Terlambat</span>
                    @elseif($p->status === 'dikembalikan')
                        <span style="background:#d4edda;color:#155724;padding:3px 10px;border-radius:20px;font-size:11px;">✅ Dikembalikan</span>
                    @elseif($p->status === 'mengembalikan')
                        <span style="background:#cce5ff;color:#004085;padding:3px 10px;border-radius:20px;font-size:11px;">🔄 Menunggu Konfirmasi</span>
                    @elseif($p->status === 'menunggu')
                        <span style="background:#e3d4f0;color:#6a1b9a;padding:3px 10px;border-radius:20px;font-size:11px;">⏳ Menunggu</span>
                    @else
                        <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:11px;">Dipinjam</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center {{ $p->denda > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                    {{ $p->denda > 0 ? 'Rp '.number_format($p->denda,0,',','.') : '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                    <div class="text-3xl mb-2">📜</div>
                    Belum ada riwayat peminjaman.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
