<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';
    protected $primaryKey = 'id_keluar';
    public $incrementing = false; // Karena id_keluar diinput manual di form kamu
    protected $keyType = 'string';

    protected $fillable = [
        'id_keluar',
        'id_barang',
        'tanggal_keluar',
        'jumlah_barang_keluar'
    ];

    // Hubungkan ke master barang agar bisa memanggil namanya di tabel riwayat
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}