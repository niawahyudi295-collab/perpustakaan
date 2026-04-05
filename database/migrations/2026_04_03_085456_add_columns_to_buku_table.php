<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('judul');
            $table->string('penulis')->nullable()->after('pengarang');
            $table->integer('tahun')->nullable()->after('penerbit');
            $table->integer('stok')->default(0)->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'penulis', 'tahun', 'stok']);
        });
    }
};
