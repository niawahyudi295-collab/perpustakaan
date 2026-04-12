@extends('petugas.layouts')

@section('title', 'Peminjaman')
@section('header', 'DATA PEMINJAMAN')

@section('content')

<div style="margin-bottom:15px;">
    <span style="font-size:18px; font-weight:bold;">Daftar Peminjaman</span>
</div>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#b57ba6; color:white;">
            <th style="padding:12px;">No</th>
            <th style="padding:12px;">Nama Anggota</th>
            <th style="padding:12px;">Judul Buku</th>
            <th style="padding:12px;">Tgl Pinjam</th>
            <th style="padding:12px;">Tgl Jatuh Tempo</th>
            <th style="padding:12px;">Tgl Kembali</th>
            <th style="padding:12px;">Status</th>
            <th style="padding:12px;">Denda</th>
            <th style="padding:12px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($peminjaman as $i => $p)
        @php
            $tglJatuhTempo = $p->tgl_jatuh_tempo ? \Carbon\Carbon::parse($p->tgl_jatuh_tempo) : null;
            $terlambat     = $tglJatuhTempo && $p->status === 'dipinjam' && now()->gt($tglJatuhTempo);
            $hariTerlambat = $terlambat ? (int) now()->diffInDays($tglJatuhTempo) : 0;
            $sisaHari      = ($tglJatuhTempo && $p->status === 'dipinjam') ? (int) now()->diffInDays($tglJatuhTempo, false) : null;
        @endphp
        <tr style="background:{{ $i % 2 == 0 ? '#f9f9f9' : '#eee' }}; text-align:center;">
            <td style="padding:10px;">{{ $i + 1 }}</td>
            <td style="padding:10px;">{{ $p->anggota->name ?? '-' }}</td>
            <td style="padding:10px;">{{ $p->judul_buku }}</td>
            <td style="padding:10px;">{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
            <td style="padding:10px;">
                @if(!$tglJatuhTempo)
                    <span style="color:#aaa;">Belum ditentukan</span>
                @elseif($p->status === 'dikembalikan')
                    <span style="color:#999;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @elseif($terlambat)
                    <span style="color:red; font-weight:bold;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @elseif($sisaHari !== null && $sisaHari <= 3)
                    <span style="color:orange; font-weight:bold;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @else
                    <span style="color:green;">{{ $tglJatuhTempo->format('d/m/Y') }}</span>
                @endif
            </td>
            <td style="padding:10px;">
                {{ $p->tgl_kembali ? \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') : '-' }}
            </td>
            <td style="padding:10px;">
                @if($p->status === 'menunggu')
                    <span style="background:#e3d4f0;color:#6a1b9a;padding:3px 10px;border-radius:20px;font-size:12px;">⏳ Menunggu</span>
                @elseif($p->status === 'dipinjam' && $terlambat)
                    <span style="background:#f8d7da;color:#721c24;padding:3px 10px;border-radius:20px;font-size:12px;">⚠️ Terlambat</span>
                @elseif($p->status === 'dipinjam')
                    <span style="background:#fff3cd;color:#856404;padding:3px 10px;border-radius:20px;font-size:12px;">Dipinjam</span>
                @elseif($p->status === 'mengembalikan')
                    <span style="background:#cce5ff;color:#004085;padding:3px 10px;border-radius:20px;font-size:12px;">🔄 Minta Kembali</span>
                @else
                    <span style="background:#d4edda;color:#155724;padding:3px 10px;border-radius:20px;font-size:12px;">✅ Dikembalikan</span>
                @endif
            </td>
            <td style="padding:10px; text-align:center;">
                <span id="denda-label-{{ $p->id }}" style="color:{{ $p->denda > 0 ? 'red' : '#555' }}; font-weight:{{ $p->denda > 0 ? 'bold' : 'normal' }}; cursor:pointer;" onclick="showDendaEdit({{ $p->id }}, {{ $p->denda }})" title="Klik untuk ubah denda">
                    {{ $p->denda > 0 ? 'Rp '.number_format($p->denda,0,',','.') : '-' }} ✏️
                </span>
                <form id="denda-form-{{ $p->id }}" action="{{ route('petugas.peminjaman.update.denda', $p) }}" method="POST" style="display:none; gap:4px; align-items:center; justify-content:center;">
                    @csrf @method('PATCH')
                    <input type="number" name="denda" id="denda-input-{{ $p->id }}" min="0" step="1000"
                           style="width:90px; padding:4px 6px; border:1px solid #ccc; border-radius:5px; font-size:12px;">
                    <button type="submit" style="background:#5cb85c;color:white;padding:4px 8px;border:none;border-radius:4px;cursor:pointer;font-size:11px;">✓</button>
                    <button type="button" onclick="hideDendaEdit({{ $p->id }})"
                            style="background:#aaa;color:white;padding:4px 8px;border:none;border-radius:4px;cursor:pointer;font-size:11px;">✕</button>
                </form>
            </td>
            <td style="padding:10px;">
                @if($p->status === 'menunggu')
                    <form action="{{ route('petugas.peminjaman.konfirmasi', $p) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Konfirmasi peminjaman ini? Jatuh tempo akan ditetapkan 5 hari dari tanggal pinjam.')">
                        @csrf @method('PATCH')
                        <button style="background:#b57ba6;color:white;padding:5px 12px;border:none;border-radius:5px;cursor:pointer;font-size:12px;">
                            Konfirmasi
                        </button>
                    </form>
                @elseif($p->status === 'mengembalikan')
                    <form action="{{ route('petugas.peminjaman.konfirmasi.kembali', $p) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                        @csrf @method('PATCH')
                        <button style="background:#5cb85c;color:white;padding:5px 12px;border:none;border-radius:5px;cursor:pointer;font-size:12px;">
                            Konfirmasi Kembali
                        </button>
                    </form>
                @else
                    <span style="color:#999;font-size:12px;">-</span>
                @endif
                <a href="{{ route('petugas.peminjaman.edit', $p) }}"
                   style="background:#f0ad4e;color:white;padding:5px 10px;border-radius:5px;font-size:12px;text-decoration:none;display:inline-block;margin-top:4px;">
                    Edit
                </a>
                <form action="{{ route('petugas.peminjaman.destroy', $p) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Hapus data peminjaman ini?')">
                    @csrf @method('DELETE')
                    <button style="background:#d9534f;color:white;padding:5px 10px;border:none;border-radius:5px;cursor:pointer;font-size:12px;margin-top:4px;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="padding:15px;text-align:center;color:#999;">Belum ada data peminjaman.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection

<script>
function showDendaEdit(id, current) {
    document.getElementById('denda-label-' + id).style.display = 'none';
    const form = document.getElementById('denda-form-' + id);
    form.style.display = 'flex';
    document.getElementById('denda-input-' + id).value = current;
}
function hideDendaEdit(id) {
    document.getElementById('denda-label-' + id).style.display = 'inline';
    document.getElementById('denda-form-' + id).style.display = 'none';
}
</script>
