<?php
// app/Http/Controllers/AkunKasirController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunKasirController extends Controller
{
    public function index()
    {
        if (Auth::user()->role->name !== 'Administrator') {
            return view('/error');
        }

        $kasirs = User::whereHas('role', function ($query) {
            $query->where('name', 'kasir');
        })->get();

        return view('akunkasir', compact('kasirs'));
    }

    public function store(Request $request)
    {
        // Validasi khusus untuk username
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:user,username',
            'password' => 'required|min:6',
            'phone' => 'required',
            'address' => 'required',
        ]);
    
        // Jika validasi berhasil, tambahkan akun
        $role = Role::where('name', 'kasir')->first();
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => $role->id,
        ]);
    
        return redirect()->route('akunkasir.index')->with('success', 'Akun kasir berhasil ditambahkan');
    }    

    public function update(Request $request, $id)
    {
        $kasir = User::findOrFail($id);
    
        // Validasi input lainnya
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);
    
        // Update data kasir tanpa mengubah password jika field password kosong
        $kasir->name = $request->name;
        $kasir->username = $request->username;
        $kasir->phone = $request->phone;
        $kasir->address = $request->address;
    
        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $kasir->password = bcrypt($request->password);
        }
    
        $kasir->save();
    
        return redirect()->route('akunkasir.index')->with('success', 'Akun kasir berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        // Hapus data
        User::findOrFail($id)->delete();

        // Set session success
        return redirect()->route('akunkasir.index')->with('success', 'Akun kasir berhasil dihapus.');
    }
}
