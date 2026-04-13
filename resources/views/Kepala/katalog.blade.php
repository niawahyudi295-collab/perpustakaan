@extends('Kepala.layouts')

@section('title', 'Katalog Buku')
@section('header', 'Katalog Buku')

@section('content')
<div class="flex justify-between items-center mb-5">
    <h2 class="text-xl font-bold text-gray-900">Daftar Buku</h2>
</div>

<div class="rounded overflow-hidden shadow">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color: #916c65;" class="text-white">
                <th class="px-5 py-3 text-left font-semibold w-16">No</th>
                <th class="px-5 py-3 text-left font-semibold">Judul</th>
                <th class="px-5 py-3 text-left font-semibold">Pengarang</th>
                <th class="px-5 py-3 text-left font-semibold">Penerbit</th>
                <th class="px-5 py-3 text-center font-semibold">Jumlah</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($buku as $i => $b)
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-5 py-3">{{ $i + 1 }}</td>
                <td class="px-5 py-3">{{ $b->judul }}</td>
                <td class="px-5 py-3">{{ $b->pengarang }}</td>
                <td class="px-5 py-3">{{ $b->penerbit }}</td>
                <td class="px-5 py-3 text-center">{{ $b->jumlah }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-4 text-center text-gray-400">Belum ada data buku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
