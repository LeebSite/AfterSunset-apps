<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Menampilkan form pemesanan
    public function index()
    {

        $menu = Menu::all();
        return view('pemesanan', compact('menu'));
    }
    
    // Menyimpan transaksi pemesanan
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Membuat data pesanan utama
            $pesanan = Pesanan::create([
                'nama_pemesanan' => $request->nama_pemesan,
                'uang_dibayar' => $request->uang_dibayar,
                'kembalian' => $request->uang_dibayar - $request->total_harga,
            ]);
    
            // Menguraikan data menus dari JSON
            $menu = json_decode($request->menu, true);
    
            // Menambahkan detail pesanan (produk dan jumlahnya)
            foreach ($menu as $menu) {
                $menuItem = Menu::find($menu['id']);
                if ($menuItem) {
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'menu_id' => $menu['id'],
                        'jumlah' => $menu['jumlah'],
                        'harga_total' => $menuItem->harga * $menu['jumlah'],
                    ]);
                }
            }
    
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil disimpan.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Pesanan gagal disimpan.'], 500);
        }
    }
}    