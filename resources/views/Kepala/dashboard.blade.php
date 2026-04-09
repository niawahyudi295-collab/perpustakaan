@extends('Kepala.layouts')

@section('title', 'Dashboard')
@section('header', 'DASHBOARD')

@section('content')

{{-- Greeting --}}
<div style="background: linear-gradient(135deg, #b57ba6, #d4a0c7); border-radius:16px; padding:24px 30px; margin-bottom:24px; color:white; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <div style="font-size:22px; font-weight:bold; margin-bottom:4px;">Halo, {{ Auth::user()->name }}! 👋</div>
        <div style="font-size:13px; opacity:0.9;">{{ now()->format('l, d F Y') }} &nbsp;|&nbsp; Panel Kepala Perpustakaan</div>
    </div>
    <div style="font-size:60px; opacity:0.3;">🏛️</div>
</div>

{{-- Stat Cards --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(181,123,166,0.15); border-left:5px solid #b57ba6;">
        <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Total Anggota</div>
        <div style="font-size:36px; font-weight:bold; color:#b57ba6;">{{ $totalAnggota }}</div>
        <div style="font-size:11px; color:#bbb; margin-top:4px;">anggota terdaftar</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(0,188,212,0.15); border-left:5px solid #00bcd4;">
        <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Total Petugas</div>
        <div style="font-size:36px; font-weight:bold; color:#00bcd4;">{{ $totalPetugas }}</div>
        <div style="font-size:11px; color:#bbb; margin-top:4px;">petugas aktif</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(76,175,80,0.15); border-left:5px solid #4caf50;">
        <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Total Buku</div>
        <div style="font-size:36px; font-weight:bold; color:#4caf50;">{{ $totalBuku }}</div>
        <div style="font-size:11px; color:#bbb; margin-top:4px;">koleksi buku</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(255,193,7,0.15); border-left:5px solid #ffc107;">
        <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Sedang Dipinjam</div>
        <div style="font-size:36px; font-weight:bold; color:#ffc107;">{{ $totalPinjam }}</div>
        <div style="font-size:11px; color:#bbb; margin-top:4px;">buku aktif dipinjam</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(229,57,53,0.15); border-left:5px solid #e53935;">
        <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Terlambat</div>
        <div style="font-size:36px; font-weight:bold; color:#e53935;">{{ $totalTerlambat }}</div>
        <div style="font-size:11px; color:#bbb; margin-top:4px;">melewati jatuh tempo</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(229,57,53,0.1); border-left:5px solid #ff7043;">
        <div style="font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Total Denda</div>
        <div style="font-size:26px; font-weight:bold; color:#ff7043;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        <div style="font-size:11px; color:#bbb; margin-top:4px;">akumulasi denda</div>
    </div>

</div>

{{-- Transaksi Terbaru & Aksi Cepat --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">

    {{-- Transaksi Terbaru --}}
    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div style="font-size:15px; font-weight:bold; color:#333;">📋 Transaksi Terbaru</div>
            <a href="{{ route('kepala.laporan') }}" style="font-size:12px; color:#b57ba6; text-decoration:none;">Lihat semua →</a>
        </div>
        @forelse($transaksiTerbaru as $t)
        <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5;">
            <div style="width:36px; height:36px; border-radius:50%; background:#b57ba6; color:white; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:13px; flex-shrink:0;">
                {{ strtoupper(substr($t->anggota->name ?? 'A', 0, 1)) }}
            </div>
            <div style="flex:1;">
                <div style="font-size:13px; font-weight:600; color:#333;">{{ $t->anggota->name ?? '-' }}</div>
                <div style="font-size:12px; color:#999;">{{ $t->judul_buku }}</div>
            </div>
            <div style="text-align:right;">
                @if($t->status === 'menunggu')
                    <span style="background:#e3d4f0; color:#6a1b9a; padding:3px 10px; border-radius:20px; font-size:11px;">Menunggu</span>
                @elseif($t->status === 'dipinjam' && $t->hari_terlambat > 0)
                    <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:11px;">Terlambat</span>
                @elseif($t->status === 'dipinjam')
                    <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px;">Dipinjam</span>
                @elseif($t->status === 'mengembalikan')
                    <span style="background:#cce5ff; color:#004085; padding:3px 10px; border-radius:20px; font-size:11px;">Minta Kembali</span>
                @else
                    <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:20px; font-size:11px;">Dikembalikan</span>
                @endif
                <div style="font-size:10px; color:#bbb; margin-top:3px;">{{ \Carbon\Carbon::parse($t->created_at)->diffForHumans() }}</div>
            </div>
        </div>
        @empty
            <div style="text-align:center; color:#bbb; padding:30px 0; font-size:13px;">Belum ada transaksi.</div>
        @endforelse
    </div>

    {{-- Aksi Cepat --}}
    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <div style="font-size:15px; font-weight:bold; color:#333; margin-bottom:16px;">⚡ Aksi Cepat</div>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ route('kepala.laporan') }}" style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:#f9f0f6; border-radius:10px; text-decoration:none; color:#b57ba6; font-size:13px; font-weight:600;">
                📊 Lihat Laporan
            </a>
            <a href="{{ route('kepala.anggota.index') }}" style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:#f9f0f6; border-radius:10px; text-decoration:none; color:#b57ba6; font-size:13px; font-weight:600;">
                👤 Daftar Anggota
            </a>
            <a href="{{ route('kepala.petugas.index') }}" style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:#f9f0f6; border-radius:10px; text-decoration:none; color:#b57ba6; font-size:13px; font-weight:600;">
                👥 Data Petugas
            </a>
            <a href="{{ route('kepala.katalog') }}" style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:#f9f0f6; border-radius:10px; text-decoration:none; color:#b57ba6; font-size:13px; font-weight:600;">
                📚 Katalog Buku
            </a>
            <a href="{{ route('kepala.laporan.cetak.pdf') }}" style="display:flex; align-items:center; gap:10px; padding:12px 14px; background:#f9f0f6; border-radius:10px; text-decoration:none; color:#b57ba6; font-size:13px; font-weight:600;">
                🖨️ Cetak Laporan PDF
            </a>
        </div>
    </div>

</div>

@endsection
