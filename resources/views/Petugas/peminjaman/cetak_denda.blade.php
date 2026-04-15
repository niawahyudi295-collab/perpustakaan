{{-- resources/views/petugas/peminjaman/cetak_denda.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Denda - {{ $peminjaman->anggota->name ?? '-' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0ebe5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 20px 10px 30px;
            font-family: 'Roboto', sans-serif;
        }

        /* ===== TOMBOL AKSI ===== */
        .action-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #8b6f47;
            color: #fff;
        }
        .btn-print:hover {
            background: #6b5537;
        }

        .btn-back {
            background: transparent;
            color: #8b6f47;
            border: 2px solid #8b6f47;
        }
        .btn-back:hover {
            background: #8b6f47;
            color: #fff;
        }

        /* ===== CONTAINER STRUK KECIL ===== */
        .struk-container {
            width: 280px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 0 auto;
        }

        .struk {
            padding: 15px 12px;
            font-size: 12px;
            color: #2a2520;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            border-bottom: 2px solid #d0a080;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .header .title {
            font-size: 14px;
            font-weight: 700;
            color: #3a2820;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header .subtitle {
            font-size: 10px;
            color: #8a7860;
            margin-top: 3px;
        }

        /* ===== INFO ROWS ===== */
        .info-section {
            margin-bottom: 12px;
        }

        .info-section .section-title {
            font-size: 10px;
            color: #9a8a70;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            font-weight: 600;
            border-bottom: 1px dashed #d0a080;
            padding-bottom: 4px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .label {
            color: #7a6a50;
            flex-shrink: 0;
        }

        .value {
            text-align: right;
            font-weight: 500;
            color: #2a2520;
            max-width: 140px;
            word-break: break-word;
        }

        /* ===== RINCIAN DENDA ===== */
        .denda-section {
            background: #f9f6f0;
            border: 1px solid #e0d0c0;
            border-radius: 4px;
            padding: 10px;
            margin: 12px 0;
        }

        .denda-item {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .denda-item .label {
            color: #6a5a40;
        }

        .denda-item .value {
            font-weight: 600;
            color: #8b4513;
        }

        /* ===== TOTAL DENDA ===== */
        .total-section {
            background: #3a2820;
            color: #f5f0e8;
            padding: 10px 12px;
            margin: 12px -12px 0;
            text-align: center;
            border-top: 2px solid #d0a080;
        }

        .total-label {
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #d0a080;
            margin-bottom: 4px;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #f5f0e8;
            font-family: 'Courier Prime', monospace;
        }

        .total-amount.zero {
            color: #6dbf8f;
            font-size: 18px;
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-block;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-telat {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-rusak {
            background: #fff3cd;
            color: #856404;
        }

        .badge-hilang {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-baik {
            background: #d4edda;
            color: #155724;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed #d0a080;
            font-size: 9px;
            color: #9a8a70;
            line-height: 1.6;
        }

        .no-struk {
            font-size: 9px;
            color: #b0a090;
            text-align: center;
            margin-top: 8px;
            letter-spacing: 0.5px;
            font-family: 'Courier Prime', monospace;
        }

        /* ===== PRINT MODE ===== */
        @media print {
            body {
                background: white;
                padding: 0;
                min-height: auto;
            }

            .action-bar {
                display: none !important;
            }

            .struk-container {
                width: 100%;
                box-shadow: none;
                margin: 0;
            }

            .struk {
                padding: 8mm 6mm;
            }

            @page {
                size: 80mm 100mm;
                margin: 0;
                padding: 0;
            }

            /* Untuk kertas A6 ukuran kecil */
            @media print and (prefers-color-scheme: light) {
                .struk-container {
                    width: 100%;
                }
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 320px) {
            .struk {
                font-size: 11px;
            }

            .info-row,
            .denda-item {
                font-size: 10px;
            }

            .total-amount {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

    {{-- Tombol aksi --}}
    <div class="action-bar">
        <a href="{{ route('petugas.peminjaman') }}" class="btn btn-back">← Kembali</a>
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak</button>
    </div>

    {{-- STRUK DENDA KECIL --}}
    <div class="struk-container">
        <div class="struk">

            {{-- Header --}}
            <div class="header">
                <div class="title">KWI. DENDA</div>
                <div class="subtitle">Perpustakaan</div>
            </div>

            {{-- Info Cetak --}}
            <div class="info-section">
                <div class="info-row">
                    <span class="label">No:</span>
                    <span class="value">#{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tgl:</span>
                    <span class="value">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            {{-- Info Anggota --}}
            <div class="info-section">
                <div class="section-title">Anggota</div>
                <div class="info-row">
                    <span class="label">Nama:</span>
                    <span class="value">{{ $peminjaman->anggota->name ?? '-' }}</span>
                </div>
            </div>

            {{-- Info Buku & Tanggal --}}
            <div class="info-section">
                <div class="section-title">Buku</div>
                <div class="info-row">
                    <span class="label">Judul:</span>
                    <span class="value">{{ $peminjaman->judul_buku }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Pinjam:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Tempo:</span>
                    <span class="value">{{ $peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Kembali:</span>
                    <span class="value">{{ $peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d/m/Y') : '-' }}</span>
                </div>
            </div>

            {{-- Rincian Denda --}}
            @php
                $totalDenda = $peminjaman->denda ?? 0;
                
                // Hitung komponen denda berdasarkan nilai total denda:
                // - Rp 50.000 → Buku HILANG
                // - Rp 20.000 → Buku RUSAK
                // - Rp 2.000/hari → Terlambat
                
                $dendaHilang  = 0;
                $dendaRusak   = 0;
                $dendaTelat   = 0;
                $hariTelat    = 0;
                
                if ($totalDenda >= 50000) {
                    // Buku hilang
                    $dendaHilang = 50000;
                    $sisaDenda = $totalDenda - 50000;
                    
                    // Cek apakah ada denda terlambat juga
                    if ($sisaDenda > 0) {
                        $dendaTelat = $sisaDenda;
                        $hariTelat = (int)($sisaDenda / 2000);
                    }
                } elseif ($totalDenda >= 20000) {
                    // Buku rusak
                    $dendaRusak = 20000;
                    $sisaDenda = $totalDenda - 20000;
                    
                    // Cek apakah ada denda terlambat juga
                    if ($sisaDenda > 0) {
                        $dendaTelat = $sisaDenda;
                        $hariTelat = (int)($sisaDenda / 2000);
                    }
                } else {
                    // Hanya terlambat
                    $dendaTelat = $totalDenda;
                    $hariTelat = $totalDenda > 0 ? (int)($totalDenda / 2000) : 0;
                }
            @endphp

            <div class="denda-section">
                <div style="font-size: 10px; color: #6a5a40; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; border-bottom: 1px dashed #d0a080; padding-bottom: 6px;">
                    Rincian Denda
                </div>

                @if($dendaHilang > 0)
                    <div class="denda-item">
                        <span class="label">Kehilangan Buku</span>
                        <span class="value">Rp {{ number_format($dendaHilang, 0, ',', '.') }}</span>
                    </div>
                    <div style="font-size: 9px; margin-bottom: 6px; margin-left: 2px;">
                        <span class="badge badge-hilang">HILANG</span>
                    </div>
                @elseif($dendaRusak > 0)
                    <div class="denda-item">
                        <span class="label">Kerusakan Buku</span>
                        <span class="value">Rp {{ number_format($dendaRusak, 0, ',', '.') }}</span>
                    </div>
                    <div style="font-size: 9px; margin-bottom: 6px; margin-left: 2px;">
                        <span class="badge badge-rusak">RUSAK</span>
                    </div>
                @endif

                @if($dendaTelat > 0)
                    <div class="denda-item">
                        <span class="label">Terlambat {{ $hariTelat }} hari</span>
                        <span class="value">Rp {{ number_format($dendaTelat, 0, ',', '.') }}</span>
                    </div>
                    <div style="font-size: 9px; color: #8a7a60; margin-bottom: 6px; margin-left: 2px;">
                        ({{ $hariTelat }} × Rp 2.000) <span class="badge badge-telat">TELAT</span>
                    </div>
                @endif

                @if($totalDenda === 0)
                    <div style="text-align: center; color: #6a5a40; font-size: 10px; padding: 6px 0;">
                        ✓ Tidak ada denda
                        <br>
                        <span class="badge badge-baik">BAIK</span>
                    </div>
                @endif
            </div>

            {{-- Total Denda --}}
            <div class="total-section">
                <div class="total-label">Total Bayar</div>
                @if($totalDenda > 0)
                    <div class="total-amount">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                @else
                    <div class="total-amount zero">GRATIS</div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="footer">
                <div>Petugas: {{ Auth::user()->name ?? '-' }}</div>
                <div style="margin-top: 4px; font-size: 8px; color: #b0a090;">
                    Perpustakaan Digital {{ now()->format('Y') }}
                </div>
            </div>

            <div class="no-struk">
                {{ now()->format('YmdHis') }}-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}
            </div>

        </div>
    </div>

</body>
</html>
