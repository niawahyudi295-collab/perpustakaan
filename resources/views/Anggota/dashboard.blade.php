@extends('Anggota.layouts')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandPink: '#cc7dae',
                        bgSoftPink: '#f8ebf1',
                        iconRed: '#aa1f11',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="flex">

    <!-- SIDEBAR (tetap) -->
    <aside class="w-64 bg-white min-h-screen border-r">
        <div class="p-5 bg-gray-200 text-center font-semibold uppercase text-sm">
            System <br> Perpustakaan
        </div>

        <nav class="mt-3">
            <a href="#" class="flex px-6 py-4 border-b">📚 Data Buku</a>
            <a href="#" class="flex px-6 py-4 border-b">📖 Peminjaman Buku</a>
            <a href="#" class="flex px-6 py-4 border-b">📜 Daftar Anggota</a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 bg-bgSoftPink/60">

        <!-- HEADER -->
        <header class="bg-brandPink p-6 text-center">
            <h1 class="text-white text-3xl font-bold">Dashboard</h1>
        </header>

        <!-- CONTENT -->
        <div class="p-8">

            <!-- CARD INFO -->
            <div class="grid grid-cols-3 gap-6 mb-10">

                <!-- Buku Dipinjam -->
                <div class="bg-white p-6 rounded-xl shadow text-center">
                    <h2 class="text-gray-500">Buku Dipinjam</h2>
                    <p class="text-3xl font-bold text-brandPink mt-2">3</p>
                </div>

                <!-- Jatuh Tempo -->
                <div class="bg-white p-6 rounded-xl shadow text-center">
                    <h2 class="text-gray-500">Jatuh Tempo</h2>
                    <p class="text-3xl font-bold text-yellow-500 mt-2">2 Hari Lagi</p>
                </div>

                <!-- Denda -->
                <div class="bg-white p-6 rounded-xl shadow text-center">
                    <h2 class="text-gray-500">Denda</h2>
                    <p class="text-3xl font-bold text-red-500 mt-2">Rp 5.000</p>
                </div>

            </div>

            <!-- TABEL BUKU DIPINJAM -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Buku yang Sedang Dipinjam</h2>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Judul Buku</th>
                            <th class="py-2">Tanggal Pinjam</th>
                            <th class="py-2">Jatuh Tempo</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2">Laskar Pelangi</td>
                            <td>20 Feb 2026</td>
                            <td>27 Feb 2026</td>
                            <td class="text-green-600">Dipinjam</td>
                        </tr>

                        <tr class="border-b">
                            <td class="py-2">Bumi Manusia</td>
                            <td>18 Feb 2026</td>
                            <td>25 Feb 2026</td>
                            <td class="text-red-500">Terlambat</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </main>

</div>

</body>
</html>