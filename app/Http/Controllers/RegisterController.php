<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // Tabel Induk
use App\Models\Admin; // Tabel Profil Admin
use App\Models\Guru;  // Tabel Profil Guru
use App\Models\Siswa; // Tabel Profil Siswa
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $role = $request->role;

        // 1. Validasi Input
        $request->validate([
            'username' => "required|unique:users,username", // Cek keunikan di tabel induk
            'password' => 'required|confirmed|min:6',
            'role'     => 'required|in:admin,guru,siswa',
            // Alamat hanya wajib untuk Guru dan Siswa
            'alamat'   => $role === 'admin' ? 'nullable' : 'required',
        ]);

        // Gunakan Transaction: Jika satu gagal, semua dibatalkan
        DB::beginTransaction();

        try {
            // 2. TAHAP 1: Simpan ke tabel induk (Users)
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => $role,
            ]);

            // 3. TAHAP 2: Simpan ke tabel profil sesuai role
            if ($role === 'admin') {
                Admin::create([
                    'id_user'  => $user->id,
                    'username' => $request->username,
                    'nama'     => $request->username, // Mengisi kolom 'nama' yang diminta DB
                    // 'alamat' sengaja dikosongkan karena tidak ada di form Admin
                ]);
                $redirect = redirect()->route('Login')->with('success', 'Admin berhasil daftar.');
            } 
            
            elseif ($role === 'guru') {
                Guru::create([
                    'id_user'             => $user->id,
                    'username'            => $request->username,
                    'mapel'               => $request->mapel,
                    'alamat'              => $request->alamat,
                    'jenis_e_wallet'      => $request->input('jenis_e-wallet'),
                    'no_e_wallet'         => $request->input('no_e-wallet'),
                    'rekening'            => $request->rekening,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'is_approved'         => false,
                ]);
                $redirect = back()->with('info', 'Pendaftaran Guru berhasil. Mohon tunggu persetujuan Admin.');
            } 
            
            else { // Siswa
                Siswa::create([
                    'id_user'        => $user->id,
                    'username'       => $request->username,
                    'jenjang'        => $request->jenjang,
                    'no_hp'          => $request->no_hp,
                    'alamat'         => $request->alamat,
                    'kelas'          => $request->kelas,
                    'asal_sekolah'   => $request->asal_sekolah,
                    'nama_orang_tua' => $request->nama_orang_tua,
                    'is_approved'    => false,
                ]);
                $redirect = back()->with('info', 'Pendaftaran Siswa berhasil. Mohon tunggu persetujuan Admin.');
            }

            DB::commit();
            return $redirect;

        } catch (\Exception $e) {
            DB::rollBack();
            // Menampilkan error asli untuk memudahkan debug
            return back()->withErrors(['error' => 'Gagal mendaftar: ' . $e->getMessage()])->withInput();
        }
    }
}