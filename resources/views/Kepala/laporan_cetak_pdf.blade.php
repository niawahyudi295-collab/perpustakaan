<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Buku</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; padding: 25px; }

        .header { text-align: center; border-bottom: 3px solid #8b5b5b; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; color: #a97b5f; margin-bottom: 3px; }
        .header p { font-size: 11px; color: #777; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background-color: #b5887b; color: white; }
        th { padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        tbody tr:nth-child(even) { background: #f9f0f6; }

        .badge { padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .badge-terlambat  { background: #f8d7da; color: #721c24; }
        .badge-dipinjam   { background: #fff3cd; color: #856404; }
        .badge-kembali    { background: #d4edda; color: #155724; }
        .badge-menunggu   { background: #cce5ff; color: #004085; }

        .denda { color: #967830; font-weight: bold; }

        .footer { margin-top: 25px; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; display: flex; justify-content: space-between; }

        .summary { margin-bottom: 15px; font-size: 11px; color: #555; }
        .summary span { font-weight: bold; color: #b58f7b; }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN PEMINJAMAN BUKU</h1>
    <p>Perpustakaan Digital &nbsp;|&nbsp; Dicetak: {{ now()->format('d F Y, H:i:s') }} WIB</p>
</div>

<div class="summary">
    Total Transaksi: <span>{{ $data->count() }}</span> &nbsp;|&nbsp;
    Sedang Dipinjam: <span>{{ $data->whereIn('status', ['dipinjam', 'mengembalikan'])->count() }}</span> &nbsp;|&nbsp;
    Dikembalikan: <span>{{ $data->where('status', 'dikembalikan')->count() }}</span> &nbsp;|&nbsp;
    Total Denda: <span>Rp {{ number_format($data->sum('denda'), 0, ',', '.') }}</span>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Jatuh Tempo</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Hari Terlambat</th>
            <th>Denda</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->anggota->name ?? '-' }}</td>
            <td>{{ $p->judul_buku }}</td>
            <td>{{ $p->tgl_pinjam ? \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') : '-' }}</td>
            <td>{{ $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}</td>
            <td>{{ $p->status === 'dikembalikan' && $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') : '-' }}</td>
            <td>
                @if($p->status === 'dipinjam' && $p->hari_terlambat > 0)
                    <span class="badge badge-terlambat">Terlambat</span>
                @elseif($p->status === 'dipinjam')
                    <span class="badge badge-dipinjam">Dipinjam</span>
                @elseif($p->status === 'mengembalikan')
                    <span class="badge badge-menunggu">Mengembalikan</span>
                @elseif($p->status === 'menunggu')
                    <span class="badge badge-menunggu">Menunggu</span>
                @else
                    <span class="badge badge-kembali">Dikembalikan</span>
                @endif
            </td>
            <td>{{ $p->hari_terlambat > 0 ? $p->hari_terlambat . ' hari' : '-' }}</td>
            <td class="{{ $p->denda > 0 ? 'denda' : '' }}">
                {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : '-' }}
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center; color:#999; padding:20px;">Belum ada data transaksi.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    <span>Sistem Perpustakaan Digital</span>
    <span>Dicetak oleh: {{ auth()->user()->name }} &nbsp;|&nbsp; {{ now()->format('d F Y, H:i:s') }} WIB</span>
</div>

</body>
</html>
