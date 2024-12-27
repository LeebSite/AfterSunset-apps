<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $path = $request->path();
            $method = $request->route()->getActionMethod(); // Mendapatkan metode controller yang dipanggil
            
            // Mencatat aktivitas
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_role' => Auth::user()->role,
                'activity_description' => $this->mapRouteToDescription($path),
            ]);
        }

        return $next($request);
    }

    private function mapRouteToDescription($path)
    {
        // Pemetaan path ke deskripsi aktivitas
        $menuDescriptions = [
            'beranda' => 'akses beranda',
            'pemesanan' => 'akses pemesanan',
            'riwayat' => 'akses riwayat',
            // Tambahkan pemetaan lainnya sesuai kebutuhan
        ];

        return $menuDescriptions[$path] ?? 'akses ' . $path;
    }
}