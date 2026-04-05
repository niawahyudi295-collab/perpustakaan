@extends('Anggota.layouts')

@section('title', 'Pinjam Buku')
@section('header', 'PINJAM BUKU')

@section('content')

<div class="max-w-md bg-white p-6 rounded-xl shadow">

    @if($errors->any())
        <div class="bg-red-50 text-red-600 px-4 py-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <p class="mb-4"><strong>Judul Buku:</strong> {{ $buku->judul }}</p>
    <p class="mb-4 text-sm text-gray-500">Maksimal peminjaman <strong>20 hari</strong> dari hari ini
        (paling lambat <strong>{{ now()->addDays(20)->format('d/m/Y') }}</strong>)
    </p>

    <form action="{{ route('anggota.buku.pinjam.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="buku_id" value="{{ $buku->id }}">

        <div>
            <label class="block font-semibold mb-1 text-sm">Tanggal Pinjam</label>
            <input type="text" value="{{ now()->format('d/m/Y') }}" disabled
                   class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">
        </div>

        <div>
            <label class="block font-semibold mb-1 text-sm">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali"
                   min="{{ now()->addDay()->toDateString() }}"
                   max="{{ now()->addDays(20)->toDateString() }}"
                   value="{{ old('tgl_kembali') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
            <p class="text-xs text-gray-400 mt-1">Pilih antara besok s/d {{ now()->addDays(20)->format('d/m/Y') }}</p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="flex-1 py-2 text-white rounded text-sm font-semibold hover:opacity-90"
                    style="background:#cc7dae;">Ajukan Pinjam</button>
            <a href="{{ route('anggota.buku.index') }}"
               class="flex-1 py-2 bg-gray-200 text-gray-700 rounded text-sm text-center hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>

@endsection
