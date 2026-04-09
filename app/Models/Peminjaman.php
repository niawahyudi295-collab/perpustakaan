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

    public function getHariTerlambatAttribute()
    {
        if (!$this->tgl_jatuh_tempo || $this->status === 'dikembalikan') return 0;
        $jatuhTempo = \Carbon\Carbon::parse($this->tgl_jatuh_tempo);
        return now()->gt($jatuhTempo) ? now()->diffInDays($jatuhTempo) : 0;
    }
}