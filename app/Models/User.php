<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi
     */
    protected $fillable = [
        'name',
        'alamat',
        'no_tlp',
        'username',
        'email',
        'password',
    ];

    /**
     * Field yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting data
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}