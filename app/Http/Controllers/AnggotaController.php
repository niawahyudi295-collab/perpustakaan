<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function dashboard()
    {
        return view('anggota.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}