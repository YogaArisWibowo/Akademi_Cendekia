<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil semua data guru dari database
        $jadwal = Siswa::all(); 
        
        // Mendefinisikan status default agar tidak error di Blade
        $status_awal = 'aktif'; 

        return view('admin.Data_GurudanSiswa', compact('jadwal', 'status_awal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenjang' => 'required',
            'kelas' => 'required',
            'asal_sekolah' => 'required',
            'no_hp' => 'required',
        ]);

        // Default status saat tambah data baru
        $data = $request->all();
        $data['status'] = 'aktif'; 

        Guru::create($data);
        return back()->with('success', 'Data Guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenjang' => 'required',
            'kelas' => 'required',
            'asal_sekolah' => 'required',
            'no_hp' => 'required',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return back()->with('success', 'Data Guru berhasil diupdate');
    }
}
