<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ================= LOGIN PAGE
    public function showLogin()
    {
        return view('auth.login');
    }

    // ================= REGISTER PAGE
    public function showRegister()
    {
        return view('auth.register');
    }

    // ================= LOGIN
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role == 'anggota') {
            return redirect('/anggota/dashboard');
        } elseif ($user->role == 'petugas') {
            return redirect('/petugas/dashboard');
        } elseif ($user->role == 'kepala') {
            return redirect('/kepala/dashboard');
        }

        
    }

    return back()->with('error', 'Email atau password salah');
}
    // ================= LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}