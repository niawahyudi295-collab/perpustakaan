@extends('Kepala.layouts')

@section('title', 'Detail Peminjaman')
@section('header', 'DETAIL PEMINJAMAN')

@section('content')

@php
    $dendaKondisi   = $peminjaman->denda_kondisi ?? 0;
    $dendaTerlambat = $peminjaman->denda_keterlambatan ?? 0;
    $hariTerlambat  = $peminjaman->hari_terlambat ?? 0;

    // Jika ada denda kondisi (hilang/rusak), hanya gunakan denda kondisi
    // Jika tidak ada denda kondisi, gunakan denda terlambat
    $denda = ($dendaKondisi > 0) ? $dendaKondisi : $dendaTerlambat;

    // Bangun keterangan denda berdasarkan nominal
    $keteranganDenda = [];

    if ($dendaKondisi === 50000) {
        $keteranganDenda[] = ['label' => '📕 Buku Hilang', 'nominal' => 'Rp 50.000'];
    } elseif ($dendaKondisi === 20000) {
        $keteranganDenda[] = ['label' => '📙 Buku Rusak', 'nominal' => 'Rp 20.000'];
    } elseif ($dendaTerlambat > 0) {
        $keteranganDenda[] = ['label' => '⏰ Terlambat (' . $hariTerlambat . ' hari)', 'nominal' => 'Rp ' . number_format($dendaTerlambat, 0, ',', '.')]; 
    }

    

    $statusColors = [
        'dipinjam'      => ['bg' => '#fff3cd', 'text' => '#856404', 'label' => '📖 Sedang Dipinjam'],
        'mengembalikan' => ['bg' => '#cce5ff', 'text' => '#004085', 'label' => '🔄 Menunggu Pengembalian'],
        'dikembalikan'  => ['bg' => '#d4edda', 'text' => '#155724', 'label' => '✓ Sudah Dikembalikan'],
        'hilang'        => ['bg' => '#f8d7da', 'text' => '#721c24', 'label' => '📕 Buku Hilang'],
        'rusak'         => ['bg' => '#ffeaa7', 'text' => '#856400', 'label' => '📙 Buku Rusak'],
        'terlambat'     => ['bg' => '#f8d7da', 'text' => '#721c24', 'label' => '⚠️ Terlambat'],
    ];

    $statusDasar = strtolower($peminjaman->status ?? '');

    if ($dendaKondisi === 50000) {
        $displayStatus = 'hilang';
    } elseif ($dendaKondisi === 20000) {
        $displayStatus = 'rusak';
    } elseif ($hariTerlambat > 0) {
        $displayStatus = 'terlambat';
    } else {
        $displayStatus = $statusDasar;
    }

    $colors = $statusColors[$displayStatus] ?? ['bg' => '#e2e3e5', 'text' => '#383d41', 'label' => $peminjaman->status];
@endphp
<style>
.card-custom {
    background: white;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    margin-bottom: 16px;
    border-left: 4px solid #C8A850;
}

