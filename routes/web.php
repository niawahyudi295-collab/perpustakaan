<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Petugas\BukupetugasController; 



// HALAMAN AWAL
Route::get('/', function () {
    return view('welcome');
});

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// REGISTER
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// DASHBOARD
Route::get('/dashboard', [AnggotaController::class, 'dashboard']);

// LOGOUT (gunakan satu saja)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/buku', [KatalogController::class, 'index']);
Route::get('/buku/pinjam/{id}', [KatalogController::class, 'pinjam']);

Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);

Route::get('/petugas', [PetugasController::class, 'dashboard']);

use App\Http\Controllers\Petugas\BukuController;

Route::prefix('petugas')->middleware('auth')->group(function () {
    Route::resource('buku', BukupetugasController::class);
});

Route::get('/anggota/dashboard', function () {
    return view('Anggota.dashboard');
});

Route::get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
});

Route::get('/kepala/dashboard', function () {
    return view('kepala.dashboard');
});
