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
                <a href="{{ route('kepala.profile') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded text-sm text-gray-700 hover:bg-gray-300 transition {{ request()->routeIs('kepala.profile') ? 'bg-gray-300 font-semibold' : 'bg-white' }}">
                    <span>👤</span> Profil
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
        <div style="background-color:#b57ba6; color:white; text-align:center; padding:20px; font-size:28px; font-weight:bold; position:relative;">
            @yield('header')
            <a href="{{ route('kepala.profile') }}" style="position:absolute; right:20px; top:50%; transform:translateY(-50%); display:flex; align-items:center; gap:8px; text-decoration:none; color:white;">
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
        <div class="flex-1 p-8 bg-white">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
