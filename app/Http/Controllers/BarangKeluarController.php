<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;
use DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barang_keluars = BarangKeluar::with('barang')->orderBy('created_at', 'desc')->get();
        return view('barang_keluar.index', compact('barang_keluars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_keluar' => 'required|string',
            'id_barang' => 'required|string',
            'tanggal'   => 'required',
            'jumlah'    => 'required|numeric|min:1',
        ]);

        // Cek dulu apakah barangnya ada di gudang/master data
        $barang = Barang::find($request->id_barang);

        if (!$barang) {
            return redirect()->back()->withErrors(['error' => 'ID Barang tidak terdaftar di sistem!']);
        }

        // Validasi: Jangan sampai barang yang keluar melebihi stok yang ada
        if ($barang->jumlah < $request->jumlah) {
            return redirect()->back()->withErrors(['error' => 'Stok tidak mencukupi! Sisa stok saat ini: ' . $barang->jumlah]);
        }

        // Jalankan proses aman database
        DB::transaction(function () use ($request, $barang) {
            // 1. Kurangi jumlah stok di tabel master data barang
            $barang->decrement('jumlah', $request->jumlah);

            // 2. Simpan catatan ke tabel riwayat barang keluar
            BarangKeluar::create([
                'id_keluar'            => $request->id_keluar,
                'id_barang'            => $request->id_barang,
                'tanggal_keluar'       => $request->tanggal, 
                'jumlah_barang_keluar' => $request->jumlah,
            ]);
        });

        return redirect()->back()->with('success', 'Barang keluar berhasil dicatat dan stok master telah dikurangi!');
    }
}