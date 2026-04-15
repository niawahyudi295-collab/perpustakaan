@extends('Kepala.layouts')

@section('title', 'Laporan Peminjaman')
@section('header', 'LAPORAN PEMINJAMAN')

@section('content')

@php
    $totalDenda = 0;
    foreach ($data as $p) {
        $totalDenda += $p->denda ?? 0;
    }
@endphp

<style>
.stat-card {
    background: white;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(200, 168, 80, 0.15);
    border-left: 5px solid #C8A850;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(200, 168, 80, 0.25);
}
.stat-card.danger { border-left-color: #e74c3c; box-shadow: 0 2px 10px rgba(200, 100, 80, 0.15); }
.stat-card.danger:hover { box-shadow: 0 4px 15px rgba(200, 100, 80, 0.25); }

.data-table {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
}

.table-header {
    background: linear-gradient(135deg, #382e2e, #504840);
    color: white;
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.data-row {
    border-bottom: 1px solid #f5f5f5;
    transition: background-color 0.2s ease;
}
.data-row:hover { background-color: #fafaf9; }

.action-btn {
    background: linear-gradient(135deg, #C8A850, #dca47d);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}
.action-btn:hover {
    background: linear-gradient(135deg, #dca47d, #C8A850);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

.denda-badge {
    background: #f8d7da;
    color: #721c24;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-print {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}
.btn-print:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    transform: translateY(-2px);
    color: white;
}
</style>

{{-- Title & Action --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
        <div style="font-size: 12px; color: #967830; text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Data Peminjaman</div>
        <div style="font-size: 24px; font-weight: bold; color: #382e2e;">Laporan Semua Peminjaman Buku</div>
    </div>
    <a href="{{ route('kepala.laporan.cetak.pdf') }}" target="_blank" class="btn-print">
        📄 Cetak PDF Semua
    </a>
</div>

{{-- Stats Cards --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="stat-card">
        <div style="font-size: 11px; color: #504840; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600;">Total Peminjaman</div>
        <div style="font-size: 32px; font-weight: bold; color: #C8A850;">{{ count($data) }}</div>
        <div style="font-size: 11px; color: #504840; margin-top: 4px; opacity: 0.7;">transaksi terdaftar</div>
    </div>

    <div class="stat-card">
        <div style="font-size: 11px; color: #504840; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600;">Sedang Dipinjam</div>
        <div style="font-size: 32px; font-weight: bold; color: #f39c12;">{{ collect($data)->where('status','dipinjam')->count() }}</div>
        <div style="font-size: 11px; color: #504840; margin-top: 4px; opacity: 0.7;">aktif sedang dipinjam</div>
    </div>

    <div class="stat-card">
        <div style="font-size: 11px; color: #504840; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600;">Sudah Dikembalikan</div>
        <div style="font-size: 32px; font-weight: bold; color: #27ae60;">{{ collect($data)->where('status','dikembalikan')->count() + collect($data)->where('status','mengembalikan')->count() }}</div>
        <div style="font-size: 11px; color: #504840; margin-top: 4px; opacity: 0.7;">selesai dikembalikan</div>
    </div>

    <div class="stat-card danger">
        <div style="font-size: 11px; color: #504840; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; font-weight: 600;">Total Denda Keseluruhan</div>
        <div style="font-size: 32px; font-weight: bold; color: #e74c3c;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        <div style="font-size: 11px; color: #504840; margin-top: 4px; opacity: 0.7;">akumulasi denda</div>
    </div>
</div>

{{-- Info Box --}}
<div style="background: linear-gradient(135deg, #fef9ec, #fffaf0); border-left: 4px solid #f39c12; border-radius: 8px; padding: 14px 16px; margin-bottom: 20px;">
    <div style="font-size: 12px; color: #6d5700; line-height: 1.6;">
        <strong>📌 Ketentuan Denda:</strong> Buku Hilang <strong>Rp 50.000</strong> • Buku Rusak <strong>Rp 20.000</strong> • Terlambat <strong>Rp 2.000/hari</strong>
    </div>
</div>

{{-- Data Table --}}
<div class="data-table">
    <div style="padding: 20px 24px; border-bottom: 1px solid #e0d5c5;">
        <div style="font-size: 14px; font-weight: bold; color: #382e2e;">📋 Daftar Peminjaman</div>
        <div style="font-size: 12px; color: #999; margin-top: 4px;">Total: {{ count($data) }} data</div>
    </div>

    @if(count($data) > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead class="table-header">
                <tr>
                    <th style="padding: 12px; text-align: center;">No</th>
                    <th style="padding: 12px; text-align: left;">Nama Anggota</th>
                    <th style="padding: 12px; text-align: left;">Judul Buku</th>
                    <th style="padding: 12px; text-align: center;">Tgl Pinjam</th>
                    <th style="padding: 12px; text-align: center;">Jatuh Tempo</th>
                    <th style="padding: 12px; text-align: center;">Tgl Kembali</th>
                    <th style="padding: 12px; text-align: center;">Status</th>
                    <th style="padding: 12px; text-align: right;">Denda</th>
                    <th style="padding: 12px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $p)
                <tr class="data-row">
                    <td style="padding: 12px; text-align: center; font-weight: 600; color: #967830;">{{ $index + 1 }}</td>
                    <td style="padding: 12px;">
                        <div style="font-weight: 600; color: #382e2e;">{{ $p->anggota->name ?? '-' }}</div>
                        <div style="font-size: 11px; color: #999;">ID: {{ $p->anggota_id }}</div>
                    </td>
                    <td style="padding: 12px;">
                        <div style="font-weight: 600; color: #382e2e; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $p->judul_buku ?? '-' }}</div>
                    </td>
                    <td style="padding: 12px; text-align: center; font-size: 12px;">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td style="padding: 12px; text-align: center; font-size: 12px; font-weight: 600; color: {{ \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->isPast() && $p->status === 'dipinjam' ? '#e74c3c' : '#27ae60' }};">
                        {{ $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="padding: 12px; text-align: center; font-size: 12px; color: #999;">
                        {{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        @php
                            $statusColors = [
                                'dipinjam' => ['bg' => '#fff3cd', 'text' => '#856404', 'label' => 'Dipinjam'],
                                'mengembalikan' => ['bg' => '#cce5ff', 'text' => '#004085', 'label' => 'Mengembalikan'],
                                'dikembalikan' => ['bg' => '#d4edda', 'text' => '#155724', 'label' => '✓ Dikembalikan'],
                                'hilang' => ['bg' => '#f8d7da', 'text' => '#721c24', 'label' => '📕 Buku Hilang'],
                                'rusak' => ['bg' => '#ffeaa7', 'text' => '#856400', 'label' => '📙 Buku Rusak'],
                                'terlambat' => ['bg' => '#f8d7da', 'text' => '#721c24', 'label' => '⚠️ Terlambat'],
                            ];
                            
                            // Tentukan status berdasarkan denda
                            if ($p->denda >= 50000) {
                                $displayStatus = 'hilang';
                            } elseif ($p->denda >= 20000) {
                                $displayStatus = 'rusak';
                            } elseif ($p->denda > 0) {
                                $displayStatus = 'terlambat';
                            } else {
                                $displayStatus = strtolower($p->status);
                            }
                            
                            $colors = $statusColors[$displayStatus] ?? ['bg' => '#e2e3e5', 'text' => '#383d41', 'label' => $p->status];
                        @endphp
                        <span style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">
                            {{ $colors['label'] }}
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        @if($p->denda > 0)
                            <div class="denda-badge">Rp {{ number_format($p->denda, 0, ',', '.') }}</div>
                            @if($p->hari_terlambat > 0)
                                <div style="font-size: 11px; color: #999; margin-top: 3px;">({{ $p->hari_terlambat }} hari)</div>
                            @endif
                        @else
                            <span style="color: #27ae60; font-weight: 600;">0</span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('kepala.laporan.detail', $p->id) }}" class="action-btn">
                            👁️ Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot style="background: linear-gradient(135deg, #fef9ec, #f5f0e8); border-top: 2px solid #C8A850;">
                <tr>
                    <td colspan="7" style="padding: 12px; text-align: right; font-weight: 600; color: #382e2e;">Total Denda Keseluruhan:</td>
                    <td style="padding: 12px; text-align: right; font-weight: 700; color: #e74c3c; font-size: 14px;">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    <div style="padding: 40px 20px; text-align: center; color: #999;">
        <div style="font-size: 48px; margin-bottom: 12px; opacity: 0.3;">📚</div>
        <div style="font-size: 14px;">Tidak ada data peminjaman</div>
    </div>
    @endif
</div>

@endsection