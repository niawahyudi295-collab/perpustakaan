<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    // tampil menu buku
    public function index()
    {
        $buku = DB::table('buku')->get();
        return view('anggota.menu_buku', compact('buku'));
    }

    // pinjam buku (simple)
    public function pinjam($id)
    {
        $buku = DB::table('buku')->where('id_buku', $id)->first();

        // cek buku
        if (!$buku) {
            return redirect('/buku')->with('error', 'Buku tidak ditemukan!');
        }

        // cek stok
        if ($buku->jumlah <= 0) {
            return redirect('/buku')->with('error', 'Stok habis!');
        }

        // kurangi stok aja (tanpa simpan peminjaman dulu)
        DB::table('buku')
            ->where('id_buku', $id)
            ->update([
                'jumlah' => $buku->jumlah - 1
            ]);

        return redirect('/buku')->with('success', 'Buku berhasil dipinjam!');
    }
}