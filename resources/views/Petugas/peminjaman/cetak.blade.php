{{-- resources/views/petugas/peminjaman/cetak_struk.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Denda - {{ $peminjaman->anggota->name ?? '-' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #c9b99a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 30px 20px 60px;
            font-family: 'Share Tech Mono', monospace;
        }

        /* ===== TOMBOL AKSI (tidak ikut tercetak) ===== */
        .action-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
        }

        .btn-print {
            background: #3a2e24;
            color: #f5f0e8;
            border: none;
            padding: 11px 28px;
            border-radius: 6px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 14px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background 0.2s;
        }
        .btn-print:hover { background: #5a4a3a; }

        .btn-back {
            background: transparent;
            color: #3a2e24;
            border: 2px solid #3a2e24;
            padding: 11px 28px;
            border-radius: 6px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: 1px;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #3a2e24; color: #f5f0e8; }

        /* ===== STRUK ===== */
        .struk-wrap {
            position: relative;
        }

        /* efek sobek atas */
        .struk-tear-top {
            width: 320px;
            height: 18px;
            background: #faf6ef;
            clip-path: polygon(
                0% 100%, 3% 0%, 6% 100%, 9% 0%, 12% 100%,
                15% 0%, 18% 100%, 21% 0%, 24% 100%, 27% 0%,
                30% 100%, 33% 0%, 36% 100%, 39% 0%, 42% 100%,
                45% 0%, 48% 100%, 51% 0%, 54% 100%, 57% 0%,
                60% 100%, 63% 0%, 66% 100%, 69% 0%, 72% 100%,
                75% 0%, 78% 100%, 81% 0%, 84% 100%, 87% 0%,
                90% 100%, 93% 0%, 96% 100%, 100% 0%, 100% 100%
            );
        }

        .struk {
            width: 320px;
            background: #faf6ef;
            padding: 20px 24px 16px;
            position: relative;
        }

        /* efek sobek bawah */
        .struk-tear-bottom {
            width: 320px;
            height: 18px;
            background: #faf6ef;
            clip-path: polygon(
                0% 0%, 3% 100%, 6% 0%, 9% 100%, 12% 0%,
                15% 100%, 18% 0%, 21% 100%, 24% 0%, 27% 100%,
                30% 0%, 33% 100%, 36% 0%, 39% 100%, 42% 0%,
                45% 100%, 48% 0%, 51% 100%, 54% 0%, 57% 100%,
                60% 0%, 63% 100%, 66% 0%, 69% 100%, 72% 0%,
                75% 100%, 78% 0%, 81% 100%, 84% 0%, 87% 100%,
                90% 0%, 93% 100%, 96% 0%, 100% 100%, 100% 0%
            );
        }

        /* Header perpustakaan */
        .struk-header {
            text-align: center;
            border-bottom: 1px dashed #b0a090;
            padding-bottom: 14px;
            margin-bottom: 14px;
        }

        .struk-header .lib-name {
            font-family: 'Noto Serif', serif;
            font-size: 15px;
            font-weight: 700;
            color: #2a2018;
            letter-spacing: 1px;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .struk-header .lib-sub {
            font-size: 10px;
            color: #7a6a58;
            margin-top: 3px;
            letter-spacing: 0.5px;
        }

        .struk-header .struk-title {
            margin-top: 10px;
            font-size: 11px;
            color: #5a4a38;
            border: 1px solid #c0b09a;
            display: inline-block;
            padding: 2px 12px;
            letter-spacing: 2px;
        }

        /* Info baris */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            font-size: 11px;
            color: #4a3c2e;
            margin-bottom: 5px;
            line-height: 1.5;
        }

        .info-row .label { color: #8a7a68; flex-shrink: 0; }
        .info-row .value { text-align: right; max-width: 170px; word-break: break-word; }

        .divider {
            border: none;
            border-top: 1px dashed #b0a090;
            margin: 12px 0;
        }

        .divider-solid {
            border: none;
            border-top: 1px solid #c0b09a;
            margin: 12px 0;
        }

        /* Kondisi badge */
        .kondisi-badge {
            display: inline-block;
            font-size: 10px;
            padding: 1px 8px;
            border-radius: 3px;
            font-family: 'Share Tech Mono', monospace;
        }
        .kondisi-hilang  { background: #f8d7da; color: #721c24; }
        .kondisi-rusak   { background: #fff3cd; color: #856404; }
        .kondisi-telat   { background: #d1ecf1; color: #0c5460; }
        .kondisi-baik    { background: #d4edda; color: #155724; }

        /* Total denda - bagian paling penting */
        .total-section {
            background: #2a2018;
            color: #f5f0e8;
            margin: 0 -24px;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-section .total-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c9b99a;
        }

        .total-section .total-amount {
            font-family: 'Noto Serif', serif;
            font-size: 20px;
            font-weight: 700;
            color: #f5f0e8;
        }

        .total-section .total-amount.zero {
            color: #6dbf8f;
        }

        /* Footer struk */
        .struk-footer {
            text-align: center;
            margin-top: 14px;
            font-size: 10px;
            color: #9a8a78;
            line-height: 1.8;
        }

        .struk-footer .ttd-area {
            margin-top: 14px;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #7a6a58;
        }

        .struk-footer .ttd-area .ttd-box {
            text-align: center;
            width: 100px;
        }

        .struk-footer .ttd-area .ttd-line {
            border-bottom: 1px solid #b0a090;
            height: 40px;
            margin-bottom: 4px;
        }

        /* Nomor struk */
        .no-struk {
            font-size: 9px;
            color: #b0a090;
            text-align: center;
            margin-top: 10px;
            letter-spacing: 1px;
        }

        /* ===== PRINT MODE ===== */
        @media print {
            body {
                background: white;
                padding: 0;
                justify-content: flex-start;
            }

            .action-bar { display: none !important; }

            .struk-wrap {
                margin: 0 auto;
            }

            .struk-tear-top,
            .struk-tear-bottom {
                display: none;
            }

            .struk {
                box-shadow: none;
                border-top: 2px dashed #999;
                border-bottom: 2px dashed #999;
            }

            @page {
                size: 80mm auto;
                margin: 5mm;
            }
        }
    </style>
</head>
<body>

    {{-- Tombol aksi (tidak ikut cetak) --}}
    <div class="action-bar">
        <a href="{{ route('petugas.peminjaman') }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
    </div>

    {{-- STRUK --}}
    <div class="struk-wrap">

        {{-- Sobek atas --}}
        <div class="struk-tear-top"></div>

        <div class="struk">

            {{-- Header --}}
            <div class="struk-header">
                <div class="lib-name">Perpustakaan</div>
                <div class="lib-sub">Sistem Informasi Perpustakaan</div>
                <div class="struk-title">KWITANSI DENDA</div>
            </div>

            {{-- Info Struk --}}
            <div class="info-row">
                <span class="label">No. Struk</span>
                <span class="value">#{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tgl Cetak</span>
                <span class="value">{{ now()->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Petugas</span>
                <span class="value">{{ Auth::user()->name ?? '-' }}</span>
            </div>

            <hr class="divider">

            {{-- Info Anggota --}}
            <div class="info-row">
                <span class="label">Nama</span>
                <span class="value">{{ $peminjaman->anggota->name ?? '-' }}</span>
            </div>
            @if(isset($peminjaman->anggota->phone_number) && $peminjaman->anggota->phone_number)
            <div class="info-row">
                <span class="label">No. HP</span>
                <span class="value">{{ $peminjaman->anggota->phone_number }}</span>
            </div>
            @endif

            <hr class="divider">

            {{-- Info Buku --}}
            <div class="info-row">
                <span class="label">Judul Buku</span>
                <span class="value">{{ $peminjaman->judul_buku }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tgl Pinjam</span>
                <span class="value">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Jatuh Tempo</span>
                <span class="value">{{ $peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tgl Kembali</span>
                <span class="value">{{ $peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d/m/Y') : '-' }}</span>
            </div>

            <hr class="divider">

            {{-- Rincian Denda --}}
            @php
                $kondisi        = $peminjaman->kondisi ?? 'baik';
                $totalDenda     = $peminjaman->denda ?? 0;

                // Hitung komponen denda telat
                $dendaKondisi = 0;
                if ($kondisi === 'hilang')      $dendaKondisi = 50000;
                elseif ($kondisi === 'rusak')   $dendaKondisi = 20000;

                $dendaTelat = max(0, $totalDenda - $dendaKondisi);
                $hariTelat  = $dendaTelat > 0 ? (int)($dendaTelat / 2000) : 0;
            @endphp

            <div style="font-size:10px; color:#8a7a68; letter-spacing:1px; margin-bottom:8px;">RINCIAN DENDA</div>

            @if($hariTelat > 0)
            <div class="info-row">
                <span class="label">Telat {{ $hariTelat }} hari</span>
                <span class="value">Rp {{ number_format($dendaTelat, 0, ',', '.') }}</span>
            </div>
            <div class="info-row" style="font-size:10px;">
                <span class="label" style="color:#b0a090;">({{ $hariTelat }} × Rp 2.000)</span>
                <span class="value">
                    <span class="kondisi-badge kondisi-telat">TERLAMBAT</span>
                </span>
            </div>
            @endif

            @if($kondisi === 'rusak')
            <div class="info-row">
                <span class="label">Kerusakan buku</span>
                <span class="value">Rp 20.000</span>
            </div>
            <div class="info-row" style="justify-content:flex-end;">
                <span class="kondisi-badge kondisi-rusak">BUKU RUSAK</span>
            </div>
            @elseif($kondisi === 'hilang')
            <div class="info-row">
                <span class="label">Kehilangan buku</span>
                <span class="value">Rp 50.000</span>
            </div>
            <div class="info-row" style="justify-content:flex-end;">
                <span class="kondisi-badge kondisi-hilang">BUKU HILANG</span>
            </div>
            @endif

            @if($hariTelat === 0 && $kondisi === 'baik')
            <div class="info-row">
                <span class="label">Tidak ada denda</span>
                <span class="value">-</span>
            </div>
            @endif

            <hr class="divider-solid">

            {{-- TOTAL --}}
            <div class="total-section">
                <span class="total-label">Total Denda</span>
                <span class="total-amount {{ $totalDenda == 0 ? 'zero' : '' }}">
                    {{ $totalDenda > 0 ? 'Rp '.number_format($totalDenda, 0, ',', '.') : 'Rp 0' }}
                </span>
            </div>

            {{-- Status lunas/belum --}}
            <div style="text-align:center; margin-top:12px; font-size:10px; color:#7a6a58;">
                @if($totalDenda == 0)
                    <span style="color:#2d8a5e; font-size:12px; letter-spacing:1px;">✓ TIDAK ADA DENDA</span>
                @else
                    <span style="color:#9a3a2a; font-size:12px; letter-spacing:1px;">⚠ HARAP SEGERA DILUNASI</span>
                @endif
            </div>

            {{-- TTD Area --}}
            <div class="struk-footer">
                <div class="ttd-area">
                    <div class="ttd-box">
                        <div class="ttd-line"></div>
                        <div>Anggota</div>
                    </div>
                    <div class="ttd-box">
                        <div class="ttd-line"></div>
                        <div>Petugas</div>
                    </div>
                </div>

                <div class="no-struk">
                    *** STRUK INI SEBAGAI BUKTI RESMI ***<br>
                    Dicetak: {{ now()->format('d/m/Y H:i:s') }}
                </div>
            </div>

        </div>

        {{-- Sobek bawah --}}
        <div class="struk-tear-bottom"></div>

    </div>

</body>
</html>