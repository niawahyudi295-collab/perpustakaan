<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class KepalaController extends Controller
{
    public function profile()
    {
        return view('Kepala.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'foto'         => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'email', 'phone_number');

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $old = public_path('images/' . $user->foto);
                if (file_exists($old)) unlink($old);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['foto'] = $filename;
        }

        $user->update($data);
        return redirect()->route('kepala.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function dashboard()
    {
        return view('Kepala.dashboard');
    }

    public function katalog()
    {
        $buku = Buku::all();
        return view('Kepala.katalog', compact('buku'));
    }

    public function indexAnggota()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('Kepala.anggota', compact('anggota'));
    }

    public function indexPetugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('Kepala.petugas.index', compact('petugas'));
    }

    public function createPetugas()
    {
        return view('Kepala.petugas.create');
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        return redirect()->route('kepala.petugas.index')->with('success', 'Akun petugas berhasil ditambahkan.');
    }

    public function editPetugas(User $petugas)
    {
        return view('Kepala.petugas.edit', compact('petugas'));
    }

    public function updatePetugas(Request $request, User $petugas)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $petugas->id,
        ]);

        $petugas->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $petugas->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('kepala.petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroyPetugas(User $petugas)
    {
        $petugas->delete();
        return redirect()->route('kepala.petugas.index')->with('success', 'Akun petugas berhasil dihapus.');
    }

    // ===== LAPORAN =====
    public function laporan()
    {
        $data = Peminjaman::with('anggota')->orderByDesc('created_at')->get()
            ->map(function ($p) {
                $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo ?? \Carbon\Carbon::parse($p->tgl_kembali)->addDays(3));
                $hariTerlambat = ($p->status === 'dipinjam' && now()->gt($tglJatuhTempo))
                    ? now()->diffInDays($tglJatuhTempo) : 0;
                $p->denda = $hariTerlambat * 5000;
                $p->hari_terlambat = $hariTerlambat;
                $p->tgl_jatuh_tempo_parsed = $tglJatuhTempo;
                return $p;
            });

        return view('Kepala.laporan', compact('data'));
    }

    public function detailLaporan(Peminjaman $peminjaman)
    {
        $tglKembali    = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
        $hariTerlambat = ($peminjaman->status === 'dipinjam' && now()->gt($tglKembali))
            ? now()->diffInDays($tglKembali) : 0;
        $peminjaman->denda         = $hariTerlambat * 5000;
        $peminjaman->hari_terlambat = $hariTerlambat;
        $peminjaman->load('anggota');

        return view('Kepala.laporan_detail', compact('peminjaman'));
    }

    public function cetakPdf(Peminjaman $peminjaman)
    {
        $tglKembali    = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
        $hariTerlambat = ($peminjaman->status === 'dipinjam' && now()->gt($tglKembali))
            ? now()->diffInDays($tglKembali) : 0;
        $peminjaman->denda         = $hariTerlambat * 5000;
        $peminjaman->hari_terlambat = $hariTerlambat;
        $peminjaman->load('anggota');

        $pdf = Pdf::loadView('Kepala.laporan_pdf', compact('peminjaman'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-peminjaman-' . $peminjaman->id . '.pdf');
    }
}
