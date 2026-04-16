<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

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

    //  HALAMAN FORM
    public function create()
    {
        return view('Anggota.create_peminjaman');
    }

    //  SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_kembali' => 'required',
        ]);

        dd($request->all());
    }

    // CETAK STRUK
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

        //  cek data ada atau tidak
        if (!array_key_exists($id, $data)) {
            abort(404);
        }

        $peminjaman = $data[$id];

        return view('petugas.peminjaman.cetak', compact('peminjaman'));
    }

    //  ANGGOTA BAYAR DENDA
    public function bayarDenda(Peminjaman $peminjaman)
    {
        // Cek apakah anggota yang login adalah pemilik peminjaman
        if ($peminjaman->anggota_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah peminjaman ada denda dan belum dibayar
        if ($peminjaman->denda <= 0) {
            return back()->with('error', 'Tidak ada denda untuk pembayaran.');
        }

        if ($peminjaman->status_pembayaran === 'lunas') {
            return back()->with('error', 'Denda sudah lunas.');
        }

        // Update status pembayaran menjadi pending_konfirmasi
        $peminjaman->update([
            'status_pembayaran' => 'pending_konfirmasi',
            'tgl_pembayaran' => now(),
        ]);

        return redirect()->route('anggota.peminjaman')->with('success', 'Permintaan pembayaran denda berhasil diajukan. Menunggu konfirmasi petugas.');
    }

    //  PETUGAS KONFIRMASI PEMBAYARAN DENDA
    public function konfirmasiDenda(Peminjaman $peminjaman)
    {
        // Cek status pembayaran
        if ($peminjaman->status_pembayaran !== 'pending_konfirmasi') {
            return back()->with('error', 'Status pembayaran tidak valid.');
        }

        // Konfirmasi pembayaran
        $peminjaman->update([
            'status_pembayaran' => 'lunas',
            'tgl_konfirmasi_pembayaran' => now(),
        ]);

        return redirect()->route('petugas.peminjaman')->with('success', 'Pembayaran denda berhasil dikonfirmasi. Status denda: LUNAS');
    }
}