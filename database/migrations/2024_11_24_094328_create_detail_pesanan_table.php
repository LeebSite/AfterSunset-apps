<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menu');
            $table->integer('jumlah');
            $table->decimal('harga_total', 10, 2);
            $table->timestamps();
        });
    }
    
    public function down() {
        Schema::dropIfExists('detail_pesanan');
    }
    
};
