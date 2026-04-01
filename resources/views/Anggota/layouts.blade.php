<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandPink: '#cc7dae',
                        bgSoftPink: '#f8ebf1',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-pink-800 min-h-screen p-5 text-white">
        <h3 class="text-center font-bold mb-6">System Perpustakaan</h3>

        <a href="/buku" class="block bg-gray-200 text-black p-3 mb-3 rounded">📚 Menu Buku</a>
        <a href="/peminjaman" class="block bg-gray-200 text-black p-3 mb-3 rounded">📖 Peminjaman Buku</a>
        <a href="#" class="block bg-gray-200 text-black p-3 rounded">📜 Daftar Anggota</a>
    </aside>

    <!-- MAIN -->
    <div class="flex-1">

        <!-- HEADER -->
        <div class="bg-brandPink text-white text-center p-5 text-2xl font-bold">
            @yield('header')
        </div>

        <!-- CONTENT -->
        <div class="p-6 bg-bgSoftPink min-h-screen">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>