@extends('petugas.layouts')

@section('title', 'Edit Buku')
@section('header', 'EDIT BUKU')

@section('content')
<div style="max-width:520px; margin:auto; background:white; padding:25px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

    @if($errors->any())
        <div style="background:#f8d7da; color:#721c24; padding:10px 15px; border-radius:6px; margin-bottom:15px; font-size:13px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.bukupetugas.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div style="margin-bottom:14px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom:14px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Kategori</label>
            <select name="kategori" style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->nama }}" {{ old('kategori', $buku->kategori) == $k->nama ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:14px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Pengarang</label>
            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom:14px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Penerbit</label>
            <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom:14px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Tahun</label>
            <input type="number" name="tahun" value="{{ old('tahun', $buku->tahun) }}"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom:14px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom:20px;">
            <label style="font-weight:bold; display:block; margin-bottom:5px;">Cover Buku</label>

            {{-- Cover saat ini --}}
            @if($buku->cover)
            <div style="margin-bottom:8px;">
                <img src="{{ asset('images/' . $buku->cover) }}" alt="Cover"
                     id="cover-preview"
                     style="width:120px; height:160px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
            </div>
            @else
            <div id="preview-wrap" style="margin-bottom:8px; display:none;">
                <img id="cover-preview" src="" alt="Preview"
                     style="width:120px; height:160px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
            </div>
            @endif

            <input type="file" name="cover" accept="image/*" onchange="previewCover(this)"
                   style="width:100%; padding:8px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box;">
            <p style="font-size:12px; color:#888; margin-top:4px;">Kosongkan jika tidak ingin mengganti cover.</p>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" style="flex:1; padding:10px; background:#b57ba6; color:white; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">Update</button>
            <a href="{{ route('petugas.bukupetugas.index') }}" style="flex:1; padding:10px; background:#eee; border-radius:8px; text-align:center; text-decoration:none; color:#333;">Batal</a>
        </div>
    </form>
</div>

<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('cover-preview');
            img.src = e.target.result;
            img.style.display = 'block';
            const wrap = document.getElementById('preview-wrap');
            if (wrap) wrap.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
