@extends('Kepala.layouts')

@section('title', 'Daftar Anggota')
@section('header', 'Daftar Anggota')

@section('content')
<div class="flex justify-between items-center mb-5">
    <h2 class="text-xl font-bold text-gray-900">Daftar Anggota</h2>
</div>

<div class="rounded overflow-hidden shadow">
    <table class="w-full text-sm">
        <thead>
            <tr style="background-color: #916c65;" class="text-white">
                <th class="px-5 py-3 text-left font-semibold w-16">No</th>
                <th class="px-5 py-3 text-left font-semibold">Nama</th>
                <th class="px-5 py-3 text-left font-semibold">Email</th>
                <th class="px-5 py-3 text-left font-semibold">No. HP</th>
                <th class="px-5 py-3 text-left font-semibold">Alamat</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($anggota as $i => $a)
            <tr class="border-b border-gray-100 hover:bg-pink-50">
                <td class="px-5 py-3">{{ $i + 1 }}</td>
                <td class="px-5 py-3">{{ $a->name }}</td>
                <td class="px-5 py-3">{{ $a->email }}</td>
                <td class="px-5 py-3">{{ $a->phone_number ?? '-' }}</td>
                <td class="px-5 py-3">{{ $a->alamat ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-4 text-center text-gray-400">Belum ada anggota terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
