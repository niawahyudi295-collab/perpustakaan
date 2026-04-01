<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function dashboard()
{
    return view('anggota.dashboard');
}

public function menuBuku()
{
    return view('anggota.menu_buku');
}

public function peminjaman()
{
    return view('anggota.peminjaman');
}

public function anggota()
{
    return view('anggota.daftar_anggota');
}
}