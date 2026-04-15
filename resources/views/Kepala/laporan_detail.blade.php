@extends('Kepala.layouts')

@section('title', 'Detail Laporan')
@section('header', 'Detail Laporan Peminjaman')

@section('content')

<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('kepala.laporan') }}"
       class="text-sm hover:underline transition" style="color: #967830;">← Kembali ke Laporan</a>
    <div class="flex items-center gap-3">
        <span class="text-xs" style="color: #504840;">Dilihat: {{ now()->format('d F Y, H:i:s') }} WIB</span>
        <a href="{{ route('kepala.laporan.pdf', $peminjaman->id) }}"
           style="background:#C8A850; color:#2A2520; padding:8px 20px; border-radius:6px; text-decoration:none; font-size:14px; font-weight:bold;"
           onmouseover="this.style.backgroundColor='#967830'" onmouseout="this.style.backgroundColor='#C8A850'">
            🖨️ Cetak PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">

    <h3 class="text-lg font-bold mb-6 pb-3 border-b" style="color:#C8A850; border-color:#C8A850;">
        Informasi Peminjaman #{{ $peminjaman->id }}
    </h3>

    <div class="grid grid-cols-2 gap-y-4 text-sm">
        <div style="color:#504840;" class="font-medium">Nama Anggota</div>
        <div class="font-semibold">{{ $peminjaman->anggota->name ?? '-' }}</div>

        <div style="color:#504840;" class="font-medium">Email Anggota</div>
        <div>{{ $peminjaman->anggota->email ?? '-' }}</div>

        <div style="color:#504840;" class="font-medium">Judul Buku</div>
        <div class="font-semibold">{{ $peminjaman->judul_buku }}</div>

        <div style="color:#504840;" class="font-medium">Tanggal Pinjam</div>
        <div>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}</div>

        <div style="color:#504840;" class="font-medium">Tanggal Kembali</div>
        <div class="{{ $peminjaman->hari_terlambat > 0 ? 'font-bold' : '' }}"
             style="color: {{ $peminjaman->hari_terlambat > 0 ? '#967830' : '#000' }};">
            {{ $peminjaman->status === 'dipinjam' ? '-' : \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') }}
        </div>

        <div style="color:#504840;" class="font-medium">Kondisi Buku</div>
        <div>
            @if($peminjaman->kondisi_buku === 'hilang')
                <span style="background:#f8d7da; color:#721c24; padding:3px 12px; border-radius:20px;">📕 Hilang</span>
            @elseif($peminjaman->kondisi_buku === 'rusak')
                <span style="background:#fff3cd; color:#856404; padding:3px 12px; border-radius:20px;">📙 Rusak</span>
            @else
                <span style="background:#d4edda; color:#155724; padding:3px 12px; border-radius:20px;">✅ Baik</span>
            @endif
        </div>

        <div style="color:#504840;" class="font-medium">Status</div>
        <div>
            @if($peminjaman->status === 'dipinjam' && $peminjaman->hari_terlambat > 0)
                <span style="background:#f5e6cc; color:#967830; padding:3px 12px; border-radius:20px;">
                    ⚠️ Terlambat {{ $peminjaman->hari_terlambat }} hari
                </span>
            @elseif($peminjaman->status === 'dipinjam')
                <span style="background:#e8f4e8; color:#2A2520; padding:3px 12px; border-radius:20px;">
                    Dipinjam
                </span>
            @else
                <span style="background:#dfe8dc; color:#2A2520; padding:3px 12px; border-radius:20px;">
                    Dikembalikan
                </span>
            @endif
        </div>

        <div style="color:#504840;" class="font-medium">Keterlambatan</div>
        <div class="{{ $peminjaman->hari_terlambat > 0 ? 'font-bold' : '' }}"
             style="color: {{ $peminjaman->hari_terlambat > 0 ? '#967830' : '#C8A850' }};">
            {{ $peminjaman->hari_terlambat > 0 ? $peminjaman->hari_terlambat . ' hari' : '-' }}
        </div>

        {{-- Rincian denda --}}
        <div style="color:#504840;" class="font-medium">Denda Keterlambatan</div>
        <div style="color: {{ $peminjaman->denda_keterlambatan > 0 ? '#967830' : '#C8A850' }}; font-weight: {{ $peminjaman->denda_keterlambatan > 0 ? 'bold' : 'normal' }};">
            {{ $peminjaman->denda_keterlambatan > 0 ? 'Rp ' . number_format($peminjaman->denda_keterlambatan, 0, ',', '.') : '-' }}
        </div>

        <div style="color:#504840;" class="font-medium">Denda Kondisi Buku</div>
        <div style="color: {{ $peminjaman->denda_kondisi > 0 ? '#967830' : '#C8A850' }}; font-weight: {{ $peminjaman->denda_kondisi > 0 ? 'bold' : 'normal' }};">
            {{ $peminjaman->denda_kondisi > 0 ? 'Rp ' . number_format($peminjaman->denda_kondisi, 0, ',', '.') : '-' }}
        </div>

        <div style="color:#504840;" class="font-medium">Total Denda</div>
        <div class="{{ $peminjaman->denda > 0 ? 'font-bold text-base' : '' }}"
             style="color: {{ $peminjaman->denda > 0 ? '#967830' : '#C8A850' }};">
            {{ $peminjaman->denda > 0 ? 'Rp ' . number_format($peminjaman->denda, 0, ',', '.') : 'Tidak ada denda' }}
        </div>
    </div>

    @if($peminjaman->denda > 0)
    <div class="mt-6 p-4 rounded-lg" style="background:#f5e6cc; border:1px solid #C8A850;">
        <p class="text-sm font-semibold" style="color:#504840;">
            @if($peminjaman->kondisi_buku === 'hilang')
                ⚠️ Buku dinyatakan <b>hilang</b> — denda Rp {{ number_format($peminjaman->denda_kondisi, 0, ',', '.') }}
            @endif
            @if($peminjaman->kondisi_buku === 'rusak')
                ⚠️ Buku dalam kondisi <b>rusak</b> — denda Rp {{ number_format($peminjaman->denda_kondisi, 0, ',', '.') }}
            @endif
            @if($peminjaman->hari_terlambat > 0)
                @if($peminjaman->kondisi_buku !== 'baik') <br> @endif
                ⚠️ Terlambat <b>{{ $peminjaman->hari_terlambat }} hari</b>
                (Rp 2.000 × {{ $peminjaman->hari_terlambat }} hari = Rp {{ number_format($peminjaman->denda_keterlambatan, 0, ',', '.') }})
            @endif
        </p>
    </div>
    @endif

</div>

@endsection