<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Buku;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    public function dashboard()
    {
        $userId          = Auth::id();
        $dipinjam        = Peminjaman::where('anggota_id', $userId)->where('status', 'dipinjam')->count();
        $peminjamanAktif = Peminjaman::where('anggota_id', $userId)->where('status', 'dipinjam')->get();

        $totalDenda = 0;
        $terdekat   = null;

        foreach ($peminjamanAktif as $p) {
            $tgl = Carbon::parse($p->tgl_jatuh_tempo ?? $p->tgl_kembali);
            if (now()->gt($tgl)) {
                $totalDenda += now()->diffInDays($tgl) * 5000;
            }
            if (!$terdekat || $tgl->lt(Carbon::parse($terdekat))) {
                $terdekat = $p->tgl_jatuh_tempo ?? $p->tgl_kembali;
            }
        }

        $sisaHari  = $terdekat ? now()->diffInDays(Carbon::parse($terdekat), false) : null;
        $aktivitas = Peminjaman::with('anggota')->orderByDesc('created_at')->limit(10)->get();

        return view('Anggota.dashboard', compact('dipinjam', 'totalDenda', 'sisaHari', 'aktivitas'));
    }

    public function menuBuku()
    {
        $buku = Buku::all();
        return view('Anggota.menu_buku', compact('buku'));
    }

    public function formPinjam($id)
    {
        $buku = Buku::findOrFail($id);
        return view('Anggota.form_pinjam', compact('buku'));
    }

    public function storePinjam(Request $request)
    {
        $request->validate([
            'buku_id'     => 'required|exists:buku,id',
            'tgl_kembali' => 'required|date|after:today|before_or_equal:' . now()->addDays(20)->toDateString(),
        ], [
            'tgl_kembali.before_or_equal' => 'Maksimal peminjaman adalah 20 hari (sampai ' . now()->addDays(20)->format('d/m/Y') . ').',
            'tgl_kembali.after'           => 'Tanggal kembali harus setelah hari ini.',
        ]);

        $tglKembali    = Carbon::parse($request->tgl_kembali);
        $tglJatuhTempo = $tglKembali->copy()->addDays(3)->toDateString();

        Peminjaman::create([
            'anggota_id'      => Auth::id(),
            'judul_buku'      => Buku::find($request->buku_id)->judul,
            'tgl_pinjam'      => now()->toDateString(),
            'tgl_kembali'     => $request->tgl_kembali,
            'tgl_jatuh_tempo' => $tglJatuhTempo,
            'status'          => 'menunggu',
        ]);

        return redirect()->route('anggota.peminjaman')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function peminjaman()
    {
        $peminjaman = Peminjaman::where('anggota_id', Auth::id())->orderByDesc('created_at')->get();
        return view('Anggota.peminjaman', compact('peminjaman'));
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->anggota_id !== Auth::id()) abort(403);
        $peminjaman->update(['status' => 'dikembalikan']);
        return redirect()->route('anggota.peminjaman')->with('success', 'Buku berhasil dikembalikan.');
    }
}
