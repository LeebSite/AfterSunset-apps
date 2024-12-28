<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function autentic(Request $request)
    {
        $maxAttempts = 3; 
        $lockoutTime = 30; 
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);
    
        if (Session::has('lockout_time') && time() < Session::get('lockout_time')) {
            $remainingTime = Session::get('lockout_time') - time();
            return redirect('/login')->with('status', 'failed')
                ->with('message', 'Terlalu banyak percobaan login. Coba lagi setelah ' . $remainingTime . ' detik.');
        }
    
        // Cari pengguna berdasarkan username
        $user = \App\Models\User::where('username', $credentials['username'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user); 
            $request->session()->regenerate();
            Session::forget('login_attempts');
            Session::forget('lockout_time');
            Session::put('last_activity_time', time()); 
    
            // Mencatat aktivitas login ke database
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_role' => Auth::user()->role->name,
                'activity_description' => 'Login ke sistem',
            ]);
    
            // Mencatat aktivitas login ke file log.txt
            $this->writelog('Login ke sistem', $request);
            return redirect()->intended('/beranda');
        }
    
        // Jika gagal, tambahkan login_attempts
        $attempts = Session::get('login_attempts', 0) + 1;
        Session::put('login_attempts', $attempts);
    
        if ($attempts >= $maxAttempts) {
            Session::put('lockout_time', time() + $lockoutTime);
            // Mencatat aktivitas blokir ke file log.txt
            $this->writelog('Akun diblokir setelah terlalu banyak percobaan login', $request);
            return redirect('/login')->with('status', 'failed')
                ->with('message', 'Terlalu banyak percobaan login. Akun diblokir selama ' . $lockoutTime . ' detik.');
        }
    
        // Mencatat aktivitas gagal login ke file log.txt
        $this->writelog('Gagal login: Username atau Password salah', $request, $credentials['username'], $credentials['password']);
        return redirect('/login')->with('status', 'failed')->with('message', 'Username atau Password salah. Percobaan tersisa: ' . ($maxAttempts - $attempts));
    }
    

    public function logout(Request $request)
    {
        // Mencatat aktivitas logout ke database
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'user_role' => Auth::user()->role->name,
            'activity_description' => 'Logout dari sistem',
        ]);

        // Mencatat aktivitas logout ke file log.txt
        $this->writelog('Logout dari sistem', $request);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function lockScreen()
    {
        session(['locked' => true]); // Menandakan bahwa layar terkunci
        return view('lockscreen'); // Tampilkan halaman lock screen
    }

    public function unlockScreen(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        // Cek apakah password benar
        if (Hash::check($request->password, $user->password)) {
            session(['locked' => false]); // Buka kunci
            // Perbarui waktu aktivitas terakhir setelah membuka kunci
            session(['last_activity_time' => time()]);
            return redirect()->route('beranda'); // Redirect ke halaman beranda
        }

        return back()->withErrors(['password' => 'Password salah.']); // Kembalikan dengan error jika password salah
    }

    private function writelog($description, Request $request, $username = null, $password = null)
    {
        $userId = Auth::check() ? Auth::id() : 'guest';
        $userName = Auth::check() ? Auth::user()->name : 'unknown';
        $userRole = Auth::check() ? Auth::user()->role->name : 'guest';
        $ipAddress = $request->ip();
        $url = $request->fullUrl();
        $browser = $request->header('User -Agent'); // Perbaikan di sini
        $time = now()->toDateTimeString();

        $logEntry = "User:   $userId\n" .
                    "Time: $time\n" .
                    "IP: $ipAddress\n" .
                    "From: $url\n" .
                    "Browser: $browser\n" .
                    "Activity: $description\n" .
                    "Username: $username\n" .
                    "Password: $password\n" .
                    "==================================================\n";

        // Menyimpan log ke file log.txt
        file_put_contents(storage_path('logs/log.txt'), $logEntry, FILE_APPEND);
    }
}