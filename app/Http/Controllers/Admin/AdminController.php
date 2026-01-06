<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Mapel; // Tetap butuh Mapel untuk mengisi dropdown
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dataPengguna() {
        // Ambil data Guru & Siswa
        $guru = Guru::with('user')->get();
        $siswa = Siswa::with('user')->get();
        
        // Ambil data Mapel untuk pilihan di Dropdown
        $mapel = Mapel::all();

        return view('admin.Data_GurudanSiswa', compact('guru', 'siswa', 'mapel'));
    }

    public function storeGuru(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'mapel' => 'required', // Validasi input mapel
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            DB::transaction(function () use ($request) {
                // 1. Buat Akun Login (Dummy Email)
                $dummyEmail = Str::slug($request->nama) . rand(100, 999) . '@guru.sekolah';

                $user = User::create([
                    'username' => $request->nama,
                    'email' => $dummyEmail,
                    'password' => Hash::make('password123'),
                    'role' => 'guru'
                ]);

                // 2. Simpan Data Guru
                Guru::create([
                    'id_user' => $user->id,
                    'nama' => $request->nama,
                    'mapel' => $request->mapel, // Simpan teks mapel yang dipilih
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'alamat_guru' => $request->alamat_guru,
                    'rekening' => $request->rekening,
                    'no_hp' => $request->no_hp,
                    'jenis_e_wallet' => $request->jenis_e_wallet,
                    'no_e_wallet' => $request->no_e_wallet,
                    'status_aktif' => 'aktif'
                ]);
            });

            return response()->json(['status' => 'success', 'message' => 'Data Guru Berhasil Ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateGuru(Request $request, $id) {
        try {
            $guru = Guru::findOrFail($id);
            
            DB::transaction(function () use ($request, $guru) {
                // Update Username User
                if($guru->user) {
                    $guru->user->update(['username' => $request->nama]);
                }

                // Update Data Guru
                $guru->update([
                    'nama' => $request->nama,
                    'mapel' => $request->mapel, // Update mapel
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'alamat_guru' => $request->alamat_guru,
                    'rekening' => $request->rekening,
                    'no_hp' => $request->no_hp,
                    'jenis_e_wallet' => $request->jenis_e_wallet,
                    'no_e_wallet' => $request->no_e_wallet,
                ]);
            });

            return response()->json(['status' => 'success', 'message' => 'Data Guru Berhasil Diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // --- SISWA (Tidak berubah) ---
    public function storeSiswa(Request $request) {
        try {
            DB::transaction(function () use ($request) {
                $dummyEmail = Str::slug($request->nama) . rand(1000, 9999) . '@siswa.sekolah';
                $user = User::create([
                    'username' => $request->nama,
                    'email' => $dummyEmail,
                    'password' => Hash::make('password123'),
                    'role' => 'siswa'
                ]);
                Siswa::create(array_merge($request->all(), ['id_user' => $user->id, 'status_aktif' => 'aktif']));
            });
            return response()->json(['status' => 'success', 'message' => 'Data Siswa Berhasil Ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateSiswa(Request $request, $id) {
        try {
            $siswa = Siswa::findOrFail($id);
            DB::transaction(function () use ($request, $siswa) {
                if($siswa->user) $siswa->user->update(['username' => $request->nama]);
                $siswa->update($request->all());
            });
            return response()->json(['status' => 'success', 'message' => 'Data Siswa Berhasil Diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $role, $id) {
        try {
            $model = ($role == 'guru') ? Guru::findOrFail($id) : Siswa::findOrFail($id);
            $model->update(['status_aktif' => $request->status_aktif]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}