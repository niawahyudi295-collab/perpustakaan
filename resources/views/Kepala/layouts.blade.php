<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white min-h-screen">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen flex flex-col" style="background-color: #eeeeee;">
        <div class="px-5 py-6">
            <h3 class="font-bold text-base mb-6 text-gray-800">
                {{ Auth::user()->name }}<br>
                <span class="text-gray-500 text-sm font-normal">({{ ucfirst(Auth::user()->role) }})</span>
            </h3>
            <nav class="space-y-2">
                <a href="{{ route('kepala.petugas.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition {{ request()->routeIs('kepala.petugas*') ? 'bg-gray-300 font-semibold' : 'bg-white' }}">
                    <span>👥</span> Data Petugas
                </a>
                <a href="{{ route('kepala.anggota.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition {{ request()->routeIs('kepala.anggota*') ? 'bg-gray-300 font-semibold' : 'bg-white' }}">
                    <span>👤</span> Daftar Anggota
                </a>
                <a href="{{ route('kepala.katalog') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition {{ request()->routeIs('kepala.katalog') ? 'bg-gray-300 font-semibold' : 'bg-white' }}">
                    <span>📖</span> Katalog Buku
                </a>
                <a href="{{ route('kepala.laporan') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition {{ request()->routeIs('kepala.laporan*') ? 'bg-gray-300 font-semibold' : 'bg-white' }}">
                    <span>📋</span> Laporan
                </a>
            </nav>
        </div>
        <div class="mt-auto px-5 py-6">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-500 text-sm hover:underline">Logout</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">
        <div class="text-white text-center py-5 text-2xl font-bold" style="background-color: #b57ba6;">
            @yield('header')
        </div>
        <div class="flex-1 p-8 bg-white">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
