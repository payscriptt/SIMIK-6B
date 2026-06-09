<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // 1. Ambil data dari PostgreSQL dan tampilkan ke index.blade.php
    public function index()
    {
        $barangs = Barang::all(); // Mengambil seluruh data barang
        return view('barang.index', compact('barangs'));
    }

    // 2. Fungsi untuk menghapus barang berdasarkan id_barang
    public function destroy($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        $barang->delete();

        return redirect('/barang')->with('success', 'Barang berhasil dihapus!');
    }
}