<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuPetugasController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('petugas.bukupetugas.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama')->get();
        return view('petugas.bukupetugas.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|unique:buku,judul',
            'kategori' => 'required',
            'penulis'  => 'required',
            'penerbit' => 'required',
            'tahun'    => 'required|integer',
            'stok'     => 'required|integer',
            'cover'    => 'required|image|max:2048',
        ]);

        $file     = $request->file('cover');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);

        Buku::create([
            'judul'     => $request->judul,
            'kategori'  => $request->kategori,
            'penulis'   => $request->penulis,
            'pengarang' => $request->penulis,
            'penerbit'  => $request->penerbit,
            'tahun'     => $request->tahun,
            'stok'      => $request->stok,
            'jumlah'    => $request->stok,
            'cover'     => $filename,
        ]);

        return redirect()->route('petugas.bukupetugas.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $buku     = Buku::findOrFail($id);
        $kategori = Kategori::orderBy('nama')->get();
        return view('petugas.bukupetugas.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'    => 'required|unique:buku,judul,' . $id,
            'kategori' => 'required',
            'penulis'  => 'required',
            'penerbit' => 'required',
            'tahun'    => 'required|integer',
            'stok'     => 'required|integer',
            'cover'    => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'kategori', 'penulis', 'penerbit', 'tahun', 'stok']);
        $data['pengarang'] = $request->penulis;
        $data['jumlah']    = $request->stok;

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                $oldPath = public_path('images/' . $buku->cover);
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $file     = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['cover'] = $filename;
        }

        $buku->update($data);
        return redirect()->route('petugas.bukupetugas.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover) {
            $oldPath = public_path('images/' . $buku->cover);
            if (file_exists($oldPath)) unlink($oldPath);
        }
        $buku->delete();
        return redirect()->route('petugas.bukupetugas.index')->with('success', 'Buku berhasil dihapus.');
    }
}
