<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            color: #2c2c2c;
            background: #fff;
        }

        /* ===== KEPALA / HEADER ===== */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #5a4a2f;
            padding-bottom: 12px;
            margin-bottom: 6px;
        }
        .kop-surat .logo {
            width: 70px;
            height: 70px;
            margin-right: 16px;
            object-fit: contain;
        }
        .kop-surat .logo-placeholder {
            width: 70px;
            height: 70px;
            border: 2px solid #5a4a2f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #5a4a2f;
            border-radius: 6px;
            margin-right: 16px;
            flex-shrink: 0;
        }
        .kop-surat .kop-text {
            flex: 1;
            text-align: center;
        }
        .kop-surat .kop-text .nama-instansi {
            font-size: 16px;
            font-weight: 700;
            color: #5a4a2f;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .kop-surat .kop-text .sub-instansi {
            font-size: 11px;
            color: #555;
            margin-top: 2px;
        }
        .kop-surat .kop-text .alamat {
            font-size: 10px;
            color: #777;
            margin-top: 2px;
        }

        /* ===== JUDUL LAPORAN ===== */
        .judul-laporan {
            text-align: center;
            margin: 14px 0 4px;
        }
        .judul-laporan h2 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #2c2c2c;
        }
        .judul-laporan .periode {
            font-size: 10px;
            color: #555;
            margin-top: 2px;
        }
        .garis-bawah-judul {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }

        /* ===== INFO PETUGAS ===== */
        .info-petugas {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #555;
            margin-bottom: 10px;
        }

        /* ===== RINGKASAN ===== */
        .ringkasan {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }
        .ringkasan-item {
            flex: 1;
            border: 1px solid #e0d5c5;
            border-radius: 6px;
            padding: 8px 10px;
            background: #faf7f2;
            text-align: center;
        }
        .ringkasan-item .label {
            font-size: 9px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .ringkasan-item .nilai {
            font-size: 14px;
            font-weight: 700;
            color: #5a4a2f;
            margin-top: 2px;
        }
        .ringkasan-item.denda .nilai {
            color: #c0392b;
        }

        /* ===== KETENTUAN DENDA ===== */
        .ketentuan {
            background: #fef9ec;
            border: 1px solid #f0c04d;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 9.5px;
            color: #6d5700;
            margin-bottom: 10px;
        }

        /* ===== TABEL ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        thead tr {
            background-color: #5a4a2f;
            color: #fff;
        }
        thead th {
            padding: 7px 6px;
            text-align: center;
            font-weight: 600;
            font-size: 10px;
        }
        tbody tr:nth-child(even) {
            background-color: #faf7f2;
        }
        tbody tr:nth-child(odd) {
            background-color: #fff;
        }
        tbody td {
            padding: 6px 6px;
            border-bottom: 1px solid #ede8df;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }

        .badge-dipinjam {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
            white-space: nowrap;
        }
        .badge-kembali {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
            white-space: nowrap;
        }
        .badge-hilang {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
            white-space: nowrap;
        }
        .badge-rusak {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
            white-space: nowrap;
        }

        .denda-merah { color: #c0392b; font-weight: 700; }
        .jt-merah    { color: #e67e22; font-weight: 600; }
        .jt-hijau    { color: #27ae60; font-weight: 600; }

        /* ===== TFOOT TOTAL ===== */
        tfoot tr td {
            background: #f0e8d8;
            font-weight: 700;
            padding: 7px 6px;
            border-top: 2px solid #5a4a2f;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }
        .ttd-box {
            text-align: center;
            width: 180px;
        }
        .ttd-box .tempat-tanggal {
            font-size: 10px;
            margin-bottom: 50px;
        }
        .ttd-box .nama-ttd {
            border-top: 1px solid #333;
            padding-top: 4px;
            font-size: 10px;
            font-weight: 600;
        }
        .ttd-box .jabatan-ttd {
            font-size: 9px;
            color: #666;
        }

        /* ===== FOOTER HALAMAN ===== */
        .footer-cetak {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            padding-top: 6px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #999;
        }

        /* ===== PRINT ===== */
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            @page {
                size: A4 landscape;
                margin: 15mm 12mm;
            }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
        }
    </style>
</head>
<body>

{{-- Tombol cetak (tidak tampil saat print) --}}
<div class="no-print" style="text-align:right; padding: 10px 20px; background:#f8f9fa; border-bottom:1px solid #ddd;">
    <button onclick="window.print()" style="background:#c0392b; color:#fff; border:none; padding:8px 20px; border-radius:4px; cursor:pointer; font-size:12px; font-weight:600;">
        &#128438; Cetak / Simpan PDF
    </button>
    <a href="{{ route('kepala.laporan') }}" style="margin-left:8px; background:#6c757d; color:#fff; border:none; padding:8px 16px; border-radius:4px; cursor:pointer; font-size:12px; text-decoration:none;">
        &#8592; Kembali
    </a>
</div>

<div style="padding: 20px 24px;">

    {{-- ===== KOP SURAT ===== --}}
    <div class="kop-surat">
        <div class="logo-placeholder">&#128218;</div>
        <div class="kop-text">
            <div class="nama-instansi">Perpustakaan Sekolah</div>
            {{-- Ganti sesuai nama sekolah Anda --}}
            <div class="sub-instansi">SMA / SMK / SD / SMP Negeri / Swasta ...</div>
            <div class="alamat">Jl. Contoh No. 1, Kota, Provinsi | Telp. (000) 000-0000 | Email: perpus@sekolah.sch.id</div>
        </div>
    </div>

    {{-- ===== JUDUL ===== --}}
    <div class="judul-laporan">
        <h2>Laporan Data Peminjaman Buku</h2>
        <div class="periode">
            @if(request('dari') && request('sampai'))
                Periode: {{ \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') }}
            @elseif(request('dari'))
                Per Tanggal: {{ \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') }} s/d Sekarang
            @else
                Per Tanggal: {{ now()->format('d/m/Y') }}
            @endif
        </div>
    </div>
    <div class="garis-bawah-judul"></div>

    {{-- ===== INFO PETUGAS ===== --}}
    <div class="info-petugas">
        <span>Dicetak oleh: <strong>{{ auth()->user()->name ?? 'Petugas' }}</strong> ({{ auth()->user()->role ?? 'Petugas' }})</span>
        <span>Tanggal Cetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
    </div>

    {{-- ===== RINGKASAN ===== --}}
    @php
        $totalDenda  = 0;
        foreach ($data as $p) {
            $totalDenda += $p->denda ?? 0;
        }
    @endphp

    <div class="ringkasan">
        <div class="ringkasan-item">
            <div class="label">Total Peminjaman</div>
            <div class="nilai">{{ count($data) }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">Sedang Dipinjam</div>
            <div class="nilai">{{ collect($data)->whereIn('status',['dipinjam'])->count() }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">Dikembalikan</div>
            <div class="nilai">{{ collect($data)->whereIn('status',['mengembalikan','dikembalikan'])->count() }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">Buku Hilang</div>
            <div class="nilai">{{ collect($data)->where('status','hilang')->count() }}</div>
        </div>
        <div class="ringkasan-item">
            <div class="label">Buku Rusak</div>
            <div class="nilai">{{ collect($data)->where('status','rusak')->count() }}</div>
        </div>
        <div class="ringkasan-item denda">
            <div class="label">Total Denda</div>
            <div class="nilai">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- ===== KETENTUAN ===== --}}
    <div class="ketentuan">
        <strong>Ketentuan Denda:</strong>
        &nbsp; Buku Hilang: <strong>Rp 50.000</strong>
        &nbsp;|&nbsp; Buku Rusak: <strong>Rp 20.000</strong>
        &nbsp;|&nbsp; Keterlambatan: <strong>Rp 2.000/hari</strong>
    </div>

    {{-- ===== TABEL PEMINJAMAN ===== --}}
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Nama Anggota</th>
                <th width="18%">Judul Buku</th>
                <th width="10%">Tgl Pinjam</th>
                <th width="12%">Tgl Jatuh Tempo</th>
                <th width="10%">Tgl Kembali</th>
                <th width="12%">Status</th>
                <th width="10%">Keterangan Denda</th>
                <th width="9%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($data as $p)
                @php
                    $denda = $p->denda ?? 0;
                    $ketDenda = '-';
                    $hariTerlambat = $p->hari_terlambat ?? 0;
                    $dendaKondisi = $p->denda_kondisi ?? 0;

                    if ($dendaKondisi == 50000) {
                        $ketDenda = 'Buku hilang';
                    } elseif ($dendaKondisi == 20000) {
                        $ketDenda = 'Buku rusak';
                    }
                    
                    if ($hariTerlambat > 0) {
                        $ketDenda = ($ketDenda != '-' ? $ketDenda . ' + ' : '') . "Telat {$hariTerlambat} hari";
                    }

                    $jatuhTempoClass = 'jt-hijau';
                    if ($p->tgl_jatuh_tempo && strtolower($p->status) === 'dipinjam' && \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->isPast()) {
                        $jatuhTempoClass = 'jt-merah';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $p->anggota->name ?? '-' }}</td>
                    <td>{{ $p->judul_buku ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td class="text-center {{ $jatuhTempoClass }}">
                        {{ $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center" style="color:#777;">
                        {{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">
                        @php
                            $statusMap = [
                                'dipinjam' => ['label' => 'Dipinjam', 'class' => 'badge-dipinjam'],
                                'mengembalikan' => ['label' => '⏳ Mengembalikan', 'class' => 'badge-kembali'],
                                'dikembalikan' => ['label' => '✓ Dikembalikan', 'class' => 'badge-kembali'],
                                'hilang' => ['label' => '📕 Hilang', 'class' => 'badge-hilang'],
                                'rusak' => ['label' => '📙 Rusak', 'class' => 'badge-rusak'],
                                'terlambat' => ['label' => '⚠ Terlambat', 'class' => 'badge-hilang'],
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
                            
                            $display = $statusMap[$displayStatus] ?? ['label' => $p->status, 'class' => ''];
                        @endphp
                        <span class="{{ $display['class'] }}">{{ $display['label'] }}</span>
                    </td>
                    <td class="text-center" style="font-size:9px; color:#666;">{{ $ketDenda }}</td>
                    <td class="text-right {{ $denda > 0 ? 'denda-merah' : '' }}">
                        {{ $denda > 0 ? 'Rp ' . number_format($denda, 0, ',', '.') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:16px; color:#999;">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="text-right" style="text-align:right; padding-right:10px;">Total Denda Keseluruhan:</td>
                <td class="text-right denda-merah">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- ===== TANDA TANGAN ===== --}}
    <div class="ttd-section">
        <div class="ttd-box">
            <div class="tempat-tanggal">
                ............., {{ now()->isoFormat('D MMMM Y') }}
                <br>Petugas Perpustakaan,
            </div>
            <div class="nama-ttd">( {{ auth()->user()->name ?? '..............................' }} )</div>
            <div class="jabatan-ttd">{{ auth()->user()->role ?? 'Petugas' }}</div>
        </div>
    </div>

    {{-- ===== FOOTER ===== --}}
    <div class="footer-cetak">
        <span>Sistem Informasi Perpustakaan</span>
        <span>Dicetak pada: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
    </div>

</div>{{-- end padding --}}

<script>
    // Auto print jika ada parameter ?autoprint=1
    const params = new URLSearchParams(window.location.search);
    if (params.get('autoprint') === '1') {
        window.onload = () => window.print();
    }
</script>

</body>
</html>