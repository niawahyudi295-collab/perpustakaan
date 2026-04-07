<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'anggota') return redirect()->route('anggota.dashboard');
            if ($role === 'petugas') return redirect()->route('petugas.dashboard');
            if ($role === 'kepala')  return redirect()->route('kepala.dashboard');
        }

        return $next($request);
    }
}
