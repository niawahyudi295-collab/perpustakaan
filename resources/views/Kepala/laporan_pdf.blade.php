<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman #{{ $peminjaman->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; padding: 30px; }

        .header {
            text-align: center;
            border-bottom: 3px solid #C8A850;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 { font-size: 20px; color: #C8A850; margin-bottom: 4px; }
        .header p { font-size: 12px; color: #504840; }

        .section-title {
            background: #C8A850;
            color: #2A2520;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
            border-radius: 4px;
        }

        table.info { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.info td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        table.info td:first-child { width: 40%; color: #666; font-weight: bold; }

        .denda-box {
            background: #f5e6cc;
            border: 1px solid #C8A850;
            padding: 12px 16px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .denda-row { display: flex; justify-content: space-between; padding: 4px 0; font-size: 12px; color: #504840; }
        .denda-row.total { border-top: 1px solid #C8A850; margin-top: 6px; padding-top: 8px; font-weight: bold; font-size: 14px; color: #967830; }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 12px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN PEMINJAMAN BUKU</h1>
    <p>Perpustakaan Digital &nbsp;|&nbsp; Dicetak: {{ now()->format('d F Y, H:i:s') }} WIB</p>
</div>

<div class="section-title">Data Anggota</div>
<table class="info">
    <tr><td>Nama</td><td>{{ $peminjaman->anggota->name ?? '-' }}</td></tr>
    <tr><td>Email</td><td>{{ $peminjaman->anggota->email ?? '-' }}</td></tr>
</table>

<div class="section-title">Data Peminjaman</div>
<table class="info">
    <tr><td>No. Transaksi</td><td>#{{ $peminjaman->id }}</td></tr>
    <tr><td>Judul Buku</td><td>{{ $peminjaman->judul_buku }}</td></tr>
    <tr><td>Tanggal Pinjam</td><td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}</td></tr>
    <tr>
        <td>Tanggal Kembali</td>
        <td>{{ $peminjaman->status === 'dipinjam' ? '-' : \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') }}</td>
    </tr>
    <tr>
        <td>Kondisi Buku</td>
        <td>
            @if($peminjaman->kondisi === 'hilang') 📕 Hilang
            @elseif($peminjaman->kondisi === 'rusak') 📙 Rusak
            @else ✅ Baik
            @endif
        </td>
    </tr>
    <tr>
        <td>Status</td>
        <td>
            @php
                // Tentukan status berdasarkan denda
                if ($peminjaman->denda >= 50000) {
                    $statusDisplay = '📕 Buku Hilang';
                    $statusColor = '#721c24';
                } elseif ($peminjaman->denda >= 20000) {
                    $statusDisplay = '📙 Buku Rusak';
                    $statusColor = '#f39c12';
                } elseif ($peminjaman->denda > 0) {
                    $statusDisplay = '⚠️ Terlambat ' . ($peminjaman->hari_terlambat ?? 0) . ' hari';
                    $statusColor = '#721c24';
                } elseif ($peminjaman->status === 'dipinjam') {
                    $statusDisplay = 'Sedang Dipinjam';
                    $statusColor = '#856404';
                } else {
                    $statusDisplay = 'Sudah Dikembalikan';
                    $statusColor = '#155724';
                }
            @endphp
            <strong style="color:{{ $statusColor }};">{{ $statusDisplay }}</strong>
        </td>
    </tr>
</table>

<div class="section-title">Informasi Denda</div>
@if($peminjaman->denda > 0)
<div class="denda-box">
    @php
        $dendaKondisi = $peminjaman->denda_kondisi ?? 0;
        $dendaTerlambat = $peminjaman->denda_keterlambatan ?? 0;
        $hariTerlambat = $peminjaman->hari_terlambat ?? 0;
    @endphp
    
    @if($dendaKondisi > 0)
    <div class="denda-row">
        <span>
            @if($peminjaman->kondisi === 'hilang') Buku Hilang
            @else Buku Rusak
            @endif
        </span>
        <span>Rp {{ number_format($dendaKondisi, 0, ',', '.') }}</span>
    </div>
    @elseif($dendaTerlambat > 0)
    <div class="denda-row">
        <span>Keterlambatan ({{ $hariTerlambat }} hari × Rp 2.000)</span>
        <span>Rp {{ number_format($dendaTerlambat, 0, ',', '.') }}</span>
    </div>
    @endif

    <div class="denda-row total">
        <span>Total Denda</span>
        <span>Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
    </div>
</div>
@else
<table class="info">
    <tr><td>Keterlambatan</td><td>-</td></tr>
    <tr><td>Kondisi Buku</td><td>Baik</td></tr>
    <tr><td>Total Denda</td><td><strong style="color:#155724;">Tidak ada denda</strong></td></tr>
</table>
@endif

<div class="section-title">Status Pembayaran Denda</div>
@if($peminjaman->denda > 0)
<table class="info">
    <tr>
        <td>Status Pembayaran</td>
        <td>
            @if($peminjaman->status_pembayaran === 'belum_dibayar')
                <strong style="color:#856404;">💰 Belum Dibayar</strong>
            @elseif($peminjaman->status_pembayaran === 'pending_konfirmasi')
                <strong style="color:#004085;">⏳ Menunggu Konfirmasi</strong>
            @elseif($peminjaman->status_pembayaran === 'lunas')
                <strong style="color:#155724;">✅ LUNAS</strong>
            @endif
        </td>
    </tr>
    @if($peminjaman->status_pembayaran === 'lunas' && $peminjaman->tgl_konfirmasi_pembayaran)
    <tr>
        <td>Tanggal Konfirmasi</td>
        <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_konfirmasi_pembayaran)->format('d F Y, H:i:s') }} WIB</td>
    </tr>
    @endif
</table>
@else
<table class="info">
    <tr><td>Keterangan</td><td>Tidak ada denda, pembayaran tidak diperlukan</td></tr>
</table>
@endif

<div class="footer">
    Dokumen ini dicetak secara otomatis oleh Sistem Perpustakaan Digital
</div>

</body>
</html>