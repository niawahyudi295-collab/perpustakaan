<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuPetugasController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('petugas.bukupetugas.index', compact('buku'));
    }

    public function create()
    {
        return view('petugas.bukupetugas.create');
    }

    public function store(Request $request)
    {
        Buku::create($request->all());
        return redirect()->route('bukupetugas.index');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('petugas.bukupetugas.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('bukupetugas.index');
    }

    public function destroy($id)
    {
        Buku::destroy($id);
        return redirect()->route('bukupetugas.index');
    }
}