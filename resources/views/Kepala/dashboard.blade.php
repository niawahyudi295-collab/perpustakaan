@extends('Kepala.layouts')

@section('title', 'Dashboard')
@section('header', 'DASHBOARD')

@section('content')

{{-- Greeting --}}
<div style="background: linear-gradient(135deg, #382e2e, #dca47d); border-radius:16px; padding:24px 30px; margin-bottom:24px; color:white; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <div style="font-size:22px; font-weight:bold; margin-bottom:4px;">Halo, {{ Auth::user()->name }}! 👋</div>
        <div style="font-size:13px; opacity:0.9;">{{ now()->format('l, d F Y') }} &nbsp;|&nbsp; Panel Kepala Perpustakaan</div>
    </div>
    <div style="font-size:60px; opacity:0.3;">🏛️</div>
</div>

{{-- Stat Cards --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Total Anggota</div>
        <div style="font-size:36px; font-weight:bold; color:#C8A850;">{{ $totalAnggota }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">anggota terdaftar</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Total Petugas</div>
        <div style="font-size:36px; font-weight:bold; color:#C8A850;">{{ $totalPetugas }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">petugas aktif</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Total Buku</div>
        <div style="font-size:36px; font-weight:bold; color:#C8A850;">{{ $totalBuku }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">koleksi buku</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(150,120,48,0.15); border-left:5px solid #967830;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Sedang Dipinjam</div>
        <div style="font-size:36px; font-weight:bold; color:#967830;">{{ $totalPinjam }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">buku aktif dipinjam</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(150,120,48,0.15); border-left:5px solid #967830;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Terlambat</div>
        <div style="font-size:36px; font-weight:bold; color:#967830;">{{ $totalTerlambat }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">melewati jatuh tempo</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(150,120,48,0.1); border-left:5px solid #967830;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Total Denda</div>
        <div style="font-size:26px; font-weight:bold; color:#967830;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">akumulasi denda</div>
    </div>

</div>

{{-- Transaksi Terbaru --}}
<div style="display:grid; grid-template-columns:1fr; gap:16px;">

    {{-- Transaksi Terbaru --}}
    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <div style="font-size:15px; font-weight:bold; color:#333;">📋 Transaksi Terbaru</div>
            <a href="{{ route('kepala.laporan') }}" style="font-size:12px; color:#967830; text-decoration:none; font-weight:600; transition: color 0.3s;" onmouseover="this.style.color='#C8A850'" onmouseout="this.style.color='#967830'">Lihat semua →</a>
        </div>
        @forelse($transaksiTerbaru as $t)
        <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5;">
            <div style="width:36px; height:36px; border-radius:50%; background:#C8A850; color:#2A2520; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:13px; flex-shrink:0;">
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
                <div style="font-size:10px; color:#504840; margin-top:3px; opacity:0.6;">{{ \Carbon\Carbon::parse($t->created_at)->diffForHumans() }}</div>
            </div>
        </div>
        @empty
            <div style="text-align:center; color:#504840; padding:30px 0; font-size:13px; opacity:0.6;">Belum ada transaksi.</div>
        @endforelse
    </div>


</div>

@endsection
