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
    // =========================================================
    // HELPER — satu tempat untuk semua logika hitung denda
    // CATATAN: Menggunakan denda dari database (input petugas),
    // breakdown dihitung hanya untuk info display
    // =========================================================
    private function hitungDenda(Peminjaman $p): array
    {
        $hariTerlambat      = 0;
        $dendaKeterlambatan = 0;
        $dendaKondisi       = 0;

        // 1. Hitung hari terlambat (untuk display info saja)
        if ($p->tgl_jatuh_tempo) {
            $jatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo)->startOfDay();

            if ($p->status === 'dipinjam') {
                $acuan = now()->startOfDay();
            } else {
                $acuan = \Carbon\Carbon::parse($p->tgl_kembali)->startOfDay();
            }

            $hariTerlambat      = max(0, (int) $jatuhTempo->diffInDays($acuan, false) * -1);
            $dendaKeterlambatan = $hariTerlambat * 2000;
        }

        // 2. Hitung denda kondisi dari status (untuk display info saja)
        if ($p->kondisi === 'hilang') {
            $dendaKondisi = 50000;
        } elseif ($p->kondisi === 'rusak') {
            $dendaKondisi = 20000;
        }

        // 3. TOTAL DENDA DARI DATABASE (input petugas), bukan hasil perhitungan
        $totalDenda = (int) ($p->denda ?? 0);

        return [
            'hari_terlambat'      => $hariTerlambat,
            'denda_keterlambatan' => $dendaKeterlambatan,
            'denda_kondisi'       => $dendaKondisi,
            'total_denda'         => $totalDenda,  // ← DARI DATABASE
        ];
    }

    // =========================================================
    // DASHBOARD
    // =========================================================
    public function dashboard()
    {
        $totalAnggota   = User::where('role', 'anggota')->count();
        $totalPetugas   = User::where('role', 'petugas')->count();
        $totalBuku      = Buku::count();
        $totalPinjam    = Peminjaman::whereIn('status', ['dipinjam', 'mengembalikan'])->count();
        $totalTerlambat = Peminjaman::where('status', 'dipinjam')
                            ->whereNotNull('tgl_jatuh_tempo')
                            ->where('tgl_jatuh_tempo', '<', now()->toDateString())
                            ->count();

        // Jumlah total denda dari semua peminjaman (hitung ulang, bukan ambil kolom lama)
        $totalDenda = Peminjaman::all()->sum(function ($p) {
            return $this->hitungDenda($p)['total_denda'];
        });

        $transaksiTerbaru = Peminjaman::with('anggota')->orderByDesc('created_at')->limit(5)->get();

        return view('Kepala.dashboard', compact(
            'totalAnggota', 'totalPetugas', 'totalBuku',
            'totalPinjam', 'totalTerlambat', 'totalDenda', 'transaksiTerbaru'
        ));
    }

    // =========================================================
    // LAPORAN — daftar semua peminjaman
    // =========================================================
    public function laporan()
    {
        $data = Peminjaman::with('anggota')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($p) {
                $hasil = $this->hitungDenda($p);
                $p->hari_terlambat      = $hasil['hari_terlambat'];
                $p->denda_keterlambatan = $hasil['denda_keterlambatan'];
                $p->denda_kondisi       = $hasil['denda_kondisi'];
                $p->denda               = $hasil['total_denda'];
                return $p;
            });

        return view('Kepala.laporan', compact('data'));
    }

    // =========================================================
    // DETAIL LAPORAN — satu peminjaman
    // =========================================================
    public function detailLaporan(Peminjaman $peminjaman)
    {
        $hasil = $this->hitungDenda($peminjaman);
        $peminjaman->hari_terlambat      = $hasil['hari_terlambat'];
        $peminjaman->denda_keterlambatan = $hasil['denda_keterlambatan'];
        $peminjaman->denda_kondisi       = $hasil['denda_kondisi'];
        $peminjaman->denda               = $hasil['total_denda'];

        $peminjaman->load('anggota');
        return view('Kepala.laporan_detail', compact('peminjaman'));
    }

    // =========================================================
    // CETAK PDF — semua laporan
    // =========================================================
    public function cetakPdfLaporan()
    {
        $data = Peminjaman::with('anggota')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($p) {
                $hasil = $this->hitungDenda($p);
                $p->hari_terlambat      = $hasil['hari_terlambat'];
                $p->denda_keterlambatan = $hasil['denda_keterlambatan'];
                $p->denda_kondisi       = $hasil['denda_kondisi'];
                $p->denda               = $hasil['total_denda'];
                return $p;
            });

        $pdf = Pdf::loadView('Kepala.laporan_cetak_pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('d-m-Y') . '.pdf');
    }

    // =========================================================
    // CETAK PDF — satu peminjaman
    // =========================================================
    public function cetakPdf(Peminjaman $peminjaman)
    {
        $hasil = $this->hitungDenda($peminjaman);
        $peminjaman->hari_terlambat      = $hasil['hari_terlambat'];
        $peminjaman->denda_keterlambatan = $hasil['denda_keterlambatan'];
        $peminjaman->denda_kondisi       = $hasil['denda_kondisi'];
        $peminjaman->denda               = $hasil['total_denda'];

        $peminjaman->load('anggota');

        $pdf = Pdf::loadView('Kepala.laporan_pdf', compact('peminjaman'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-peminjaman-' . $peminjaman->id . '.pdf');
    }

    // =========================================================
    // METHOD LAIN (tidak berubah)
    // =========================================================
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
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['foto'] = $filename;
        }

        $user->update($data);
        return redirect()->route('kepala.profile')->with('success', 'Profil berhasil diperbarui.');
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

        $petugas->update(['name' => $request->name, 'email' => $request->email]);

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
}