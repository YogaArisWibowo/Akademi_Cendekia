<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 2. Coba Login melalui tabel 'users' (Default Guard)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil data user yang sedang login
            $user = Auth::user();

            // 3. Arahkan Redirect berdasarkan Role yang tersimpan di tabel users
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/admin_jadwal_bimbel');
            } 
            
            if ($user->role === 'guru') {
                return redirect()->intended('/jadwal_mengajar');
            }

            if ($user->role === 'siswa') {
                // Cek Approval di tabel siswa
                if ($user->siswa && !$user->siswa->is_approved) {
                    Auth::logout();
                    return back()->withErrors(['username' => 'Akun Anda belum disetujui oleh Admin.']);
                }
                return redirect()->intended('/siswa/jadwal_bimbel');
            }
        }

        // 4. Jika login gagal
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}