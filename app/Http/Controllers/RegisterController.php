<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  
use App\Models\Admin; 
use App\Models\Guru;  
use App\Models\Siswa; 
use App\Models\Mapel; // Import model Mapel untuk validasi
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Menampilkan form pendaftaran
     */
    public function index()
    {
        // Mengambil daftar nama mapel unik untuk dropdown
        $data_mapel = Mapel::select('nama_mapel')->distinct()->get();
        return view('register', compact('data_mapel'));
    }

    public function store(Request $request)
    {
        $role = $request->role;

        // 1. Validasi Input
        $request->validate([
            'username' => "required|unique:users,username", 
            'password' => 'required|confirmed|min:6',
            'role'     => 'required|in:admin,guru,siswa',
            // Alamat hanya wajib untuk Guru dan Siswa
            'alamat'   => $role === 'admin' ? 'nullable' : 'required',
            // VALIDASI DROPDOWN MAPEL: Wajib bagi Guru dan harus ada di tabel mapels
            'mapel'    => $role === 'guru' ? 'required|exists:mapel,nama_mapel' : 'nullable',
        ]);

        // Gunakan Transaction
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
                    'nama'     => $request->username, 
                ]);
                $redirect = redirect()->route('login')->with('success', 'Admin berhasil daftar.');
            } 
            
            elseif ($role === 'guru') {
                Guru::create([
                    'id_user'             => $user->id,
                    'nama'                => $request->username,
                    'mapel'               => $request->mapel, // Data dari dropdown yang sudah divalidasi
                    'alamat_guru'         => $request->alamat,
                    'jenis_e_wallet'      => $request->input('jenis_e_wallet'),
                    'no_e_wallet'         => $request->input('no_e_wallet'),
                    'rekening'            => $request->rekening,
                    'no_hp'               => $request->no_hp,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                ]);
                $redirect = redirect()->route('login')->with('info', 'Pendaftaran Guru berhasil.');
            } 
            
            else { // Siswa
                Siswa::create([
                    'id_user'        => $user->id,
                    'nama'           => $request->username,
                    'jenjang'        => $request->jenjang,
                    'no_hp'          => $request->no_hp,
                    'alamat'         => $request->alamat,
                    'kelas'          => $request->kelas,
                    'asal_sekolah'   => $request->asal_sekolah,
                    'nama_orang_tua' => $request->nama_orang_tua,
                    'status_penerimaan' => 0,
                ]);
                $redirect = redirect()->route('login')->with('info', 'Pendaftaran Siswa berhasil. Mohon tunggu persetujuan Admin.');
            }

            DB::commit();
            return $redirect;

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mendaftar: ' . $e->getMessage()])->withInput();
        }
    }
}