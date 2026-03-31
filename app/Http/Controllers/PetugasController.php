<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index()
    {
        // contoh data (bisa kamu ganti dari database)
        $peminjaman = DB::table('peminjaman')->count();
        $terlambat = DB::table('peminjaman')
                        ->where('status', 'terlambat')
                        ->count();

        return view('petugas.dashboard', compact('peminjaman', 'terlambat'));
    }
}