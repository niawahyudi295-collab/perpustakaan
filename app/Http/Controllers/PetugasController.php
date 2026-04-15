<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;

class PetugasController extends Controller
{
    public function profile()
    {
        return view('petugas.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        set_time_limit(120);

        $user = Auth::user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'     => 'nullable|min:6|confirmed',
        ], [
            'email.unique'       => 'Email sudah digunakan oleh akun lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
            'foto.mimes'         => 'Format foto harus jpg, jpeg, png, atau webp.',
        ]);

        $data = $request->only('name', 'email', 'phone_number');

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $old = public_path('images/' . $user->foto);
                if (file_exists($old)) {
                    unlink($old);
                }
            }

            $file         = $request->file('foto');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension    = $file->getClientOriginalExtension();
            $cleanName    = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
            $filename     = time() . '_' . $cleanName . '.' . $extension;

            $destination = public_path('images');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['foto'] = $filename;
        }

        $user->update($data);

        return redirect()->route('petugas.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function dashboard()
    {
        $peminjaman    = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat     = Peminjaman::where('status', 'dipinjam')
                            ->whereNotNull('tgl_jatuh_tempo')
                            ->where('tgl_jatuh_tempo', '<', now()->toDateString())
                            ->count();
        $mengembalikan = Peminjaman::where('status', 'mengembalikan')->count();
        $menunggu      = Peminjaman::where('status', 'menunggu')->count();
        $totalDenda    = Peminjaman::sum('denda');

        // ✅ TAMBAHAN: hitung buku rusak & hilang untuk dashboard
        $bukuRusak  = Peminjaman::where('kondisi', 'rusak')->count();
        $bukuHilang = Peminjaman::where('kondisi', 'hilang')->count();

        $transaksiTerbaru = Peminjaman::with('anggota')->orderByDesc('created_at')->limit(5)->get()
            ->map(function ($t) {
                if (!$t->tgl_jatuh_tempo) {
                    $t->hari_terlambat = 0;
                } elseif ($t->status === 'dipinjam') {
                    $tglJatuhTempo = \Carbon\Carbon::parse($t->tgl_jatuh_tempo);
                    $t->hari_terlambat = now()->gt($tglJatuhTempo) ? now()->diffInDays($tglJatuhTempo) : 0;
                } else {
                    $t->hari_terlambat = 0;
                }
                return $t;
            });

        return view('petugas.dashboard', compact(
            'peminjaman', 'terlambat', 'mengembalikan', 'menunggu',
            'totalDenda', 'transaksiTerbaru', 'bukuRusak', 'bukuHilang'
        ));
    }

    // ===== DAFTAR ANGGOTA =====
    public function anggota()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('petugas.anggota', compact('anggota'));
    }

    public function editAnggota(User $user)
    {
        return view('petugas.anggota_edit', compact('user'));
    }

    public function updateAnggota(Request $request, User $user)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'alamat'       => 'nullable|string|max:500',
        ]);

        $user->update($request->only('name', 'email', 'phone_number', 'alamat'));
        return redirect()->route('petugas.anggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroyAnggota(User $user)
    {
        $user->delete();
        return redirect()->route('petugas.anggota')->with('success', 'Anggota berhasil dihapus.');
    }

    // ===== PEMINJAMAN =====
    public function peminjaman()
    {
        $peminjaman = Peminjaman::with('anggota')->orderByDesc('created_at')->get()
            ->map(function ($p) {
                if (!$p->tgl_jatuh_tempo) {
                    $p->hari_terlambat = 0;
                } elseif ($p->status === 'dipinjam') {
                    $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo);
                    $p->hari_terlambat = now()->gt($tglJatuhTempo) ? now()->diffInDays($tglJatuhTempo) : 0;
                } elseif ($p->status === 'dikembalikan' && $p->tgl_kembali) {
                    $tglJatuhTempo = \Carbon\Carbon::parse($p->tgl_jatuh_tempo);
                    $tglKembali    = \Carbon\Carbon::parse($p->tgl_kembali);
                    $p->hari_terlambat = $tglKembali->gt($tglJatuhTempo) ? $tglKembali->diffInDays($tglJatuhTempo) : 0;
                } else {
                    $p->hari_terlambat = 0;
                }
                return $p;
            });

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function createPeminjaman()
    {
        $anggota = User::where('role', 'anggota')->get();
        $buku    = Buku::where('stok', '>', 0)->get();
        return view('petugas.peminjaman.create', compact('anggota', 'buku'));
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'judul_buku' => 'required|string',
            'tgl_pinjam' => 'required|date',
        ]);

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'judul_buku' => $request->judul_buku,
            'tgl_pinjam' => $request->tgl_pinjam,
            'status'     => 'menunggu',
            'kondisi'    => 'baik', // default kondisi
        ]);

        return redirect()->route('petugas.peminjaman')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function konfirmasi(Peminjaman $peminjaman)
    {
        $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->addDays(5)->toDateString();
        $peminjaman->update([
            'status'          => 'dipinjam',
            'tgl_jatuh_tempo' => $tglJatuhTempo,
        ]);
        return redirect()->route('petugas.peminjaman')->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    public function konfirmasiKembali(Peminjaman $peminjaman)
    {
        $tglKembali = now()->toDateString();

        if (!$peminjaman->tgl_jatuh_tempo) {
            $denda = 0;
        } else {
            $tglJatuhTempo = \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo);
            $hariTerlambat = now()->gt($tglJatuhTempo) ? now()->diffInDays($tglJatuhTempo) : 0;
            $denda = $hariTerlambat * 2000;
        }

        $peminjaman->update([
            'status'      => 'dikembalikan',
            'tgl_kembali' => $tglKembali,
            'denda'       => $denda,
            // kondisi tetap seperti yang sudah diset petugas lewat edit
        ]);

        Buku::where('judul', $peminjaman->judul_buku)->increment('stok');

        return redirect()->route('petugas.peminjaman')->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
    }

    public function editPeminjaman(Peminjaman $peminjaman)
    {
        $anggota = User::where('role', 'anggota')->get();
        $buku    = Buku::where('stok', '>', 0)->get();
        return view('petugas.peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    // ✅ DIPERBAIKI: sekarang menyimpan kondisi juga
    public function updatePeminjaman(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'anggota_id'  => 'required|exists:users,id',
            'judul_buku'  => 'required|string',
            'tgl_pinjam'  => 'required|date',
            'status'      => 'required|in:menunggu,dipinjam,mengembalikan,dikembalikan',
            'kondisi'     => 'nullable|in:baik,rusak,hilang',
        ]);

        $peminjaman->update([
            'anggota_id'      => $request->anggota_id,
            'judul_buku'      => $request->judul_buku,
            'tgl_pinjam'      => $request->tgl_pinjam,
            'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
            'tgl_kembali'     => $request->tgl_kembali,
            'status'          => $request->status,
            'denda'           => $request->denda ?? 0,
            'kondisi'         => $request->kondisi ?? 'baik', // ✅ INI YANG PENTING
        ]);

        return redirect()->route('petugas.peminjaman')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroyPeminjaman(Peminjaman $peminjaman)
    {
        if (in_array($peminjaman->status, ['dipinjam', 'mengembalikan'])) {
            Buku::where('judul', $peminjaman->judul_buku)->increment('stok');
        }
        $peminjaman->delete();
        return redirect()->route('petugas.peminjaman')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    // ✅ DIPERBAIKI: updateDenda juga bisa update kondisi sekaligus
    public function updateDenda(Request $request, Peminjaman $peminjaman)
    {
        $request->validate(['denda' => 'required|integer|min:0']);

        // ✅ Otomatis set kondisi berdasarkan denda yang diinput petugas
        $kondisi = 'baik';
        if ($request->denda >= 50000) {
            $kondisi = 'hilang';
        } elseif ($request->denda >= 20000) {
            $kondisi = 'rusak';
        }

        $peminjaman->update([
            'denda'   => $request->denda,
            'kondisi' => $kondisi,
        ]);

        return redirect()->route('petugas.peminjaman')->with('success', 'Denda berhasil diperbarui.');
    }

    public function cetakStruk(Peminjaman $peminjaman)
{
    // Load relasi anggota
    $peminjaman->load('anggota');
 
    return view('petugas.peminjaman.cetak_struk', compact('peminjaman'));
}

    public function cetakDenda(Peminjaman $peminjaman)
    {
        // Load relasi anggota
        $peminjaman->load('anggota');
        
        return view('petugas.peminjaman.cetak_denda', compact('peminjaman'));
    }

    // ===== KATEGORI CRUD =====
    public function kategori()
    {
        $kategori = Kategori::orderBy('nama')->get();
        return view('petugas.kategori', compact('kategori'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:kategoris,nama'], [
            'nama.unique' => 'Nama kategori sudah ada.',
        ]);
        Kategori::create(['nama' => $request->nama]);
        return redirect()->route('petugas.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, Kategori $kategori)
    {
        $request->validate(['nama' => 'required|string|unique:kategoris,nama,' . $kategori->id], [
            'nama.unique' => 'Nama kategori sudah ada.',
        ]);
        $kategori->update(['nama' => $request->nama]);
        return redirect()->route('petugas.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('petugas.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}