<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{




    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // LOGIN (sementara tanpa validasi database)
    public function login(Request $request)
    {
        // simpan session dummy
        session(['user' => [
            'nama' => 'User Demo'
        ]]);

        return redirect('/anggota/dashboard');
    }

    // REGISTER (sementara langsung redirect)
    public function register(Request $request)
    {
        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->session()->forget('user'); // hapus session
        return redirect('/login');
    }
}