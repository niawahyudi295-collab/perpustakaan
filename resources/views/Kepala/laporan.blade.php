@extends('Kepala.layouts')

@section('title', 'Laporan')
@section('header', 'Laporan Transaksi')

@section('content')

<div class="flex justify-between items-center mb-5">
    <h2 class="text-xl font-bold text-gray-800">Data Laporan Peminjaman</h2>
</div>

<div class="rounded overflow-hidden shadow">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#b57ba6;" class="text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Anggota</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                <th class="px-4 py-3 text-center">Tgl Kembali</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Denda</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($data as $i => $p)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3">{{ $p->anggota->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $p->judul_buku }}</td>
                <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center">{{ $p->status === 'dipinjam' ? '-' : \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-center">
                    @if($p->status === 'dipinjam' && $p->hari_terlambat > 0)
                        <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:11px;">Terlambat</span>
                    @elseif($p->status === 'dipinjam')
                        <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px;">Dipinjam</span>
                    @else
                        <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:20px; font-size:11px;">Dikembalikan</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center {{ $p->denda > 0 ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                    {{ $p->denda > 0 ? 'Rp '.number_format($p->denda,0,',','.') : '-' }}
                </td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('kepala.laporan.detail', $p->id) }}"
                       style="background:#b57ba6; color:white; padding:5px 14px; border-radius:5px; text-decoration:none; font-size:12px;">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-4 py-4 text-center text-gray-400">Belum ada data transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
