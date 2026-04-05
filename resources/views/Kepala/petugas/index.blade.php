@extends('Kepala.layouts')

@section('title', 'Data Petugas')
@section('header', 'Daftar Petugas')

@section('content')
<div class="flex justify-between items-center mb-5">
    <h2 class="text-xl font-bold text-gray-900">Daftar Petugas</h2>
    <a href="{{ route('kepala.petugas.create') }}"
       class="text-white px-5 py-2 rounded font-semibold text-sm hover:opacity-90 transition"
       style="background-color: #a76a82;">
        + Tambah Petugas
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="rounded overflow-hidden shadow">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color: #b05e7f;" class="text-white">
                <th class="px-5 py-3 text-left font-semibold w-16">No</th>
                <th class="px-5 py-3 text-center font-semibold">Nama</th>
                <th class="px-5 py-3 text-center font-semibold">Email</th>
                <th class="px-5 py-3 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($petugas as $i => $p)
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-5 py-3">{{ $i + 1 }}</td>
                <td class="px-5 py-3 text-center">{{ $p->name }}</td>
                <td class="px-5 py-3 text-center">{{ $p->email }}</td>
                <td class="px-5 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('kepala.petugas.edit', $p) }}"
                           class="bg-yellow-400 text-white px-4 py-1 rounded text-xs font-semibold hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('kepala.petugas.destroy', $p) }}" method="POST"
                              onsubmit="return confirm('Hapus petugas ini?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-4 py-1 rounded text-xs font-semibold hover:bg-red-600">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-5 py-4 text-center text-gray-400">Belum ada petugas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
