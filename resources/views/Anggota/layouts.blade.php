<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #8c0e64;
            height: 100vh;
            padding: 20px;
        }

        .sidebar h3 {
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            margin: 10px 0;
            background: #e7dcdc;
            text-decoration: none;
            color: black;
            border-radius: 10px;
        }

        .sidebar a:hover {
            background: #ccc;
        }

        /* MAIN */
        .main {
            flex: 1;
        }

        .header {
            background: #b57aa1;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 20px;
        }
    </style>

</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>System Perpustakaan</h3>
        <a href="#">📚 Menu Buku</a>
        <a href="#">📖 Peminjaman Buku</a>
        <a href="#">📜Daftar Anggota</a>
    </div>

    <!-- MAIN -->
    <div class="main">
        <div class="header">
            @yield('header')
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

</body>
</html>