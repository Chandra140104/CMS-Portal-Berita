<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HakAkses
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kalau belum login, biarkan middleware auth yang handle
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Jika role user ada di daftar roles yang diizinkan
        if (in_array($request->user()->role, $roles, true)) {
            return $next($request);
        }

        // Kalau tidak punya akses
        abort(403, 'Anda tidak memiliki akses.');
    }
}
