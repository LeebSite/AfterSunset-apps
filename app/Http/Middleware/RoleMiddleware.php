<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role->name === $role) {
            return $next($request);
        }

        // Jika tidak memiliki akses, tampilkan halaman 403 dengan pesan khusus
        return response()->view('errors.403', ['message' => 'Maaf, Anda tidak memiliki akses ke menu ini.'], 403);
    }
}