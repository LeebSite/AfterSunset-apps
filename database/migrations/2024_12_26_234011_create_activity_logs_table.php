<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Mengaitkan dengan tabel users
            $table->string('user_name');
            $table->string('user_role');
            $table->text('activity_description');
            $table->timestamps(); // Menyimpan created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}