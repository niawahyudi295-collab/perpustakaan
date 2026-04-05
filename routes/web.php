<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BukuPetugasController;

// =====================
// HALAMAN AWAL
// =====================
Route::get('/', function () {
    return view('welcome');
});

// =====================
// LOGIN & REGISTER
// =====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// =====================
// LOGOUT
// =====================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// ANGGOTA
// =====================
Route::middleware(['auth', 'role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [AnggotaController::class, 'dashboard'])->name('dashboard');
    Route::get('/buku', [AnggotaController::class, 'menuBuku'])->name('buku.index');
    Route::get('/buku/pinjam/{id}', [AnggotaController::class, 'formPinjam'])->name('buku.pinjam');
    Route::post('/buku/pinjam', [AnggotaController::class, 'storePinjam'])->name('buku.pinjam.store');
    Route::get('/peminjaman', [AnggotaController::class, 'peminjaman'])->name('peminjaman');
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [AnggotaController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});

// =====================
// PETUGAS
// =====================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/anggota', [PetugasController::class, 'anggota'])->name('anggota');
    Route::get('/peminjaman', [PetugasController::class, 'peminjaman'])->name('peminjaman');
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [PetugasController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::patch('/peminjaman/{peminjaman}/konfirmasi', [PetugasController::class, 'konfirmasi'])->name('peminjaman.konfirmasi');
    Route::get('/kategori', [PetugasController::class, 'kategori'])->name('kategori');
    Route::post('/kategori', [PetugasController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{kategori}', [PetugasController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [PetugasController::class, 'destroyKategori'])->name('kategori.destroy');
    Route::resource('bukupetugas', BukuPetugasController::class);
});

// =====================
// KEPALA PERPUSTAKAAN
// =====================
Route::middleware(['auth', 'role:kepala'])->prefix('kepala')->name('kepala.')->group(function () {
    Route::get('/dashboard', [KepalaController::class, 'dashboard'])->name('dashboard');
    Route::get('/katalog', [KepalaController::class, 'katalog'])->name('katalog');
    Route::get('/anggota', [KepalaController::class, 'indexAnggota'])->name('anggota.index');
    Route::get('/laporan', [KepalaController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/{peminjaman}', [KepalaController::class, 'detailLaporan'])->name('laporan.detail');
    Route::get('/laporan/{peminjaman}/pdf', [KepalaController::class, 'cetakPdf'])->name('laporan.pdf');

    // Manajemen Petugas
    Route::get('/petugas', [KepalaController::class, 'indexPetugas'])->name('petugas.index');
    Route::get('/petugas/create', [KepalaController::class, 'createPetugas'])->name('petugas.create');
    Route::post('/petugas', [KepalaController::class, 'storePetugas'])->name('petugas.store');
    Route::get('/petugas/{petugas}/edit', [KepalaController::class, 'editPetugas'])->name('petugas.edit');
    Route::put('/petugas/{petugas}', [KepalaController::class, 'updatePetugas'])->name('petugas.update');
    Route::delete('/petugas/{petugas}', [KepalaController::class, 'destroyPetugas'])->name('petugas.destroy');
});
