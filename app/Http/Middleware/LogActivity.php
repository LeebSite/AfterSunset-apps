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
            $method = $request->route()->getActionMethod(); // Mendapatkan metode controller yang dipanggil
            $description = $this->mapActionToDescription($request);

            // Cek apakah ini aktivitas login atau logout
            if ($method === 'autentic') {
                $description = 'Login ke sistem'; // Menambahkan log aktivitas login
            }

            if ($method === 'logout') {
                $description = 'Logout dari sistem'; // Menambahkan log aktivitas logout
            }

            // Mencatat aktivitas dalam log
            if ($description) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->name,
                    'user_role' => Auth::user()->role->name, // Mengakses nama role melalui relasi
                    'activity_description' => $description,
                ]);

                // Mencatat ke log.txt
                $this->writeLogToFile($description, $request);
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
            'riwayat' => [
                'index' => 'Mengakses halaman Riwayat',
                'search' => 'Mencari riwayat',
            ],
        ];

        foreach ($descriptions as $key => $actions) {
            if (str_contains($route, $key) && isset($actions[$action])) {
                return $actions[$action];
            }
        }

        return null; 
    }

    private function writeLogToFile($description, $request)
    {
        $userId = Auth::id();
        $userName = Auth::user()->name;
        $ipAddress = $request->ip();
        $url = $request->fullUrl();
        $time = now();

        $logEntry = "User:  $userId\n" .
                    "User Name: $userName\n" .
                    "Time: $time\n" .
                    "IP: $ipAddress\n" .
                    "URL: $url\n" .
                    "Activity: $description\n" .
                    "==================================================\n";

        // Menyimpan log ke file log.txt
        file_put_contents(storage_path('logs/log.txt'), $logEntry, FILE_APPEND);
    }
}