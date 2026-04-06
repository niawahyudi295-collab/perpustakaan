<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; // pastikan nama tabel di database sesuai

    protected $fillable = [
        'judul_buku',
        'anggota_id',
        'tgl_pinjam',
        'tgl_jatuh_tempo',
        'tgl_kembali',
        'status',
        'denda',
    ];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }
}