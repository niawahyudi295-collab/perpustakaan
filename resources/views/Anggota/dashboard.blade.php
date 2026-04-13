@extends('Anggota.layouts')

@section('title', 'Dashboard')
@section('header', 'DASHBOARD')

@section('content')

{{-- Greeting --}}
<div style="background: linear-gradient(135deg, #977868, #b9a695); border-radius:16px; padding:24px 30px; margin-bottom:24px; color:white; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <div style="font-size:22px; font-weight:bold; margin-bottom:4px;">Halo, {{ Auth::user()->name }}! 👋</div>
        <div style="font-size:13px; opacity:0.9;">{{ now()->format('l, d F Y') }} &nbsp;|&nbsp; Selamat datang di Perpustakaan Digital</div>
    </div>
    <div style="font-size:60px; opacity:0.3;">📚</div>
</div>

{{-- Stat Cards --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">

    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:12px; color:#504840; margin-bottom:6px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Buku Dipinjam</div>
        <div style="font-size:36px; font-weight:bold; color:#C8A850;">{{ $dipinjam }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">dari maks. 2 buku</div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(200,168,80,0.15); border-left:5px solid #C8A850;">
        <div style="font-size:12px; color:#504840; margin-bottom:6px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Jatuh Tempo</div>
        <div style="font-size:28px; font-weight:bold; color:{{ $sisaHari !== null && $sisaHari < 0 ? '#967830' : '#C8A850' }};">
            @if($sisaHari === null) -
            @elseif($sisaHari < 0) {{ abs($sisaHari) }} Hari
            @else {{ $sisaHari }} Hari
            @endif
        </div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">
            @if($sisaHari === null) Tidak ada peminjaman aktif
            @elseif($sisaHari < 0) <span style="color:#967830; font-weight:600;">Sudah terlambat!</span>
            @else sisa waktu pengembalian
            @endif
        </div>
    </div>

    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(150,120,48,0.15); border-left:5px solid #967830;">
        <div style="font-size:12px; color:#504840; margin-bottom:6px; text-transform:uppercase; letter-spacing:1px; font-weight:600;">Total Denda</div>
        <div style="font-size:24px; font-weight:bold; color:#967830;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        <div style="font-size:11px; color:#504840; margin-top:4px; opacity:0.7;">akumulasi denda</div>
    </div>

</div>

{{-- Aktivitas Terbaru --}}
<div style="display:grid; grid-template-columns:1fr; gap:16px;">

    {{-- Aktivitas Terbaru --}}
    <div style="background:white; border-radius:14px; padding:20px 24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <div style="font-size:15px; font-weight:bold; color:#333; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            🔔 Aktivitas Terbaru
        </div>

        @if($aktivitas->isEmpty())
            <div style="text-align:center; color:#504840; padding:30px 0; font-size:13px; opacity:0.6;">Belum ada aktivitas peminjaman.</div>
        @else
            <div>
                @foreach($aktivitas as $a)
                @php $waktu = \Carbon\Carbon::parse($a->created_at)->diffForHumans(); @endphp
                <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5;">
                    <div style="width:36px; height:36px; border-radius:50%; background:#dac58a; color:white; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:13px; flex-shrink:0;">
                        {{ strtoupper(substr($a->anggota->name ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex:1; font-size:13px;">
                        <span style="font-weight:600; color:#333;">{{ $a->anggota_id === Auth::id() ? 'Anda' : ($a->anggota->name ?? '-') }}</span>
                        @if($a->status === 'dipinjam') <span style="color:#666;"> meminjam </span>
                        @elseif($a->status === 'mengembalikan') <span style="color:#666;"> mengajukan kembali </span>
                        @elseif($a->status === 'menunggu') <span style="color:#666;"> mengajukan pinjam </span>
                        @else <span style="color:#666;"> mengembalikan </span>
                        @endif
                        <span style="color:#C8A850; font-weight:600;">{{ $a->judul_buku }}</span>
                    </div>
                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:4px; flex-shrink:0;">
                        <span style="font-size:10px; color:#504840; opacity:0.6;">{{ $waktu }}</span>
                        @if($a->status === 'dipinjam')
                            <span style="background:#fff3cd; color:#856404; padding:2px 8px; border-radius:20px; font-size:10px;">Dipinjam</span>
                        @elseif($a->status === 'mengembalikan')
                            <span style="background:#cce5ff; color:#004085; padding:2px 8px; border-radius:20px; font-size:10px;">Minta Kembali</span>
                        @elseif($a->status === 'menunggu')
                            <span style="background:#e3d4f0; color:#6a1b9a; padding:2px 8px; border-radius:20px; font-size:10px;">Menunggu</span>
                        @else
                            <span style="background:#d4edda; color:#155724; padding:2px 8px; border-radius:20px; font-size:10px;">Dikembalikan</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>


</div>

@endsection
