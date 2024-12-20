<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model {
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = ['pesanan_id', 'menu_id', 'jumlah', 'harga_total'];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id');  // Ensure correct foreign key
    }

}
