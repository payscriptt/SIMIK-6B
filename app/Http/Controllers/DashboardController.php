<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    // Fungsi untuk menampilkan halaman pertama kali (Mengirim data awal)
    public function index() {
        return view('dashboard', [ // Sesuaikan nama file blade kamu (misal 'dashboard' atau 'dashboard.index')
            'total_barang_masuk'  => BarangMasuk::count(),
            'total_supplier'      => Supplier::count(),
            'total_barang'        => Barang::count(),
            'total_barang_keluar' => BarangKeluar::count(),
        ]);
    }

    // Fungsi tambahan khusus untuk melayani AJAX Realtime setiap 3 detik
    public function getStatsRealtime() {
        return Response::json([
            'total_barang_masuk'  => BarangMasuk::count(),
            'total_supplier'      => Supplier::count(),
            'total_barang'        => Barang::count(),
            'total_barang_keluar' => BarangKeluar::count(),
        ]);
    }
}