@extends('Kepala.layouts')

@section('title', 'Laporan')
@section('header', 'Laporan Transaksi')

@section('content')

<div class="flex justify-between items-center mb-5">
    <h2 class="text-xl font-bold text-gray-800">Data Laporan Peminjaman</h2>
    <a href="{{ route('kepala.laporan.cetak.pdf') }}"
       style="background:#C8A850; color:#2A2520; padding:8px 18px; border-radius:6px; text-decoration:none; font-size:13px; font-weight:bold;"
       onmouseover="this.style.background='#967830'; this.style.color='#F5F2EE';"
       onmouseout="this.style.background='#C8A850'; this.style.color='#2A2520';">
        🖨️ Cetak PDF
    </a>
</div>

<div class="rounded overflow-hidden shadow">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color:#504840;" class="text-white">
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Anggota</th>
                <th class="px-4 py-3 text-left">Judul Buku</th>
                <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                <th class="px-4 py-3 text-center">Tgl Jatuh Tempo</th>
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

                {{-- Tgl Pinjam --}}
                <td class="px-4 py-3 text-center">
                    {{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') : '-' }}
                </td>

                {{-- Tgl Jatuh Tempo — kuning jika masih dipinjam & belum lewat, merah jika terlambat --}}
                <td class="px-4 py-3 text-center">
                    @if($p->tgl_jatuh_tempo)
                        @php
                            $isLewat = $p->hari_terlambat > 0;
                            $isMasihPinjam = $p->status === 'dipinjam';
                        @endphp
                        <span style="
                            color: {{ ($isMasihPinjam && $isLewat) ? '#721c24' : ($isMasihPinjam ? '#856404' : '#888') }};
                            font-weight: {{ $isMasihPinjam ? '600' : '400' }};
                        ">
                            {{ \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->format('d/m/Y') }}
                        </span>
                    @else
                        -
                    @endif
                </td>

                {{-- Tgl Kembali --}}
                <td class="px-4 py-3 text-center">
                    {{ ($p->status !== 'dipinjam' && $p->tgl_kembali)
                        ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y')
                        : '-' }}
                </td>

                {{-- Status — prioritas: kondisi buku dulu, lalu status pinjam --}}
                <td class="px-4 py-3 text-center">
                    @if($p->kondisi_buku === 'hilang')
                        <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:11px; display:inline-flex; align-items:center; gap:4px;">
                            <span style="width:7px;height:7px;background:#c0392b;border-radius:50%;display:inline-block;"></span>
                            Buku Hilang
                        </span>
                    @elseif($p->kondisi_buku === 'rusak')
                        <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px;">
                            📙 Buku Rusak
                        </span>
                    @elseif($p->status === 'dipinjam' && $p->hari_terlambat > 0)
                        <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:11px;">
                            ⚠️ Terlambat {{ $p->hari_terlambat }}h
                        </span>
                    @elseif($p->status === 'dipinjam')
                        <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px;">
                            Dipinjam
                        </span>
                    @elseif($p->status === 'mengembalikan')
                        <span style="background:#cce5ff; color:#004085; padding:3px 10px; border-radius:20px; font-size:11px;">
                            Mengembalikan
                        </span>
                    @else
                        <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:20px; font-size:11px;">
                            ✅ Dikembalikan
                        </span>
                    @endif
                </td>

                {{-- Denda — tampilkan rincian singkat via tooltip title --}}
                <td class="px-4 py-3 text-center">
                    @if($p->denda > 0)
                        @php
                            $rincian = [];
                            if ($p->denda_keterlambatan > 0)
                                $rincian[] = $p->hari_terlambat . ' hari × Rp 2.000 = Rp ' . number_format($p->denda_keterlambatan, 0, ',', '.');
                            if ($p->denda_kondisi > 0)
                                $rincian[] = ($p->kondisi_buku === 'hilang' ? 'Hilang' : 'Rusak') . ' = Rp ' . number_format($p->denda_kondisi, 0, ',', '.');
                        @endphp
                        <span style="color:#A32D2D; font-weight:600; cursor:default;"
                              title="{{ implode(' | ', $rincian) }}">
                            Rp {{ number_format($p->denda, 0, ',', '.') }}
                        </span>
                        {{-- Ikon pensil kecil --}}
                        <span style="color:#C8A850; font-size:12px; margin-left:3px;">✏️</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('kepala.laporan.detail', $p->id) }}"
                       style="background:#C8A850; color:#2A2520; padding:5px 14px; border-radius:5px; text-decoration:none; font-size:12px; font-weight:600;"
                       onmouseover="this.style.background='#967830'; this.style.color='#F5F2EE';"
                       onmouseout="this.style.background='#C8A850'; this.style.color='#2A2520';">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-4 py-4 text-center text-gray-400">Belum ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection