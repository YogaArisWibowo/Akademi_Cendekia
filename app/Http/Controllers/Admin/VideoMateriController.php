<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoMateri;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;

class VideoMateriController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoMateri::with(['guru', 'mapel', 'siswa'])->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_materi', 'like', "%{$request->search}%");
        }

        $videos = $query->paginate(6);
        $dataGuru = Guru::all();
        $dataSiswa = Siswa::all();
        $dataMapel = Mapel::all();

        return view('admin.Video_Materi', compact('videos', 'dataGuru', 'dataSiswa', 'dataMapel'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_materi'     => 'required',
            'link_video'      => 'required',
            'id_mapel'        => 'required',
            'id_siswa'        => 'required',
            'jenis_kurikulum' => 'required'
        ]);

        // 2. Tentukan ID Guru
        $idGuru = null;

        // Jika user adalah Admin, ambil dari input select 'pilih_guru'
        if (Auth::user()->role == 'admin') {
            $idGuru = $request->pilih_guru;
        } 
        // Jika user adalah Guru, ambil ID Guru dari akun yang login
        else {
            $guru = Guru::where('id_user', Auth::id())->first();
            // Pastikan data guru ditemukan untuk menghindari error lain
            $idGuru = $guru ? $guru->id : null; 
        }

        // 3. Simpan dengan mendefinisikan kolom satu per satu
        VideoMateri::create([
            'id_guru'         => $idGuru, // <--- INI YANG PENTING
            'id_siswa'        => $request->id_siswa,
            'id_mapel'        => $request->id_mapel,
            'nama_materi'     => $request->nama_materi,
            'link_video'      => $request->link_video,
            'jenis_kurikulum' => $request->jenis_kurikulum,
        ]);

        return redirect()->back()->with('success', 'Data tersimpan');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'nama_materi'     => 'required',
            'link_video'      => 'required',
            'id_mapel'        => 'required',
            'id_siswa'        => 'required',
            'jenis_kurikulum' => 'required'
        ]);

        // 2. Cari Data Video Lama
        $video = VideoMateri::findOrFail($id);

        // 3. Logika Update Guru (Jika Admin mengubah guru)
        // Jika input pilih_guru kosong (tidak diubah), pakai id_guru yang lama
        $idGuru = $request->pilih_guru ?? $video->id_guru;
        
        // Jika yang login BUKAN admin (misal Guru), maka id_guru TETAP, tidak boleh berubah
        if (Auth::user()->role !== 'admin') {
            $idGuru = $video->id_guru;
        }

        // 4. Lakukan Update
        $video->update([
            'nama_materi'     => $request->nama_materi,
            'link_video'      => $request->link_video,
            'id_mapel'        => $request->id_mapel,
            'id_siswa'        => $request->id_siswa,
            'jenis_kurikulum' => $request->jenis_kurikulum,
            'id_guru'         => $idGuru
        ]);

        return redirect()->route('admin_Video_Materi')->with('success', 'Data berhasil diubah!');
    }
}