<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        // Mengambil data mapel beserta data siswa terkait
        $mapel = Mapel::with('siswa')->paginate(10);
        
        // Mengambil data siswa untuk dropdown di form tambah
        $siswa = Siswa::all();

        return view('admin.Tambah_Mapel', compact('mapel', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'jenis_kurikulum' => 'required',
            'kelas' => 'required',
        ]);

        Mapel::create($request->all());

        return redirect()->back()->with('success', 'Data Mapel berhasil ditambahkan!');
    }
}