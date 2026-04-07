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
        <div class="text-white text-center py-5 text-2xl font-bold relative" style="background-color: #b57ba6;">
            @yield('header')
            <a href="{{ route('anggota.profile') }}" class="absolute right-5 top-1/2 flex items-center gap-2" style="transform:translateY(-50%); text-decoration:none; color:white;">
                @if(Auth::user()->foto)
                    <img src="{{ asset('images/' . Auth::user()->foto) }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid white;">
                @else
                    <div style="width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,0.3); border:2px solid white; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:16px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span style="font-size:13px;">{{ Auth::user()->name }}</span>
            </a>
        </div>
        <div class="flex-1 p-6 bg-[#f5e8f0]">
            @yield('content')
        </div>
        <div class="h-14" style="background-color: #b57ba6;"></div>
    </div>

</div>

</body>
</html>
