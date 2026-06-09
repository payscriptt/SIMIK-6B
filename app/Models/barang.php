<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Tentukan nama tabel manualmu di PostgreSQL
    protected $table = 'barangs'; // Sesuai konvensi Laravel, atau ubah jika nama tabelmu berbeda

    // Beritahu Laravel kalau Primary Key-mu bukan 'id'
    protected $primaryKey = 'id_barang';

    // Jika id_barang berupa teks/string (bukan angka serial otomatis)
    public $incrementing = false;
    protected $keyType = 'string';

    // Daftarkan kolom yang bisa diisi
    protected $fillable = [
        'id_barang',
        'nama_barang',
        'kategori',
        'jumlah',
        'kondisi'
    ];

    // Nonaktifkan jika tabelmu tidak punya kolom created_at & updated_at
    public $timestamps = true; 
}