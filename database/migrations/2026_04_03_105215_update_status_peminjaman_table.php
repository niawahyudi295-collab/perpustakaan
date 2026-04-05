<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ubah kolom status menjadi string biasa agar support menunggu/dipinjam/dikembalikan
            $table->string('status')->default('menunggu')->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('status')->default('dipinjam')->change();
        });
    }
};
