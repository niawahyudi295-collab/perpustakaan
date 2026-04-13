@extends('petugas.layouts')

@section('title', 'Kategori')
@section('header', 'KATEGORI BUKU')

@section('content')

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->has('nama') && !old('_method'))
    <div style="background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ $errors->first('nama') }}
    </div>
@endif

{{-- FORM TAMBAH --}}
<div style="background:#f9f9f9; padding:15px 20px; border-radius:10px; border:1px solid #ddd; margin-bottom:20px;">
    <label style="font-weight:bold; display:block; margin-bottom:8px; font-size:14px;">Tambah Kategori Baru</label>
    @if($errors->has('nama'))
        <div style="color:red; font-size:12px; margin-bottom:6px;">{{ $errors->first('nama') }}</div>
    @endif
    <form action="{{ route('petugas.kategori.store') }}" method="POST" style="display:flex; gap:10px;">
        @csrf
        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama kategori..."
               style="flex:1; padding:9px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px;" required>
        <button type="submit"
                style="padding:9px 20px; background:#C8A850; color:#2A2520; border:none; border-radius:6px; cursor:pointer; font-size:14px; font-weight:bold; white-space:nowrap; transition: background 0.3s;" onmouseover="this.style.background='#967830'; this.style.color='#F5F2EE';" onmouseout="this.style.background='#C8A850'; this.style.color='#2A2520';">
            + Tambah
        </button>
    </form>
</div>

{{-- TABEL KATEGORI --}}
<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#C8A850; color:#2A2520; font-weight:bold;">
            <th style="padding:12px; text-align:center; width:50px;">No</th>
            <th style="padding:12px; text-align:left;">Nama Kategori</th>
            <th style="padding:12px; text-align:center; width:180px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($kategori as $i => $k)
        <tr style="background:{{ $i % 2 == 0 ? '#f9f9f9' : '#eee' }}; border-bottom:1px solid #ddd;">
            <td style="padding:10px; text-align:center;">{{ $i + 1 }}</td>

            {{-- Nama (tampil biasa / edit inline) --}}
            <td style="padding:10px;">
                <span id="label-{{ $k->id }}">{{ $k->nama }}</span>
                <form id="edit-form-{{ $k->id }}" action="{{ route('petugas.kategori.update', $k) }}" method="POST"
                      style="display:none;">
                    @csrf @method('PUT')
                    <input type="text" name="nama" id="input-{{ $k->id }}" value="{{ $k->nama }}"
                           style="padding:6px 10px; border:1px solid #ccc; border-radius:6px; font-size:14px; width:200px;">
                </form>
            </td>

            {{-- Aksi --}}
            <td style="padding:10px; text-align:center;">
                {{-- Tombol Edit / Simpan / Batal --}}
                <span id="aksi-{{ $k->id }}">
                    <button onclick="showEdit({{ $k->id }})"
                            style="background:#f0ad4e; color:white; padding:5px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">
                        Edit
                    </button>
                    <form action="{{ route('petugas.kategori.destroy', $k) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Hapus kategori {{ $k->nama }}?')">
                        @csrf @method('DELETE')
                        <button style="background:#d9534f; color:white; padding:5px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">
                            Hapus
                        </button>
                    </form>
                </span>
                <span id="simpan-{{ $k->id }}" style="display:none;">
                    <button onclick="document.getElementById('edit-form-{{ $k->id }}').submit()"
                            style="background:#5cb85c; color:white; padding:5px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">
                        Simpan
                    </button>
                    <button onclick="hideEdit({{ $k->id }})"
                            style="background:#aaa; color:white; padding:5px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">
                        Batal
                    </button>
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" style="padding:20px; text-align:center; color:#999;">Belum ada kategori.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<script>
function showEdit(id) {
    document.getElementById('label-' + id).style.display = 'none';
    document.getElementById('edit-form-' + id).style.display = 'inline';
    document.getElementById('aksi-' + id).style.display = 'none';
    document.getElementById('simpan-' + id).style.display = 'inline';
}
function hideEdit(id) {
    document.getElementById('label-' + id).style.display = 'inline';
    document.getElementById('edit-form-' + id).style.display = 'none';
    document.getElementById('aksi-' + id).style.display = 'inline';
    document.getElementById('simpan-' + id).style.display = 'none';
}
</script>

@endsection
