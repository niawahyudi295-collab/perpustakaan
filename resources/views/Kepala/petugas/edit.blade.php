@extends('Kepala.layouts')

@section('title', 'Edit Petugas')
@section('header', 'Edit Akun Petugas')

@section('content')
<div class="max-w-lg bg-white rounded shadow p-6">

    @if($errors->any())
        <div class="bg-red-50 text-red-600 px-4 py-3 rounded mb-5 text-sm">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kepala.petugas.update', $petugas) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $petugas->name) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-pink-500" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $petugas->email) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-pink-500" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Password Baru
                <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
            </label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-pink-500">
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="text-white px-6 py-2 rounded text-sm font-semibold hover:opacity-90 transition"
                    style="background-color: #c2185b;">Update</button>
            <a href="{{ route('kepala.petugas.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded text-sm font-semibold hover:bg-gray-300 transition">Batal</a>
        </div>
    </form>
</div>
@endsection
