<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('buku', function (Blueprint $table) {
        $table->id('id_buku');
        $table->string('judul');
        $table->integer('jumlah');
        $table->timestamps();
    });
}
};
