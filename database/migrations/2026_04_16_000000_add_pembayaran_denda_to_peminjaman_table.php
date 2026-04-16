<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum_dibayar', 'pending_konfirmasi', 'lunas'])->default('belum_dibayar')->after('denda');
            $table->datetime('tgl_pembayaran')->nullable()->after('status_pembayaran');
            $table->datetime('tgl_konfirmasi_pembayaran')->nullable()->after('tgl_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'tgl_pembayaran', 'tgl_konfirmasi_pembayaran']);
        });
    }
};
