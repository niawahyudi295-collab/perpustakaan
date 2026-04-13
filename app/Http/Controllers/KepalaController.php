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
            'password'     => 'nullable|min:6|confirmed',
        ], [
            'email.unique'        => 'Email sudah digunakan oleh akun lain.',
            'password.min'        => 'Password minimal 6 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        $data = $request->only('name', 'email', 'phone_number');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

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
        $totalAnggota  = User::where('role', 'anggota')->count();
        $totalPetugas  = User::where('role', 'petugas')->count();
        $totalBuku     = Buku::count();
        $totalPinjam   = Peminjaman::whereIn('status', ['dipinjam', 'mengembalikan'])->count();
        $totalTerlambat = Peminjaman::where('status', 'dipinjam')
                            ->whereNotNull('tgl_jatuh_tempo')
                            ->where('tgl_jatuh_tempo', '<', now()->toDateString())
                            ->count();
        $totalDenda    = Peminjaman::sum('denda');
        $transaksiTerbaru = Peminjaman::with('anggota')->orderByDesc('created_at')->limit(5)->get();
        return view('Kepala.dashboard', compact('totalAnggota', 'totalPetugas', 'totalBuku', 'totalPinjam', 'totalTerlambat', 'totalDenda', 'transaksiTerbaru'));
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
        ], [
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
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
                // Skip jika tgl_jatuh_tempo belum diisi (status masih 'menunggu')
                if (!$p->tgl_jatuh_tempo) {
                    $p->denda = 0;
                    $p->hari_terlambat = 0;
                    return $p;
                }
                
                $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo);
                
                if ($p->status === 'dipinjam') {
                    // Untuk buku yang masih dipinjam, hitung keterlambatan dari sekarang
                    $hariTerlambat = now()->gt($tglJatuhTempo)
                        ? now()->diffInDays($tglJatuhTempo) : 0;
                    $p->denda = $hariTerlambat * 2000;
                } elseif ($p->status === 'dikembalikan') {
                    // Untuk buku yang sudah dikembalikan, gunakan nilai denda yang sudah disimpan
                    $p->denda = $p->denda ?? 0;
                    if (!$p->denda && $p->tgl_kembali) {
                        // Hitung ulang jika belum ada denda
                        $tglKembali = \Carbon\Carbon::parse($p->tgl_kembali);
                        $hariTerlambat = $tglKembali->gt($tglJatuhTempo)
                            ? $tglKembali->diffInDays($tglJatuhTempo) : 0;
                        $p->denda = $hariTerlambat * 2000;
                    }
                } else {
                    $p->denda = 0;
                }
                
                $p->hari_terlambat = $p->denda > 0 ? intval($p->denda / 2000) : 0;
                return $p;
            });

        return view('Kepala.laporan', compact('data'));
    }

    public function detailLaporan(Peminjaman $peminjaman)
    {
        // Skip jika tgl_jatuh_tempo belum diisi
        if (!$peminjaman->tgl_jatuh_tempo) {
            $peminjaman->denda = 0;
            $peminjaman->hari_terlambat = 0;
        } else {
            $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo);
            
            if ($peminjaman->status === 'dipinjam') {
                // Untuk buku yang masih dipinjam, hitung keterlambatan dari sekarang
                $hariTerlambat = now()->gt($tglJatuhTempo)
                    ? now()->diffInDays($tglJatuhTempo) : 0;
                $peminjaman->denda = $hariTerlambat * 2000;
            } elseif ($peminjaman->status === 'dikembalikan') {
                // Untuk buku yang sudah dikembalikan, gunakan nilai denda yang ada
                $peminjaman->denda = $peminjaman->denda ?? 0;
                if (!$peminjaman->denda && $peminjaman->tgl_kembali) {
                    $tglKembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
                    $hariTerlambat = $tglKembali->gt($tglJatuhTempo)
                        ? $tglKembali->diffInDays($tglJatuhTempo) : 0;
                    $peminjaman->denda = $hariTerlambat * 2000;
                }
            } else {
                $peminjaman->denda = 0;
            }
            
            $peminjaman->hari_terlambat = $peminjaman->denda > 0 ? intval($peminjaman->denda / 2000) : 0;
        }
        
        $peminjaman->load('anggota');

        return view('Kepala.laporan_detail', compact('peminjaman'));
    }

    public function cetakPdfLaporan()
    {
        $data = Peminjaman::with('anggota')->orderByDesc('created_at')->get()
            ->map(function ($p) {
                // Skip jika tgl_jatuh_tempo belum diisi
                if (!$p->tgl_jatuh_tempo) {
                    $p->denda = 0;
                    $p->hari_terlambat = 0;
                    return $p;
                }
                
                $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo);
                
                if ($p->status === 'dipinjam') {
                    // Untuk buku yang masih dipinjam, hitung keterlambatan dari sekarang
                    $hariTerlambat = now()->gt($tglJatuhTempo)
                        ? now()->diffInDays($tglJatuhTempo) : 0;
                    $p->denda = $hariTerlambat * 2000;
                } elseif ($p->status === 'dikembalikan') {
                    // Untuk buku yang sudah dikembalikan, gunakan nilai denda yang sudah disimpan
                    $p->denda = $p->denda ?? 0;
                    if (!$p->denda && $p->tgl_kembali) {
                        $tglKembali = \Carbon\Carbon::parse($p->tgl_kembali);
                        $hariTerlambat = $tglKembali->gt($tglJatuhTempo)
                            ? $tglKembali->diffInDays($tglJatuhTempo) : 0;
                        $p->denda = $hariTerlambat * 2000;
                    }
                } else {
                    $p->denda = 0;
                }
                
                $p->hari_terlambat = $p->denda > 0 ? intval($p->denda / 2000) : 0;
                return $p;
            });
        
        $pdf  = Pdf::loadView('Kepala.laporan_cetak_pdf', compact('data'))
                   ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-peminjaman-' . now()->format('d-m-Y') . '.pdf');
    }

    public function cetakPdf(Peminjaman $peminjaman)
    {
        // Skip jika tgl_jatuh_tempo belum diisi
        if (!$peminjaman->tgl_jatuh_tempo) {
            $peminjaman->denda = 0;
            $peminjaman->hari_terlambat = 0;
        } else {
            $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo);
            
            if ($peminjaman->status === 'dipinjam') {
                // Untuk buku yang masih dipinjam, hitung keterlambatan dari sekarang
                $hariTerlambat = now()->gt($tglJatuhTempo)
                    ? now()->diffInDays($tglJatuhTempo) : 0;
                $peminjaman->denda = $hariTerlambat * 2000;
            } elseif ($peminjaman->status === 'dikembalikan') {
                // Untuk buku yang sudah dikembalikan, gunakan nilai denda yang ada
                $peminjaman->denda = $peminjaman->denda ?? 0;
                if (!$peminjaman->denda && $peminjaman->tgl_kembali) {
                    $tglKembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
                    $hariTerlambat = $tglKembali->gt($tglJatuhTempo)
                        ? $tglKembali->diffInDays($tglJatuhTempo) : 0;
                    $peminjaman->denda = $hariTerlambat * 2000;
                }
            } else {
                $peminjaman->denda = 0;
            }
            
            $peminjaman->hari_terlambat = $peminjaman->denda > 0 ? intval($peminjaman->denda / 2000) : 0;
        }
        
        $peminjaman->load('anggota');

        $pdf = Pdf::loadView('Kepala.laporan_pdf', compact('peminjaman'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-peminjaman-' . $peminjaman->id . '.pdf');
    }
}
