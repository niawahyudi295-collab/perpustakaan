<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $peminjaman = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat  = Peminjaman::where('status', 'dipinjam')
                        ->where('tgl_kembali', '<', now()->toDateString())
                        ->count();

        return view('petugas.dashboard', compact('peminjaman', 'terlambat'));
    }

    // ===== DAFTAR ANGGOTA =====
    public function anggota()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('petugas.anggota', compact('anggota'));
    }

    // ===== PEMINJAMAN =====
    public function peminjaman()
    {
        $peminjaman = Peminjaman::with('anggota')->orderByDesc('created_at')->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dikembalikan']);
        return redirect()->route('petugas.peminjaman')->with('success', 'Buku berhasil dikembalikan.');
    }

    public function konfirmasi(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dipinjam']);
        return redirect()->route('petugas.peminjaman')->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    // ===== KATEGORI CRUD =====
    public function kategori()
    {
        $kategori = Kategori::orderBy('nama')->get();
        return view('petugas.kategori', compact('kategori'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:kategoris,nama']);
        Kategori::create(['nama' => $request->nama]);
        return redirect()->route('petugas.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, Kategori $kategori)
    {
        $request->validate(['nama' => 'required|string|unique:kategoris,nama,' . $kategori->id]);
        $kategori->update(['nama' => $request->nama]);
        return redirect()->route('petugas.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('petugas.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
