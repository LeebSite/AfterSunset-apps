<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function tampilLog()
    {
        // Ambil log, paginate 'em like a pro!
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(20);

        // Kirim log ke view
        return view('log-activity', compact('logs'));
    }
}