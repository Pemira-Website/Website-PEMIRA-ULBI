<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @deprecated Gunakan EnsurePemilihIsAuthenticated middleware sebagai gantinya.
 * File ini dipertahankan untuk backward compatibility.
 * Middleware ini tidak digunakan di route manapun.
 */
class User
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
