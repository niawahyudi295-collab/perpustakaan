<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $peminjaman = Peminjaman::count();

        $terlambat = Peminjaman::where('tgl_kembali', '<', now())
                                ->where('status', 'dipinjam')
                                ->count();

        return view('petugas.dashboard', compact('peminjaman', 'terlambat'));
    }
}