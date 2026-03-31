<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamanController;


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

Route::get('/buku', [BukuController::class, 'index']);

Route::get('/petugas', [PetugasController::class, 'index']);

Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);