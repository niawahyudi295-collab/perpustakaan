@extends('petugas.layouts')

@section('title', 'Dashboard')
@section('header', 'DASHBOARD')

@section('content')

{{-- Greeting --}}
<div style="background: linear-gradient(135deg, #C8A850, #967830); border-radius:16px; padding:24px 30px; margin-bottom:24px; color:#F5F2EE; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <div style="font-size:22px; font-weight:bold; margin-bottom:4px;">Halo, {{ Auth::user()->name }}! 👋</div>
        <div style="font-size:13px; opacity:0.9;">{{ now()->format('l, d F Y') }} &nbsp;|&nbsp; Petugas Perpustakaan</div>
    </div>
    <div style="font-size:60px; opacity:0.3;">🗂️</div>
</div>

{{-- Stat Cards --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Dipinjam</div>
        <div style="font-size:36px; font-weight:bold; color:#C8A850;">{{ $peminjaman }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">buku aktif dipinjam</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(150,120,48,0.15); border-left:5px solid #967830;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Menunggu</div>
        <div style="font-size:36px; font-weight:bold; color:#967830;">{{ $menunggu }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">perlu dikonfirmasi</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(150,120,48,0.15); border-left:5px solid #967830;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Terlambat</div>
        <div style="font-size:36px; font-weight:bold; color:#967830;">{{ $terlambat }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">melewati jatuh tempo</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:11px; color:#504840; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; font-weight:600;">Minta Kembali</div>
        <div style="font-size:36px; font-weight:bold; color:#C8A850;">{{ $mengembalikan }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">menunggu konfirmasi</div>
    </div>

</div>

{{-- Transaksi Terbaru --}}
<div style="display:grid; grid-template-columns:1fr; gap:16px;">

    {{-- Transaksi Terbaru --}}
    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <div style="font-size:15px; font-weight:bold; color:#333; margin-bottom:16px;">📋 Transaksi Terbaru</div>
        @forelse($transaksiTerbaru as $t)
        <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5;">
            <div style="width:36px; height:36px; border-radius:50%; background:#C8A850; color:#2A2520; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:13px; flex-shrink:0;">
                {{ strtoupper(substr($t->anggota->name ?? 'A', 0, 1)) }}
            </div>
            <div style="flex:1;">
                <div style="font-size:13px; font-weight:600; color:#333;">{{ $t->anggota->name ?? '-' }}</div>
                <div style="font-size:12px; color:#504840;">{{ $t->judul_buku }}</div>
            </div>
            <div style="text-align:right;">
                @if($t->status === 'menunggu')
                    <span style="background:#f5e6cc; color:#504840; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">Menunggu</span>
                @elseif($t->status === 'dipinjam' && $t->hari_terlambat > 0)
                    <span style="background:#f5e6cc; color:#967830; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">Terlambat</span>
                @elseif($t->status === 'dipinjam')
                    <span style="background:#e8f4e8; color:#2A2520; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">Dipinjam</span>
                @elseif($t->status === 'mengembalikan')
                    <span style="background:#dfe8dc; color:#2A2520; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">Minta Kembali</span>
                @else
                    <span style="background:#dfe8dc; color:#2A2520; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">Dikembalikan</span>
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
