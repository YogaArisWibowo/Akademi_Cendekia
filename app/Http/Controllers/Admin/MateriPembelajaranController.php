<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MateriPembelajaran;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MateriPembelajaranController extends Controller
{
    public function index()
    {
        $materi = MateriPembelajaran::latest()->get();
        $dataGuru = Guru::all(); 
        $dataSiswa = Siswa::all();
        $dataMapel = Mapel::all();

        return view('admin.Materi_Pembelajaran', compact('materi', 'dataGuru', 'dataMapel', 'dataSiswa'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $rules = [
            'nama_materi'     => 'required|string|max:255',
            'file_materi'     => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240',
            'jenis_kurikulum' => 'required',
            'id_mapel'        => 'required',
            'id_siswa'        => 'required|exists:siswa,id',
            // [UBAH] Validasi sekarang menggunakan nama 'materi'
            'materi'          => 'nullable|string', 
        ];

        if (Auth::user()->role === 'admin') {
            $rules['pilih_guru'] = 'required'; 
        }

        $request->validate($rules);

        // 2. Proses Upload File
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('materi'), $filename);

            // Logika Penentuan ID Guru
            $realIdGuru = null;
            if (Auth::user()->role === 'admin') {
                $realIdGuru = $request->pilih_guru;
            } else {
                $guru = Guru::where('id_user', Auth::id())->first();
                if (!$guru) {
                    return redirect()->back()->with('error', 'Data profil guru tidak ditemukan.');
                }
                $realIdGuru = $guru->id;
            }

            // 3. Simpan ke Database
            MateriPembelajaran::create([
                'id_guru'         => $realIdGuru,
                'id_siswa'        => $request->id_siswa,
                'id_mapel'        => $request->id_mapel,
                'nama_materi'     => $request->nama_materi,
                'jenis_kurikulum' => $request->jenis_kurikulum,
                
                // [UBAH] Input 'materi' langsung masuk ke kolom 'materi'
                'materi'          => $request->materi, 
                
                'file_materi'     => $filename, 
            ]);

            return redirect()->back()->with('success', 'Materi berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    public function show($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);
        $dataGuru = Guru::all();
        $dataMapel = Mapel::all();
        $dataSiswa = Siswa::all(); 

        return view('admin.detail_materi_pembelajaran', compact('materi', 'dataGuru', 'dataMapel', 'dataSiswa'));
    }

    public function update(Request $request, $id)
    {
        $materiData = MateriPembelajaran::findOrFail($id);

        $request->validate([
            'nama_materi' => 'required|string|max:255',
            // [UBAH] Ganti ringkasan jadi materi
            'materi'      => 'nullable|string', 
            'id_siswa'    => 'required|exists:siswa,id', 
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:10240',
        ]);

        // Update Data Dasar
        $materiData->nama_materi = $request->nama_materi;
        $materiData->id_siswa    = $request->id_siswa;
        
        // [UBAH] Input 'materi' langsung ke kolom 'materi'
        $materiData->materi      = $request->materi; 

        if($request->has('id_mapel')) $materiData->id_mapel = $request->id_mapel;
        
        if(Auth::user()->role === 'admin' && $request->has('pilih_guru')) {
            $materiData->id_guru = $request->pilih_guru;
        }

        // Update File jika ada upload baru
        if ($request->hasFile('file_materi')) {
            $pathLama = public_path('materi/' . $materiData->file_materi);
            if(File::exists($pathLama) && $materiData->file_materi != null){
                File::delete($pathLama);
            }

            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('materi'), $filename);
            
            $materiData->file_materi = $filename;
        }

        $materiData->save();

        return redirect()->back()->with('success', 'Materi berhasil diperbarui!');
    }
}