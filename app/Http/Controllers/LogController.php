<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function tampilLog()
    {

        // Ambil log, urutkan berdasarkan waktu terbaru
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(20);

        // Kirim log ke view
        return view('log-activity', compact('logs'));
    }
}
