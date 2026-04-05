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
            border-bottom: 3px solid #b57ba6;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 { font-size: 20px; color: #b57ba6; margin-bottom: 4px; }
        .header p { font-size: 12px; color: #777; }

        .section-title {
            background: #b57ba6;
            color: white;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
            border-radius: 4px;
        }

        table.info { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.info td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        table.info td:first-child { width: 40%; color: #666; font-weight: bold; }

        .status-box {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .status-terlambat { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .status-dipinjam  { background: #fff3cd; color: #856404; border: 1px solid #ffc107; }
        .status-kembali   { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .denda-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 12px 16px;
            border-radius: 6px;
            margin-top: 10px;
        }
        .denda-box .nominal { font-size: 22px; font-weight: bold; color: #e53935; margin-top: 4px; }

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
    <p>Perpustakaan Digital &nbsp;|&nbsp; Dicetak: {{ now()->format('d F Y, H:i') }}</p>
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
    <tr><td>Tanggal Kembali</td><td>{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') }}</td></tr>
    <tr>
        <td>Status</td>
        <td>
            @if($peminjaman->status === 'dipinjam' && $peminjaman->hari_terlambat > 0)
                <strong style="color:#721c24;">Terlambat {{ $peminjaman->hari_terlambat }} hari</strong>
            @elseif($peminjaman->status === 'dipinjam')
                <strong style="color:#856404;">Sedang Dipinjam</strong>
            @else
                <strong style="color:#155724;">Sudah Dikembalikan</strong>
            @endif
        </td>
    </tr>
</table>

<div class="section-title">Informasi Denda</div>
@if($peminjaman->denda > 0)
<div class="denda-box">
    <div>Keterlambatan: <strong>{{ $peminjaman->hari_terlambat }} hari</strong> × Rp 5.000/hari</div>
    <div class="nominal">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</div>
</div>
@else
<table class="info">
    <tr><td>Keterlambatan</td><td>-</td></tr>
    <tr><td>Total Denda</td><td><strong style="color:#155724;">Tidak ada denda</strong></td></tr>
</table>
@endif

<div class="footer">
    Dokumen ini dicetak secara otomatis oleh Sistem Perpustakaan Digital
</div>

</body>
</html>
