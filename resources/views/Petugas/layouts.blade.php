<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Perpustakaan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #fff; }

        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            background: #eeeeee;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar-top { flex: 1; }
        .sidebar h3 {
            font-size: 15px;
            font-weight: bold;
            padding: 0 20px 20px;
            color: #222;
            line-height: 1.4;
        }
        .sidebar h3 small { font-weight: normal; font-size: 12px; color: #888; }

        .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            background: white;
            margin: 0 12px 8px;
            border-radius: 6px;
        }
        .menu a:hover, .menu a.active { background: #ddd; font-weight: bold; }

        .sidebar-footer {
            padding: 20px;
            text-align: left;
        }
        .sidebar-footer form button {
            background: none;
            border: none;
            color: #e53935;
            cursor: pointer;
            font-size: 14px;
        }

        .header {
            margin-left: 230px;
            background: #b57ba6;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 28px;
            font-weight: bold;
            position: relative;
        }
        .header-profile {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: white;
        }
        .header-profile img, .header-profile .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }
        .header-profile .avatar {
            background: rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }
        .content {
            margin-left: 230px;
            padding: 30px;
            min-height: calc(100vh - 70px);
            background: #fff;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-top">
        <h3>{{ Auth::user()->name }}<br><small>({{ ucfirst(Auth::user()->role) }})</small></h3>
        <div class="menu">
            <a href="{{ route('petugas.bukupetugas.index') }}" class="{{ request()->routeIs('petugas.bukupetugas*') ? 'active' : '' }}">📚 Data Buku</a>
            <a href="{{ route('petugas.anggota') }}" class="{{ request()->routeIs('petugas.anggota') ? 'active' : '' }}">👤 Daftar Anggota</a>
            <a href="{{ route('petugas.peminjaman') }}" class="{{ request()->routeIs('petugas.peminjaman*') ? 'active' : '' }}">📥 Peminjaman</a>
            <a href="{{ route('petugas.kategori') }}" class="{{ request()->routeIs('petugas.kategori') ? 'active' : '' }}">📄 Kategori</a>
            <a href="{{ route('petugas.profile') }}" class="{{ request()->routeIs('petugas.profile') ? 'active' : '' }}">👤 Profil</a>
        </div>
    </div>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="header">
    @yield('header')
    <a href="{{ route('petugas.profile') }}" class="header-profile">
        @if(Auth::user()->foto)
            <img src="{{ asset('images/' . Auth::user()->foto) }}" alt="foto">
        @else
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        @endif
        <span style="font-size:13px;">{{ Auth::user()->name }}</span>
    </a>
</div>
<div class="content">@yield('content')</div>

</body>
</html>
