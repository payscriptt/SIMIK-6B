<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers'; // Sesuaikan jika nama tabel di DB adalah 'supplier'
    protected $primaryKey = 'id_supplier';
    public $incrementing = false; // Karena id_supplier diinput manual berupa string
    protected $keyType = 'string';

    protected $fillable = [
        'id_supplier',
        'nama_supplier',
        'no_tlp', // Mengikuti pemanggilan visual blade kamu: $s->no_tlp
        'alamat'
    ];
}