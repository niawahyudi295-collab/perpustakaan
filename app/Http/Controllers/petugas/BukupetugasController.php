<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukupetugasController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('petugas.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('petugas.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        return view('petugas.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'jumlah' => 'required|numeric',
        ]);

        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}