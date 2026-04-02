<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PetugasController;
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

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// =====================
// DASHBOARD
// =====================
Route::get('/dashboard', [AnggotaController::class, 'dashboard']);

Route::get('/petugas', [PetugasController::class, 'dashboard']);
Route::get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

Route::get('/anggota/dashboard', function () {
    return view('Anggota.dashboard');
});

Route::get('/kepala/dashboard', function () {
    return view('kepala.dashboard');
});

// =====================
// LOGOUT
// =====================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// KATALOG & PEMINJAMAN
// =====================
Route::get('/buku', [KatalogController::class, 'index'])->name('buku.index');
Route::get('/buku/pinjam/{id}', [KatalogController::class, 'pinjam']);

Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);

// =====================
// CRUD BUKU PETUGAS 🔥
// =====================
Route::resource('bukupetugas', BukuPetugasController::class);