<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AutoLock
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah session 'locked' ada
        if (session('locked')) {
            return redirect()->route('lockscreen'); // Arahkan ke halaman lockscreen jika terkunci
        }

        $timeout = 100; // 30 detik
        $lastActivity = session('last_activity_time', time());

        if (time() - $lastActivity > $timeout) {
            session(['locked' => true]); // Kunci layar
            return redirect()->route('lockscreen'); // Arahkan ke halaman lock screen
        }

        session(['last_activity_time' => time()]); // Perbarui waktu aktivitas terakhir
        return $next($request);
    }
}