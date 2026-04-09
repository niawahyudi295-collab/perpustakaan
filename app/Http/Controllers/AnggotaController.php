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
        $dipinjam        = Peminjaman::where('anggota_id', $userId)->whereIn('status', ['dipinjam', 'mengembalikan'])->count();
        $peminjamanAktif = Peminjaman::where('anggota_id', $userId)->where('status', 'dipinjam')->get();

        $totalDenda = Peminjaman::where('anggota_id', $userId)->sum('denda');
        $terdekat   = null;

        foreach ($peminjamanAktif as $p) {
            if (!$p->tgl_jatuh_tempo) continue;
            $tgl = Carbon::parse($p->tgl_jatuh_tempo);
            if (!$terdekat || $tgl->lt(Carbon::parse($terdekat))) {
                $terdekat = $p->tgl_jatuh_tempo;
            }
        }

        $sisaHari  = $terdekat ? (int) now()->diffInDays(Carbon::parse($terdekat), false) : null;
        $aktivitas = Peminjaman::where('anggota_id', $userId)->orderByDesc('created_at')->limit(10)->get();

        return view('Anggota.dashboard', compact('dipinjam', 'totalDenda', 'sisaHari', 'aktivitas'));
    }

    public function menuBuku()
    {
        $buku = Buku::all();
        $jumlahDipinjam = Peminjaman::where('anggota_id', Auth::id())
            ->whereIn('status', ['menunggu', 'dipinjam', 'mengembalikan'])
            ->count();
        return view('Anggota.menu_buku', compact('buku', 'jumlahDipinjam'));
    }

    public function formPinjam($id)
    {
        $buku = Buku::findOrFail($id);
        return view('Anggota.form_pinjam', compact('buku'));
    }

    public function storePinjam(Request $request)
    {
        $request->validate(['buku_id' => 'required|exists:buku,id']);

        $jumlahDipinjam = Peminjaman::where('anggota_id', Auth::id())
            ->whereIn('status', ['menunggu', 'dipinjam', 'mengembalikan'])
            ->count();

        if ($jumlahDipinjam >= 2) {
            return back()->with('error', 'Anda sudah meminjam 2 buku. Kembalikan buku terlebih dahulu sebelum meminjam lagi.');
        }

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku habis, tidak dapat meminjam.');
        }

        $buku->decrement('stok');

        Peminjaman::create([
            'anggota_id' => Auth::id(),
            'judul_buku' => $buku->judul,
            'tgl_pinjam' => now()->toDateString(),
            'status'     => 'menunggu',
        ]);

        return redirect()->route('anggota.peminjaman')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function peminjaman()
    {
        $peminjaman = Peminjaman::where('anggota_id', Auth::id())->orderByDesc('created_at')->get();
        return view('Anggota.peminjaman', compact('peminjaman'));
    }

    public function pengembalian()
    {
        $peminjaman = Peminjaman::where('anggota_id', Auth::id())
                        ->whereIn('status', ['dipinjam', 'mengembalikan'])
                        ->orderByDesc('created_at')->get();
        return view('Anggota.pengembalian', compact('peminjaman'));
    }

    public function riwayat()
    {
        $riwayat = Peminjaman::where('anggota_id', Auth::id())
                    ->orderByDesc('created_at')->get();
        return view('Anggota.riwayat', compact('riwayat'));
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->anggota_id !== Auth::id()) abort(403);
        if ($peminjaman->status !== 'dipinjam') abort(403);
        $peminjaman->update(['status' => 'mengembalikan']);
        return redirect()->route('anggota.pengembalian')->with('success', 'Permintaan pengembalian berhasil diajukan. Menunggu konfirmasi petugas.');
    }

    public function profile()
    {
        return view('Anggota.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'alamat'       => 'required|string|max:500',
            'foto'         => 'nullable|image|max:2048',
            'password'     => 'nullable|min:6|confirmed',
        ], [
            'email.unique'       => 'Email sudah digunakan oleh akun lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = $request->only('name', 'email', 'phone_number', 'alamat');

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $old = public_path('images/' . $user->foto);
                if (file_exists($old)) unlink($old);
            }
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['foto'] = $filename;
        }

        $user->update($data);

        return redirect()->route('anggota.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
