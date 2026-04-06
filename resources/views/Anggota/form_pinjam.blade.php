@extends('Anggota.layouts')

@section('title', 'Pinjam Buku')
@section('header', 'PINJAM BUKU')

@section('content')

<div class="max-w-md bg-white p-6 rounded-xl shadow">

    @if(session('error'))
        <div class="bg-red-50 text-red-600 px-4 py-3 rounded mb-4 text-sm">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 text-red-600 px-4 py-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-4">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <p class="mb-4"><strong>Judul Buku:</strong> {{ $buku->judul }}</p>
    <form action="{{ route('anggota.buku.pinjam.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="buku_id" value="{{ $buku->id }}">

        <div>
            <label class="block font-semibold mb-1 text-sm">Tanggal Pinjam</label>
            <input type="text" value="{{ now()->format('d/m/Y') }}" disabled
                   class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-50">
            <input type="hidden" name="tgl_pinjam" value="{{ now()->toDateString() }}">
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
