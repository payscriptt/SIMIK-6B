<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // 1. Menampilkan Halaman Form Login Admin
    public function showLoginForm()
    {
        return view('auth.login'); // Ini akan mengarah ke file resources/views/admin/login.blade.php
    }

    // 2. Memproses Aksi Login saat tombol submit ditekan
    public function login(Request $request)
    {
        // Validasi inputan dari form
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Proses autentikasi menggunakan guard 'admin' yang sudah kita daftarkan
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
 
            // Jika sukses, lempar ke halaman dashboard admin
            return redirect('/');
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // 3. Memproses Logout Admin
  public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // UBAH BARIS INI: langsung arahkan ke /login
    return redirect('/login'); 
}
}