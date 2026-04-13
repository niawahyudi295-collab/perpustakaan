<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    // tampil menu buku
    public function index()
    {
        $buku = DB::table('buku')->get();
        return view('Anggota.menu_buku', compact('buku'));
    } 

    // pinjam buku
    public function pinjam($id)
    {
        $buku = DB::table('buku')->where('id_buku', $id)->first();

        if (!$buku) {
            return redirect('/buku')->with('error', 'Buku tidak ditemukan!');
        }

        if ($buku->jumlah <= 0) {
            return redirect('/buku')->with('error', 'Stok habis!');
        }

        DB::table('buku')
            ->where('id_buku', $id)
            ->update([
                'jumlah' => $buku->jumlah - 1
            ]);

        return redirect('/buku')->with('success', 'Buku berhasil dipinjam!');
    }
}