<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tgl_kembali')->nullable()->change();
            $table->date('tgl_jatuh_tempo')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tgl_kembali')->nullable(false)->change();
            $table->date('tgl_jatuh_tempo')->nullable(false)->change();
        });
    }
};
