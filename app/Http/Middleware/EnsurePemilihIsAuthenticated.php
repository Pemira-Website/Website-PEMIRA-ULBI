<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class EnsurePemilihIsAuthenticated
{
    /**
     * Middleware untuk memastikan pemilih sudah login via session.
     * Cek keberadaan session 'npm' yang di-set saat login berhasil.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('npm') || !Session::has('prodi')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
