<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JamKerjaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $now = Carbon::now();

        if ($user->role == 'Kasir') {
            $start = Carbon::createFromTime(17, 0, 0); 
            $end = Carbon::createFromTime(5, 0, 0); 

            // Cek apakah waktu sekarang di luar jam kerja
            if ($now->greaterThan($start) && $now->lessThan($end)) {
                return response()->view('errors.jam-kerja');
            }
        }

        return $next($request);
    }
}