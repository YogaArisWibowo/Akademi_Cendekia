<?php

namespace App\Http\Controllers;

use App\Models\JadwalBimbel;
use App\Models\MateriPembelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\VideoMateri;


use App\Models\AbsensiGuru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    // UNTUK MENAMPILKAN JADWAL 
    public function jadwalMengajar()
    {
        $jadwal = JadwalBimbel::with(['guru', 'siswa', 'mapel'])->get();

        return view('guru.jadwal_mengajar', compact('jadwal'));
    }

    // UNTUK TAMBAH ABSENSI GURU
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $data = AbsensiGuru::when($bulan, function ($q) use ($bulan) {
            return $q->whereMonth('tanggal', $bulan);
        })
            ->when($tahun, function ($q) use ($tahun) {
                return $q->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.absensi', compact('data', 'bulan', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'mapel' => 'required',
            'bukti' => 'required|mimes:jpg,jpeg',
            'catatan' => 'nullable'
        ]);

        // Simpan file bukti foto
        $file = $request->file('bukti');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti_absensi'), $namaFile);

        AbsensiGuru::create([
            'id_guru' => 1,
            'id_jadwal_bimbel' => 1,
            'mapel' => $request->mapel, // INI WAJIB ADA
            'bukti_foto' => $namaFile,
            'laporan_kegiatan' => $request->catatan,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
        ]);

        return redirect()->route('absensi_guru')->with('success', 'Absensi berhasil ditambahkan');
    }

    // UNTUK MATERI PEMBELAJARAN
    //tambah dan view materi
    public function indexMateri(Request $request)
    {
        // Ambil jenjang dari tabel siswa
        $jenjang = Siswa::select('jenjang')->distinct()->pluck('jenjang');

        // Query materi
        $query = MateriPembelajaran::with(['guru', 'mapel', 'siswa']);

        // Jika filter jenjang dipilih
        if ($request->filled('jenjang')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('jenjang', $request->jenjang);
            });
        }

        $materi = $query->get();

        $guru = Guru::all();
        $siswa = Siswa::all();
        $mapel = Mapel::all();

        return view('guru.materi_pembelajaran', compact('materi', 'guru', 'siswa', 'mapel', 'jenjang'));
    }

    public function storeMateri(Request $request)
    {
        $request->validate([
            'id_guru' => 'required',
            'id_siswa' => 'nullable',
            'id_mapel' => 'required',
            'nama_materi' => 'required',
            'materi' => 'required',
            'jenis_kurikulum' => 'required'
        ]);

        MateriPembelajaran::create($request->all());

        return redirect()->route('materi_pembelajaran')->with('success', 'Materi berhasil ditambahkan');
    }

    //untuk mengupdate materi
    public function materiPembelajaran($id)
    {
        $materi = MateriPembelajaran::with(['guru', 'mapel', 'siswa'])->findOrFail($id);

        return view('guru.detail_materi_pembelajaran', compact('materi'));
    }

    public function updateMateri(Request $request, $id)
    {
        $request->validate([
            'nama_materi' => 'required',
            'materi' => 'required',
            'jenis_kurikulum' => 'required'
        ]);

        $materi = MateriPembelajaran::findOrFail($id);
        $materi->update($request->all());

        return redirect()->back()->with('success', 'Materi berhasil diperbarui');
    }



    public function indexVideoMateri()
    {
        $video = VideoMateri::with(['guru', 'siswa', 'mapel'])->get();
        $guru = Guru::all();
        $siswa = Siswa::all();
        $mapel = Mapel::all();

        return view('guru.video_materi_belajar', compact('video', 'guru', 'siswa', 'mapel'));
    }



    public function storeVideoMateri(Request $request)
    {
        $request->validate([
            'id_guru' => 'required',
            'id_siswa' => 'nullable',
            'id_mapel' => 'required',
            'link_video' => 'required',
            'jenis_kurikulum' => 'required',
            'nama_materi' => 'required'
        ]);

        VideoMateri::create($request->all());

        return redirect()->back()->with('success', 'Video materi berhasil ditambahkan');
    }

    public function updateVideoMateri(Request $request, $id)
    {
        $request->validate([
            'link_video' => 'required',
            'jenis_kurikulum' => 'required',
            'nama_materi' => 'required'
        ]);

        $video = VideoMateri::findOrFail($id);
        $video->update($request->all());

        return redirect()->back()->with('success', 'Video materi berhasil diperbarui');
    }
}
