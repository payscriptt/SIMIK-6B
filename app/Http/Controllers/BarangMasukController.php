<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use DB;

class BarangMasukController extends Controller
{
    // 1. Tampilkan Halaman Form + Riwayat
    public function index()
    {
        // Ambil riwayat barang masuk beserta data relasi barangnya
        $barang_masuks = BarangMasuk::with('barang')->orderBy('created_at', 'desc')->get();
        
        return view('barang_masuk.index', compact('barang_masuks'));
    }

    // 2. Simpan Data Inputan Form
    public function store(Request $request)
    {
        // Validasi input form (disesuaikan dengan atribut 'name' di blade kamu)
        $request->validate([
            'id_barang'   => 'required',
            'nama_barang' => 'required|string',
            'tanggal'     => 'required|date',
            'jumlah'      => 'required|numeric|min:1',
            'kondisi'     => 'required|string',
        ]);

        // Gunakan Database Transaction agar jika salah satu proses gagal, database aman
        DB::transaction(function() use ($request) {
            
            // Cek apakah ID Barang ini sudah terdaftar di master data barang
            $barang = Barang::find($request->id_barang);

            if ($barang) {
                // JIKA SUDAH ADA: Tambahkan stok jumlahnya saja
                $barang->increment('jumlah', $request->jumlah);
                // Update juga kondisinya jika berubah
                $barang->update(['kondisi' => $request->kondisi]);
            } else {
                // JIKA BELUM ADA: Buat data barang baru di master data
                Barang::create([
                    'id_barang'   => $request->id_barang,
                    'nama_barang' => $request->nama_barang,
                    'kategori'    => 'Umum', // Kamu bisa tambah input kategori di form jika perlu
                    'jumlah'      => $request->jumlah,
                    'kondisi'     => $request->kondisi,
                ]);
            }

            // Catat ke riwayat tabel barang_masuk
            BarangMasuk::create([
                'id_barang'           => $request->id_barang,
                'tanggal_masuk'       => $request->tanggal,
                'jumlah_barang_masuk' => $request->jumlah,
            ]);
        });

        return redirect()->back()->with('success', 'Data barang masuk berhasil disimpan dan stok master telah diperbarui!');
    }
}