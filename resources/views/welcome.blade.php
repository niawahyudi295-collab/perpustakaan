<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital</title>

    <style>
        body {
            background: linear-gradient(to right, #d19ab9, #f3b6d3);
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            width: 100%;
            text-align: center;
            padding-top: 40px;
        }

        .header {
            background: #b85d9a;
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 0 30px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }

        .card {
            background: #fff;
            margin: 50px auto;
            width: 70%;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .card h2 {
            color: #444;
            margin-bottom: 20px;
        }

        .card p {
            color: #777;
            font-size: 18px;
            margin: 20px 0 30px;
        }

        .img-lib {
            width: 300px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(to right, #7a1d57, #b85d9a);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 18px;
            transition: 0.3s;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>

</head>
<body>

<div class="container">

    <div class="header">
        <h1>SYSTEM PERPUSTAKAAN</h1>
    </div>

    <div class="card">
        <h2>Selamat Datang di System Perpustakaan</h2>

        <!-- GAMBAR -->
        <img src="/images/library.PNG" alt="Perpustakaan" class="img-lib">

        <p>
            Aplikasi ini dirancang untuk mempermudah pengelolaan buku,
            data anggota, dan proses peminjaman di perpustakaan secara efisien.
        </p>

        <a href="/login" class="btn">Mulai Aplikasi</a>
    </div>

</div>

</body>
</html>