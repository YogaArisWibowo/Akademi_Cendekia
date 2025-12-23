<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dataPengguna() {
        $guru = Guru::with('user')->get();
        $siswa = Siswa::with('user')->get();
        return view('admin.Data_GurudanSiswa', compact('guru', 'siswa'));
    }

    public function storeGuru(Request $request) {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'guru'
            ]);
            Guru::create([
                'id_user' => $user->id,
                'nama' => $request->nama,
                'pendidikan_terakhir' => $request->pendidikan,
                'mapel' => $request->mapel,
                'alamat_guru' => $request->alamat_guru,
                'rekening' => $request->rekening,
                'no_hp' => $request->no_hp,
                'jenis_e_wallet' => $request->jenis,
                'no_e_wallet' => $request->input('no_e-wallet'),
                'status_aktif' => 'aktif'
            ]);
        });
        return back()->with('success', 'Data Guru Berhasil Ditambahkan');
    }

    public function updateGuru(Request $request, $id) {
        $guru = Guru::findOrFail($id);
        DB::transaction(function () use ($request, $guru) {
            $guru->user->update(['username' => $request->nama, 'email' => $request->email]);
            $guru->update([
                'nama' => $request->nama,
                'pendidikan_terakhir' => $request->pendidikan,
                'mapel' => $request->mapel,
                'alamat_guru' => $request->alamat_guru,
                'rekening' => $request->rekening,
                'no_hp' => $request->no_hp,
                'jenis_e_wallet' => $request->jenis,
                'no_e_wallet' => $request->input('no_e-wallet'),
            ]);
        });
        return back()->with('success', 'Data Guru Berhasil Diperbarui');
    }

    public function storeSiswa(Request $request) {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'siswa'
            ]);
            Siswa::create([
                'id_user' => $user->id,
                'nama' => $request->nama,
                'jenjang' => $request->jenjang,
                'kelas' => $request->kelas,
                'asal_sekolah' => $request->asal_sekolah,
                'nama_orang_tua' => $request->nama_ortu,
                'no_hp' => $request->no_hp,
                'status_penerimaan' => 1
            ]);
        });
        return back()->with('success', 'Data Siswa Berhasil Ditambahkan');
    }

    public function updateSiswa(Request $request, $id) {
        $siswa = Siswa::findOrFail($id);
        DB::transaction(function () use ($request, $siswa) {
            $siswa->user->update(['username' => $request->nama, 'email' => $request->email]);
            $siswa->update([
                'nama' => $request->nama,
                'jenjang' => $request->jenjang,
                'kelas' => $request->kelas,
                'asal_sekolah' => $request->asal_sekolah,
                'nama_orang_tua' => $request->nama_ortu,
                'no_hp' => $request->no_hp,
            ]);
        });
        return back()->with('success', 'Data Siswa Berhasil Diperbarui');
    }

    public function updateStatus(Request $request, $role, $id) {
        $data = ($role == 'guru') ? Guru::findOrFail($id) : Siswa::findOrFail($id);
        $column = ($role == 'guru') ? 'status_aktif' : 'status_penerimaan';
        $data->update([$column => $request->status]);
        return response()->json(['success' => true]);
    }
}