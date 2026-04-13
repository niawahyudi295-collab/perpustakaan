<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // HALAMAN LIST
    public function index()
    {
        $peminjaman = [
            (object)[
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'tgl_pinjam' => '2026-03-30',
                'tgl_kembali' => '2026-04-05',
                'status' => 'dipinjam'
            ],
            (object)[
                'id' => 2,
                'judul' => 'Bumi',
                'tgl_pinjam' => '2026-03-25',
                'tgl_kembali' => '2026-03-30',
                'status' => 'kembali'
            ]
        ];

        return view('Anggota.peminjaman', compact('peminjaman'));
    }

    // HALAMAN FORM
    public function create()
    {
        return view('Anggota.create_peminjaman');
    }


    // SIMPAN DATA
    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'judul' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
        ]);

        // Cek data masuk (sementara)
        dd($request->all());

        // Nanti kalau sudah pakai database, baru simpan di sini
    }
}