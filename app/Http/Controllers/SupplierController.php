<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    // 1. Menampilkan Semua Data Supplier
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        return view('supplier.index', compact('suppliers'));
    }

    // 2. Menampilkan Halaman Form Tambah Supplier
    public function create()
    {
        return view('supplier.create');
    }

    // 3. Menyimpan Data Supplier Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'id_supplier'   => 'required|string|unique:suppliers,id_supplier',
            'nama_supplier' => 'required|string',
            'no_telepon'    => 'required|string', // Sesuai name pada tag input form
            'alamat'        => 'required|string',
        ]);

        Supplier::create([
            'id_supplier'   => $request->id_supplier,
            'nama_supplier' => $request->nama_supplier,
            'no_tlp'        => $request->no_telepon, // Memetakan no_telepon form ke kolom no_tlp DB
            'alamat'        => $request->alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data Supplier berhasil ditambahkan!');
    }

    // 4. Menghapus Data Supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->back()->with('success', 'Data Supplier berhasil dihapus!');
    }
}