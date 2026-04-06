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

    // ================= REGISTER (Anggota only)
    public function register(Request $request)
    {
        $request->validate([
            'username'          => 'required|string|max:50|unique:users',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users',
            'phone_number'      => 'required|string|max:20',
            'alamat'            => 'required|string|max:500',
            'password'          => 'required|min:6|confirmed',
        ], [
            'username.unique'   => 'Username sudah digunakan.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        User::create([
            'username'     => $request->username,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'alamat'       => $request->alamat,
            'password'     => Hash::make($request->password),
            'role'         => 'anggota',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    // ================= LOGIN
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role == 'anggota') {
            return redirect()->route('anggota.dashboard');
        } elseif ($user->role == 'petugas') {
            return redirect()->route('petugas.dashboard');
        } elseif ($user->role == 'kepala') {
            return redirect()->route('kepala.dashboard');
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