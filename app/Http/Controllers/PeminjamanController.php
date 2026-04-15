<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // 📌 HALAMAN LIST
    public function index()
    {
        $peminjaman = [
            (object)[
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'tgl_pinjam' => '2026-03-30',
                'tgl_kembali' => '2026-04-05',
                'status' => 'dipinjam',
                'denda' => 5000,
                'nama' => 'Budi'
            ],
            (object)[
                'id' => 2,
                'judul' => 'Bumi',
                'tgl_pinjam' => '2026-03-25',
                'tgl_kembali' => '2026-03-30',
                'status' => 'kembali',
                'denda' => 0,
                'nama' => 'Siti'
            ]
        ];

        return view('Anggota.peminjaman', compact('peminjaman'));
    }

    // 📌 HALAMAN FORM
    public function create()
    {
        return view('Anggota.create_peminjaman');
    }

    // 📌 SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
        ]);

        dd($request->all());
    }

    // 📌 CETAK STRUK
    public function cetak($id)
    {
        $data = [
            1 => (object)[
                'id' => 1,
                'judul' => 'Laskar Pelangi',
                'tgl_pinjam' => '2026-03-30',
                'tgl_kembali' => '2026-04-05',
                'denda' => 5000,
                'nama' => 'Budi'
            ],
            2 => (object)[
                'id' => 2,
                'judul' => 'Bumi',
                'tgl_pinjam' => '2026-03-25',
                'tgl_kembali' => '2026-03-30',
                'denda' => 0,
                'nama' => 'Siti'
            ]
        ];

        // 🔒 cek data ada atau tidak
        if (!array_key_exists($id, $data)) {
            abort(404);
        }

        $peminjaman = $data[$id];

        return view('petugas.peminjaman.cetak', compact('peminjaman'));
    }
}