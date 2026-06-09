<?php

namespace App\Models;

// WAJIB: Gunakan Authenticatable, bukan Model biasa agar bisa dipakai Login
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    // 1. Beritahu Laravel kalau nama tabelnya adalah 'admins'
    protected $table = 'admins';

    // 2. Daftarkan kolom yang boleh diisi
    protected $fillable = [
        'username',
        'password',
    ];

    // 3. Sembunyikan password saat data di-convert ke array/json
    protected $hidden = [
        'password',
    ];

    // 4. Otomatis hash password saat disimpan
    protected $casts = [
        'password' => 'hashed',
    ];
}