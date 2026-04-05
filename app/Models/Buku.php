<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku'; // optional, Laravel otomatis p-buku plural
    protected $fillable = ['judul', 'kategori', 'pengarang', 'penulis', 'penerbit', 'tahun', 'jumlah', 'stok', 'cover'];

    
}