<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $method = $request->route()->getActionMethod(); // Metode controller yang dipanggil
            $description = $this->mapActionToDescription($request);

            if ($description) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->name,
                    'user_role' => Auth::user()->role,
                    'activity_description' => $description,
                ]);
            }
        }

        return $response;
    }

    private function mapActionToDescription($request)
    {
        $route = $request->route()->uri(); // Mendapatkan URI
        $action = $request->route()->getActionMethod(); // Metode controller
        $descriptions = [
            'akunkasir' => [
                'index' => 'Mengakses halaman Akun Kasir',
                'store' => 'Menambah akun kasir',
                'update' => 'Mengedit akun kasir',
                'destroy' => 'Menghapus akun kasir',
            ],
            'menu' => [
                'index' => 'Mengakses halaman Menu',
                'store' => 'Menambah menu',
                'update' => 'Mengedit menu',
                'destroy' => 'Menghapus menu',
            ],
            'pemesanan' => [
                'index' => 'Mengakses halaman Pemesanan',
                'store' => 'Menambah transaksi pemesanan',
            ],
            'keuangan' => [
                'index' => 'Mengakses halaman Keuangan',
            ],
        ];

        foreach ($descriptions as $key => $actions) {
            if (str_contains($route, $key) && isset($actions[$action])) {
                return $actions[$action];
            }
        }

        return null; // Tidak mencatat aktivitas jika tidak ditemukan
    }
}
