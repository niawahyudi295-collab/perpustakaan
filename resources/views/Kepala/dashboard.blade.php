<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white min-h-screen">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen flex flex-col" style="background-color: #eeeeee;">
        <div class="px-5 py-6 flex-1">
            <h3 class="font-bold text-base mb-6 text-gray-800 leading-snug">
                {{ Auth::user()->name }}<br>
                <span class="text-gray-500 text-sm font-normal">({{ ucfirst(Auth::user()->role) }})</span>
            </h3>
            <nav class="space-y-2">
                <a href="{{ route('kepala.petugas.index') }}"
                   class="flex items-center gap-3 bg-white px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition">
                    <span>👥</span> Data Petugas
                </a>
                <a href="{{ route('kepala.anggota.index') }}"
                   class="flex items-center gap-3 bg-white px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition">
                    <span>👤</span> Daftar Anggota
                </a>
                <a href="{{ route('kepala.katalog') }}"
                   class="flex items-center gap-3 bg-white px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition">
                    <span>📖</span> Katalog Buku
                </a>
                <a href="{{ route('kepala.laporan') }}"
                   class="flex items-center gap-3 bg-white px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition">
                    <span>📋</span> Laporan
                </a>
            </nav>
        </div>
        <div class="px-5 py-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-500 text-sm hover:underline">Logout</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">
        <div class="text-white text-center py-5 text-2xl font-bold" style="background-color: #b57ba6;">
            DASHBOARD
        </div>
        <div class="flex-1 p-10 bg-white">
            <div class="grid grid-cols-3 gap-6 max-w-2xl">
                <a href="{{ route('kepala.petugas.index') }}"
                   class="bg-white rounded-xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-md transition border border-gray-200">
                    <div class="text-4xl">👥</div>
                    <span class="font-semibold text-gray-700 text-sm text-center">Data Petugas</span>
                </a>
                <a href="{{ route('kepala.anggota.index') }}"
                   class="bg-white rounded-xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-md transition border border-gray-200">
                    <div class="text-4xl">👤</div>
                    <span class="font-semibold text-gray-700 text-sm text-center">Daftar Anggota</span>
                </a>
                <a href="{{ route('kepala.katalog') }}"
                   class="bg-white rounded-xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-md transition border border-gray-200">
                    <div class="text-4xl">📖</div>
                    <span class="font-semibold text-gray-700 text-sm text-center">Katalog Buku</span>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
