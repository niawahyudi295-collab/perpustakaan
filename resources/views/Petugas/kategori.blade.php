@extends('petugas.layouts')

@section('title', 'Kategori')
@section('header', 'KATEGORI BUKU')

@section('content')

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px 15px; border-radius:6px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

{{-- FORM TAMBAH DI ATAS --}}
<div style="background:#f9f9f9; padding:15px 20px; border-radius:10px; border:1px solid #ddd; margin-bottom:20px;">
    <label style="font-weight:bold; display:block; margin-bottom:8px; font-size:14px;">Tambah Kategori Baru</label>
    @if($errors->has('nama'))
        <div style="color:red; font-size:12px; margin-bottom:6px;">{{ $errors->first('nama') }}</div>
    @endif
    <form action="{{ route('petugas.kategori.store') }}" method="POST" style="display:flex; gap:10px;">
        @csrf
        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Fiksi, Non Fiksi, Sains..."
               style="flex:1; padding:9px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px;" required>
        <button type="submit"
                style="padding:9px 20px; background:#b57ba6; color:white; border:none; border-radius:6px; cursor:pointer; font-size:14px; font-weight:bold; white-space:nowrap;">
            + Tambah
        </button>
    </form>
</div>

{{-- DAFTAR KATEGORI --}}
@forelse($kategori as $i => $k)
@php $bukuList = \App\Models\Buku::where('kategori', $k->nama)->get(); @endphp

<div style="margin-bottom:25px; border:1px solid #e0e0e0; border-radius:10px; overflow:hidden;">

    {{-- Header Kategori --}}
    <div style="background:#b57ba6; color:white; padding:12px 16px; display:flex; justify-content:space-between; align-items:center;">
        <div id="label-{{ $k->id }}">
            <span style="font-weight:bold; font-size:15px;">{{ $k->nama }}</span>
            <span style="font-size:12px; margin-left:10px; opacity:0.85;">{{ $bukuList->sum('stok') }} buku</span>
        </div>

        {{-- Form edit inline --}}
        <form id="edit-form-{{ $k->id }}" action="{{ route('petugas.kategori.update', $k) }}" method="POST"
              style="display:none; gap:8px; align-items:center;">
            @csrf @method('PUT')
            <input type="text" name="nama" id="input-{{ $k->id }}" value="{{ $k->nama }}"
                   style="padding:6px 10px; border-radius:6px; border:none; font-size:14px; width:200px;">
            <button type="submit" style="background:#5cb85c; color:white; padding:6px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">Simpan</button>
            <button type="button" onclick="hideEdit({{ $k->id }})"
                    style="background:#aaa; color:white; padding:6px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">Batal</button>
        </form>

        <div id="aksi-{{ $k->id }}" style="display:flex; gap:8px;">
            <button onclick="showEdit({{ $k->id }}, '{{ addslashes($k->nama) }}')"
                    style="background:#f0ad4e; color:white; padding:5px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">
                Edit
            </button>
            <form action="{{ route('petugas.kategori.destroy', $k) }}" method="POST" style="display:inline;"
                  onsubmit="return confirm('Hapus kategori ini?')">
                @csrf @method('DELETE')
                <button style="background:#d9534f; color:white; padding:5px 12px; border:none; border-radius:5px; cursor:pointer; font-size:12px;">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Buku --}}
    <div style="padding:15px; background:white;">
        @if($bukuList->isEmpty())
            <p style="color:#999; font-size:13px; margin:0;">Belum ada buku dalam kategori ini.</p>
        @else
            <div style="display:flex; flex-wrap:wrap; gap:15px;">
                @foreach($bukuList as $b)
                <div style="display:flex; gap:12px; align-items:flex-start; background:#fafafa; border:1px solid #eee; border-radius:8px; padding:10px; width:260px;">
                    {{-- Cover --}}
                    <div style="flex-shrink:0;">
                        @if($b->cover)
                            <img src="{{ asset('storage/' . $b->cover) }}" alt="cover"
                                 style="width:55px; height:75px; object-fit:cover; border-radius:5px; border:1px solid #ddd;">
                        @else
                            <div style="width:55px; height:75px; background:#eee; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:20px;">📖</div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div style="font-size:13px; line-height:1.6;">
                        <div style="font-weight:bold; color:#333;">{{ $b->judul }}</div>
                        <div style="color:#777;">{{ $b->penulis ?? '-' }}</div>
                        <div style="color:#999; font-size:12px;">Stok: {{ $b->stok ?? $b->jumlah }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@empty
<div style="text-align:center; color:#999; padding:30px;">Belum ada kategori. Tambahkan di atas.</div>
@endforelse

<script>
function showEdit(id, nama) {
    document.getElementById('label-' + id).style.display = 'none';
    document.getElementById('aksi-' + id).style.display = 'none';
    const form = document.getElementById('edit-form-' + id);
    form.style.display = 'flex';
    document.getElementById('input-' + id).value = nama;
}
function hideEdit(id) {
    document.getElementById('label-' + id).style.display = 'block';
    document.getElementById('aksi-' + id).style.display = 'flex';
    document.getElementById('edit-form-' + id).style.display = 'none';
}
</script>

@endsection
