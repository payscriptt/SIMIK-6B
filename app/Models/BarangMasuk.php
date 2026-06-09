<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    // Tentukan nama tabel riwayat barang masuk kamu di database
    protected $table = 'barang_masuks'; 
    
    // Tentukan primary key tabelnya
    protected $primaryKey = 'id_masuk'; 

    protected $fillable = [
        'id_barang',
        'tanggal_masuk',
        'jumlah_barang_masuk',
    ];

    // Relasi ke model Barang agar bisa mengambil nama_barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}