@extends('petugas.layouts')

@section('title', 'Edit Peminjaman')
@section('header', 'EDIT PEMINJAMAN')

@section('content')

<div style="max-width:500px; background:white; padding:25px; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.peminjaman.update', $peminjaman) }}" method="POST">
        @csrf @method('PUT')

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Anggota</label>
            <select name="anggota_id" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
                @foreach($anggota as $a)
                <option value="{{ $a->id }}" {{ $peminjaman->anggota_id == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Judul Buku</label>
            <select name="judul_buku" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
                @foreach($buku as $b)
                <option value="{{ $b->judul }}" {{ $peminjaman->judul_buku == $b->judul ? 'selected' : '' }}>{{ $b->judul }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam', $peminjaman->tgl_pinjam) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Tanggal Jatuh Tempo</label>
            <input type="date" name="tgl_jatuh_tempo" value="{{ old('tgl_jatuh_tempo', $peminjaman->tgl_jatuh_tempo) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;">
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" value="{{ old('tgl_kembali', $peminjaman->tgl_kembali) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;">
        </div>

        <div style="margin-bottom:15px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Status</label>
            <select name="status" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;" required>
                <option value="menunggu"      {{ $peminjaman->status == 'menunggu'      ? 'selected' : '' }}>Menunggu</option>
                <option value="dipinjam"      {{ $peminjaman->status == 'dipinjam'      ? 'selected' : '' }}>Dipinjam</option>
                <option value="mengembalikan" {{ $peminjaman->status == 'mengembalikan' ? 'selected' : '' }}>Mengembalikan</option>
                <option value="dikembalikan"  {{ $peminjaman->status == 'dikembalikan'  ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:bold; margin-bottom:5px;">Denda (Rp)</label>
            <input type="number" name="denda" value="{{ old('denda', $peminjaman->denda) }}" min="0"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:8px;">
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit"
                    style="flex:1; padding:10px; background:#C8A850; color:#2A2520; border:none; border-radius:8px; font-weight:bold; cursor:pointer; transition: all 0.3s;" onmouseover="this.style.background='#967830'; this.style.color='#F5F2EE';" onmouseout="this.style.background='#C8A850'; this.style.color='#2A2520';">
                Simpan
            </button>
            <a href="{{ route('petugas.peminjaman') }}"
               style="flex:1; padding:10px; background:#eee; border-radius:8px; text-align:center; text-decoration:none; color:#333;">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
