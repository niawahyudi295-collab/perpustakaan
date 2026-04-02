<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            background: #eee;
            padding-top: 20px;
        }

        .sidebar h3 {
            text-align: center;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            text-decoration: none;
            color: black;
        }

        .menu a:hover {
            background: #ddd;
        }

        /* HEADER */
        .header {
            margin-left: 230px;
            background: #b57ba6;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 30px;
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            margin-left: 230px;
            padding: 30px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>System<br>Perpustakaan</h3>

    <div class="menu">
        
        <a href="{{ route('bukupetugas.index') }}">📚 Data Buku</a>
        <a href="#">👤 Daftar Anggota</a>
        <a href="#">📥 Peminjaman</a>
        <a href="#">📄 Kategori</a>
    </div>
</div>

<!-- HEADER -->
<div class="header">
    @yield('header')
</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

</body>
</html>