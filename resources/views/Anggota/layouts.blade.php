<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-[#f5e8f0]">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-48 min-h-screen flex flex-col bg-white shadow-sm">
        <div class="px-4 py-5 flex-1">
            <div class="text-center font-bold text-sm text-gray-700 mb-6 leading-snug">
                Perpustakaan<br>Digital
            </div>
            <nav class="space-y-1">
                <a href="{{ route('anggota.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('anggota.dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="text-lg">🏠</span>
                    <span style="color:#b57ba6; font-weight:{{ request()->routeIs('anggota.dashboard') ? 'bold' : 'normal' }}">Dashboard</span>
                </a>
                <a href="{{ route('anggota.buku.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('anggota.buku*') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="text-lg">📋</span>
                    <span style="color:#b57ba6; font-weight:{{ request()->routeIs('anggota.buku*') ? 'bold' : 'normal' }}">Menu Buku</span>
                </a>
                <a href="{{ route('anggota.peminjaman') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('anggota.peminjaman') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="text-lg">📖</span>
                    <span style="color:#b57ba6; font-weight:{{ request()->routeIs('anggota.peminjaman') ? 'bold' : 'normal' }}">Peminjaman</span>
                </a>
                <a href="{{ route('anggota.pengembalian') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('anggota.pengembalian') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="text-lg">↩️</span>
                    <span style="color:#b57ba6; font-weight:{{ request()->routeIs('anggota.pengembalian') ? 'bold' : 'normal' }}">Pengembalian</span>
                </a>
                <a href="{{ route('anggota.riwayat') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('anggota.riwayat') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="text-lg">📜</span>
                    <span style="color:#b57ba6; font-weight:{{ request()->routeIs('anggota.riwayat') ? 'bold' : 'normal' }}">Riwayat</span>
                </a>
                <a href="{{ route('anggota.profile') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm text-gray-700 hover:bg-gray-100 transition {{ request()->routeIs('anggota.profile') ? 'bg-gray-100 font-semibold' : '' }}">
                    <span class="text-lg">👤</span>
                    <span style="color:#b57ba6; font-weight:{{ request()->routeIs('anggota.profile') ? 'bold' : 'normal' }}">Profil</span>
                </a>
            </nav>
        </div>
        <div class="px-4 py-5">
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
        <div class="flex-1 p-6 bg-[#f5e8f0]">
            @yield('content')
        </div>
        <div class="h-14" style="background-color: #b57ba6;"></div>
    </div>

</div>

</body>
</html>