.card-custom.danger { border-left-color: #e74c3c; }
.card-custom.success { border-left-color: #27ae60; }

.card-title {
    font-size: 14px;
    font-weight: bold;
    color: #382e2e;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;
}

.info-row:last-child { border-bottom: none; }

.info-label {
    font-weight: 600;
    color: #504840;
    font-size: 13px;
}

.info-value {
    color: #382e2e;
    font-size: 13px;
}

.badge-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-back {
    background: #6c757d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-back:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.btn-print-detail {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    justify-content: center;
}

.btn-print-detail:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    color: white;
    text-decoration: none;
}

.denda-container {
    background: linear-gradient(135deg, #fef9ec, #fffaf0);
    border-left: 4px solid #f39c12;
    padding: 16px;
    border-radius: 8px;
    margin-top: 12px;
}

.denda-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 13px;
    border-bottom: 1px dashed #f0d080;
}

.denda-item:last-child { border-bottom: none; }

.denda-total {
    font-weight: 700;
    font-size: 16px;
    color: #e74c3c;
    border-top: 2px solid #f39c12;
    padding-top: 8px;
    margin-top: 8px;
    display: flex;
    justify-content: space-between;
}
</style>

{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
        <div style="font-size: 12px; color: #967830; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Detail Transaksi</div>
        <div style="font-size: 24px; font-weight: bold; color: #382e2e;">Peminjaman No. #{{ $peminjaman->id }}</div>
    </div>
    <a href="{{ route('kepala.laporan') }}" class="btn-back">
        ← Kembali
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">

    {{-- Main Info --}}
    <div>
        {{-- Info Anggota --}}
        <div class="card-custom">
            <div class="card-title">👤 Informasi Anggota</div>
            <div class="info-row">
                <div class="info-label">Nama Anggota</div>
                <div class="info-value" style="font-weight: 700; color: #C8A850;">{{ $peminjaman->anggota->name ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">ID Anggota</div>
                <div class="info-value">#{{ $peminjaman->anggota_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $peminjaman->anggota->email ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nomor Telepon</div>
                <div class="info-value">{{ $peminjaman->anggota->phone_number ?? '-' }}</div>
            </div>
        </div>

        {{-- Info Buku & Peminjaman --}}
        <div class="card-custom">
            <div class="card-title">📚 Informasi Buku & Peminjaman</div>
            <div class="info-row">
                <div class="info-label">Judul Buku</div>
                <div class="info-value">{{ $peminjaman->judul_buku ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kondisi Buku</div>
                <div class="info-value">
                    @if($dendaKondisi === 50000)
                        <span class="badge-status" style="background: #f8d7da; color: #721c24;">📕 Hilang</span>
                    @elseif($dendaKondisi === 20000)
                        <span class="badge-status" style="background: #ffeaa7; color: #856400;">📙 Rusak</span>
                    @else
                        <span class="badge-status" style="background: #d4edda; color: #155724;">✅ Baik</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pinjam</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jatuh Tempo</div>
                <div class="info-value" style="color: {{ \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->isPast() && $peminjaman->status === 'dipinjam' ? '#e74c3c' : '#27ae60' }}; font-weight: 600;">
                    {{ $peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d F Y') : '-' }}
                    @if(\Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->isPast() && $peminjaman->status === 'dipinjam')
                        <span style="color: #e74c3c; font-size: 11px;"> (TERLAMBAT)</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Kembali</div>
                <div class="info-value">{{ $peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') : '—' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status Peminjaman</div>
                <div class="info-value">
                    <span class="badge-status" style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }};">
                        {{ $colors['label'] }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Petugas</div>
                <div class="info-value">{{ auth()->user()->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Sidebar Info Denda --}}
    <div>
        {{-- Denda Info --}}
        <div class="card-custom {{ $denda > 0 ? 'danger' : 'success' }}">
            <div class="card-title">💰 Informasi Denda</div>

            @if($denda > 0)
                <div class="denda-container">
                    @foreach($keteranganDenda as $ket)
                        <div class="denda-item">
                            <span>{{ $ket['label'] }}</span>
                            <span style="font-weight: 600; color: #c0392b;">{{ $ket['nominal'] }}</span>
                        </div>
                    @endforeach
                    <div class="denda-total">
                        <span>Total Denda</span>
                        <span>Rp {{ number_format($denda, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 30px 0;">
                    <div style="font-size: 40px; margin-bottom: 12px;">✓</div>
                    <div style="font-size: 14px; font-weight: 600; color: #27ae60; margin-bottom: 4px;">Tidak Ada Denda</div>
                    <div style="font-size: 12px; color: #999;">Peminjaman ini tidak memiliki denda</div>
                </div>
            @endif
        </div>

        {{-- Ketentuan Denda --}}
        <div class="card-custom">
            <div class="card-title">📌 Ketentuan Denda</div>
            <div style="font-size: 12px; color: #504840; line-height: 1.8;">
                <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                    <span>📕</span>
                    <div><strong>Buku Hilang:</strong> Rp 50.000 (flat)</div>
                </div>
                <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                    <span>📙</span>
                    <div><strong>Buku Rusak:</strong> Rp 20.000 (flat)</div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <span>⏰</span>
                    <div><strong>Terlambat:</strong> Rp 2.000/hari</div>
                </div>
            </div>
        </div>

        {{-- Action Button --}}
        <a href="{{ route('kepala.laporan.pdf', $peminjaman->id) }}" target="_blank" class="btn-print-detail">
            📄 Cetak PDF Detail
        </a>
    </div>
</div>

@endsection