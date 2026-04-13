<!DOCTYPE html>
<html lang="id">
<head>
    <style>
:root {
    --dark: #2A2520;
    --dark-soft: #504840;
    --bg: #F5F2EE;
    --gold: #C8A850;
    --gold-dark: #967830;
}
</style>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-48 min-h-screen flex flex-col" style="background-color: #2A2520;">
        <div class="px-4 py-5 flex-1">
            <div class="text-center font-bold text-sm mb-6 leading-snug" style="color: #F5F2EE;">
                Perpustakaan<br>Digital
            </div>
            <nav class="space-y-1">
                <a href="{{ route('anggota.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm transition {{ request()->routeIs('anggota.dashboard') ? 'font-semibold' : '' }}"
                   style="color: #F5F2EE; background-color: {{ request()->routeIs('anggota.dashboard') ? '#C8A850' : 'transparent' }};"
                   onmouseover="this.style.backgroundColor='#504840'" onmouseout="this.style.backgroundColor='{{ request()->routeIs('anggota.dashboard') ? '#C8A850' : 'transparent' }}'">
                    <span class="text-lg">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('anggota.buku.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm transition {{ request()->routeIs('anggota.buku*') ? 'font-semibold' : '' }}"
                   style="color: #F5F2EE; background-color: {{ request()->routeIs('anggota.buku*') ? '#C8A850' : 'transparent' }};"
                   onmouseover="this.style.backgroundColor='#504840'" onmouseout="this.style.backgroundColor='{{ request()->routeIs('anggota.buku*') ? '#C8A850' : 'transparent' }}'">
                    <span class="text-lg">📋</span>
                    <span>Menu Buku</span>
                </a>
                <a href="{{ route('anggota.peminjaman') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm transition {{ request()->routeIs('anggota.peminjaman') ? 'font-semibold' : '' }}"
                   style="color: #F5F2EE; background-color: {{ request()->routeIs('anggota.peminjaman') ? '#C8A850' : 'transparent' }};"
                   onmouseover="this.style.backgroundColor='#504840'" onmouseout="this.style.backgroundColor='{{ request()->routeIs('anggota.peminjaman') ? '#C8A850' : 'transparent' }}'">
                    <span class="text-lg">📖</span>
                    <span>Peminjaman</span>
                </a>
                <a href="{{ route('anggota.pengembalian') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm transition {{ request()->routeIs('anggota.pengembalian') ? 'font-semibold' : '' }}"
                   style="color: #F5F2EE; background-color: {{ request()->routeIs('anggota.pengembalian') ? '#C8A850' : 'transparent' }};"
                   onmouseover="this.style.backgroundColor='#504840'" onmouseout="this.style.backgroundColor='{{ request()->routeIs('anggota.pengembalian') ? '#C8A850' : 'transparent' }}'">
                    <span class="text-lg">↩️</span>
                    <span>Pengembalian</span>
                </a>
                <a href="{{ route('anggota.riwayat') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm transition {{ request()->routeIs('anggota.riwayat') ? 'font-semibold' : '' }}"
                   style="color: #F5F2EE; background-color: {{ request()->routeIs('anggota.riwayat') ? '#C8A850' : 'transparent' }};"
                   onmouseover="this.style.backgroundColor='#504840'" onmouseout="this.style.backgroundColor='{{ request()->routeIs('anggota.riwayat') ? '#C8A850' : 'transparent' }}'">
                    <span class="text-lg">📜</span>
                    <span>Riwayat</span>
                </a>
                <a href="{{ route('anggota.profile') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded text-sm transition {{ request()->routeIs('anggota.profile') ? 'font-semibold' : '' }}"
                   style="color: #F5F2EE; background-color: {{ request()->routeIs('anggota.profile') ? '#C8A850' : 'transparent' }};"
                   onmouseover="this.style.backgroundColor='#504840'" onmouseout="this.style.backgroundColor='{{ request()->routeIs('anggota.profile') ? '#C8A850' : 'transparent' }}'">
                    <span class="text-lg">👤</span>
                    <span>Profil</span>
                </a>
            </nav>
        </div>
        <div class="px-4 py-5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-sm hover:underline transition" style="color: #967830;">Logout</button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">
        <div class="text-center py-5 text-2xl font-bold relative" style="background-color: #C8A850; color: #2A2520;">
            @yield('header')
            <a href="{{ route('anggota.profile') }}" class="absolute right-5 top-1/2 flex items-center gap-2" style="transform:translateY(-50%); text-decoration:none; color: #2A2520;">
                @if(Auth::user()->foto)
                    <img src="{{ asset('images/' . Auth::user()->foto) }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid #2A2520;">
                @else
                    <div style="width:40px; height:40px; border-radius:50%; background:#967830; border:2px solid #2A2520; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:16px; color: #F5F2EE;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <span style="font-size:13px;">{{ Auth::user()->name }}</span>
            </a>
        </div>
        <div class="flex-1 p-6" style="background-color: #F5F2EE;">
            @yield('content')
        </div>
        <div class="h-14" style="background-color: #504840;"></div>
    </div>

</div>

</body>
</html>
