@extends('Anggota.layouts')

@section('title', 'Dashboard')

@section('header')
    Dashboard
@endsection

@section('content')

<!-- CARD -->
<div class="grid grid-cols-3 gap-6 mb-10">

    <div class="bg-white p-6 rounded-xl shadow text-center">
        <h2 class="text-gray-500">Buku Dipinjam</h2>
        <p class="text-3xl font-bold text-pink-500 mt-2">3</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow text-center">
        <h2 class="text-gray-500">Jatuh Tempo</h2>
        <p class="text-3xl font-bold text-yellow-500 mt-2">2 Hari Lagi</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow text-center">
        <h2 class="text-gray-500">Denda</h2>
        <p class="text-3xl font-bold text-red-500 mt-2">Rp 5.000</p>
    </div>

</div>

<!-- TABEL -->
<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold mb-4">Buku yang Sedang Dipinjam</h2>

    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">Judul Buku</th>
                <th class="text-left">Tanggal Pinjam</th>
                <th class="text-left">Jatuh Tempo</th>
                <th class="text-left">Tanggal Kembali</th>
                <th class="text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td class="py-2">Laskar Pelangi</td>
                <td>20 Feb 2026</td>
                <td>23 Feb 2026</td>
                <td>25 Feb 2026</td>
                <td class="text-red-500">Terlambat</td>
            </tr>

            <tr class="border-b">
                <td class="py-2">Laskar Pelangi</td>
                <td>20 Feb 2026</td>
                <td>23 Feb 2026</td>
                <td>22 Feb 2026</td>
                <td class="text-green-600">Dipinjam</td>
            </tr>


        </tbody>
    </table>
</div>

@endsection