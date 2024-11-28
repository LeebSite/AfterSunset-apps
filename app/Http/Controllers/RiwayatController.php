<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $pesanans = Pesanan::with('detailPesanan.menu')
            ->latest()
            ->paginate(10);

        return view('riwayat', compact('pesanans'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $pesanans = Pesanan::with('detailPesanan.menu')
            ->where('nama_pemesanan', 'like', '%' . $query . '%')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($pesanans);
    }
}
