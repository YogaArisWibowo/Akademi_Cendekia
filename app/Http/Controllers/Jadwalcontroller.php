<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalBimbel;
use App\Models\Guru;
use App\Models\Siswa;
use App\models\Mapel;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = JadwalBimbel::all();
        // Ambil semua data pendukung untuk dropdown
        $guru = Guru::all(); 
        $siswa = Siswa::class::all(); // Sesuaikan nama model Anda
        $mapel = Mapel::all();

        return view('admin.Jadwal_Bimbel', compact('jadwal', 'guru', 'siswa', 'mapel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_guru'       => 'required|integer',
            'id_siswa'      => 'required|integer',
            'id_mapel'      => 'required|integer',
            'hari'          => 'required|string|max:20',
            'created_at'    => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'nama_mapel'    => 'required|string|max:100',
            'alamat_siswa'  => 'required|string|max:255',
        ]);

        JadwalBimbel::create($validated);
        return redirect()->back()->with('success', 'Jadwal berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalBimbel::findOrFail($id);
        $validated = $request->validate([
            'id_guru'       => 'required|integer',
            'id_siswa'      => 'required|integer',
            'id_mapel'      => 'required|integer',
            'hari'          => 'required|string|max:20',
            'created_at'    => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'nama_mapel'    => 'required|string|max:100',
            'alamat_siswa'  => 'required|string|max:255',
        ]);

        $jadwal->update($validated);
        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = JadwalBimbel::findOrFail($id);
        $jadwal->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
