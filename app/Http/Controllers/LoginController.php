<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function autentic(Request $request)
    {
        $maxAttempts = 3; // Maximum attempts
        $lockoutTime = 30; // Lockout duration in seconds
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Cek apakah akun diblokir sementara
        if (Session::has('lockout_time') && time() < Session::get('lockout_time')) {
            $remainingTime = Session::get('lockout_time') - time();
            return redirect('/login')->with('status', 'failed')
                ->with('message', 'Terlalu banyak percobaan login. Coba lagi setelah ' . $remainingTime . ' detik.');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::forget('login_attempts');
            Session::forget('lockout_time');
            Session::put('last_activity_time', time()); // Set waktu aktivitas terakhir

            return redirect()->intended('/beranda');
        }

        // Jika gagal, tambahkan login_attempts
        $attempts = Session::get('login_attempts', 0) + 1;
        Session::put('login_attempts', $attempts);

        if ($attempts >= $maxAttempts) {
            Session::put('lockout_time', time() + $lockoutTime);
            return redirect('/login')->with('status', 'failed')
                ->with('message', 'Terlalu banyak percobaan login. Akun diblokir selama ' . $lockoutTime . ' detik.');
        }

        return redirect('/login')->with('status', 'failed')->with('message', 'Username atau Password salah. Percobaan tersisa: ' . ($maxAttempts - $attempts));
    }

    public function logout(Request $request)
    {
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
}