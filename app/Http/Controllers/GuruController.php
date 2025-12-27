<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\JadwalBimbel;
use App\Models\TugasSiswa;
use App\Models\MateriPembelajaran;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\VideoMateri;
use App\Models\LaporanPerkembanganSiswa;



use App\Models\AbsensiGuru;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    // UNTUK MENAMPILKAN JADWAL 
    public function jadwalMengajar()
    {
        // 1. Ambil ID Guru dari user yang sedang login
        // Kita menggunakan relasi 'guru' yang ada di model User
        $idGuru = Auth::user()->guru->id;

        // 2. Tambahkan filter ->where('id_guru', $idGuru)
        $jadwal = JadwalBimbel::with(['guru', 'siswa', 'mapel'])
            ->where('id_guru', $idGuru) // Filter di sini
            ->orderBy('created_at', 'desc') // Opsional: Urutkan dari yang terbaru
            ->paginate(10); // Gunakan paginate agar halaman tidak terlalu panjang

        return view('guru.jadwal_mengajar', compact('jadwal'));
    }

    // UNTUK TAMBAH ABSENSI GURU
    public function index(Request $request)
    {
        // --- BAGIAN 1: FILTER HISTORY ABSENSI ---
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

        // --- BAGIAN 2: LOGIKA PENGECEKAN JADWAL (PERBAIKAN) ---

        // 1. Ambil Waktu Sekarang
        $waktuSekarang = Carbon::now();
        $jamSekarang = $waktuSekarang->format('H:i:s'); // Jam Server (WIB jika config sudah benar)

        // 2. Mapping Hari Manual (Inggris -> Indo Uppercase)
        // Ini solusi untuk masalah "Saturday" vs "SABTU"
        $hariInggris = $waktuSekarang->format('l');

        $mapHari = [
            'Sunday'    => 'MINGGU',
            'Monday'    => 'SENIN',
            'Tuesday'   => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday'  => 'KAMIS',
            'Friday'    => 'JUMAT',
            'Saturday'  => 'SABTU'
        ];

        // Pakai array map, jika tidak ketemu default ke string aslinya
        $hariIni = $mapHari[$hariInggris] ?? strtoupper($hariInggris);

        // 3. Ambil ID Guru yang sedang login
        $idGuru = Auth::user()->guru->id;

        // 4. Cari Jadwal yang Sesuai
        // Logika: Guru Benar + Hari Benar + Jam Sekarang ada di antara Mulai & Selesai
        $jadwalAktif = JadwalBimbel::where('id_guru', $idGuru)
            ->where('hari', $hariIni) // Menggunakan hasil mapping (misal: SABTU)
            ->whereTime('waktu_mulai', '<=', $jamSekarang)
            ->whereTime('waktu_selesai', '>=', $jamSekarang)
            ->first();

        // Debugging (Opsional: Hapus tanda komentar // di bawah jika ingin cek isi variabel di layar)
        // dd($hariIni, $jamSekarang, $jadwalAktif);

        // --- BAGIAN 3: LEMPAR KE VIEW ---
        return view('guru.absensi', compact('data', 'bulan', 'tahun', 'jadwalAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'mapel' => 'required',
            'bukti' => 'required|mimes:jpg,jpeg,png', // Tambahkan png jika perlu
            'catatan' => 'nullable',
            'id_jadwal_bimbel' => 'required'
        ]);

        $file = $request->file('bukti');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti_absensi'), $namaFile);

        AbsensiGuru::create([
            'id_guru' => Auth::user()->guru->id,
            'id_jadwal_bimbel' => $request->id_jadwal_bimbel,
            'mapel' => $request->mapel,
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


    //controller untuk tugas siswa
    public function indexTugas()
    {
        $siswa = Siswa::all(); // atau bisa pakai paginate jika datanya banyak
        return view('guru.tugas_siswa', compact('siswa'));
    }
    public function detailTugasSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $tugas = TugasSiswa::where('id_siswa', $id)->get();
        // AMBIL SEMUA DATA MAPEL AGAR PILIHANNYA SESUAI DATABASE
        $daftar_mapel = Mapel::all();

        return view('guru.detail_tugas_siswa', compact('siswa', 'tugas', 'daftar_mapel'));
    }

    public function simpanTugas(Request $request)
    {
        // ... (Validasi tetap sama) ...

        $siswa = Siswa::find($request->id_siswa);
        $mapel = Mapel::find($request->id_mapel);

        TugasSiswa::create([
            'id_siswa'      => $request->id_siswa,
            'id_mapel'      => $request->id_mapel,
            'penugasan'     => $request->penugasan,

            // --- PERBAIKAN DI SINI ---
            // Ganti 'created_at' menjadi 'tanggal'
            'tanggal'       => $request->tanggal,

            // HAPUS baris 'created_at'. 
            // Laravel akan otomatis mengisi created_at dengan jam & tanggal SEKARANG (real-time).

            'waktu_selesai' => $request->waktu_selesai,
            'waktu_mulai'   => Carbon::now()->format('H:i:s'),

            // Data Default
            'id_guru'          => 1,
            'id_jadwal_bimbel' => null,
            'alamat_siswa'     => $siswa->alamat ?? '-',
            'nama_mapel'       => $mapel->nama_mapel,
            'jawaban_siswa'    => 'Belum mengerjakan',
            'nilai_tugas'      => 0,
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan');
    }
    public function detailTugasPerSiswa($id, $tugas_id)
    {
        $siswa = Siswa::findOrFail($id);
        $tugas = TugasSiswa::findOrFail($tugas_id);

        return view('guru.detail_tugas_persiswa', compact('siswa', 'tugas'));
    }

    public function updateTugas(Request $request, $id)
    {
        // 1. TAMBAHKAN VALIDASI WAKTU
        $request->validate([
            'nama_mapel'    => 'required|string',
            'penugasan'     => 'required|string',
            'tanggal'       => 'required|date',
            'waktu_selesai' => 'required', // <--- Pastikan ini ada
            'nilai_tugas'   => 'nullable|numeric|min:0|max:100',
            'file'          => 'nullable|mimes:pdf|max:2048',
        ]);

        $tugas = TugasSiswa::findOrFail($id);

        // ... (Logika file tetap sama jangan diubah) ...

        $tugas->update([
            'nama_mapel'    => $request->nama_mapel,
            'penugasan'     => $request->penugasan,
            'tanggal'       => $request->tanggal,

            // --- BAGIAN INI AKAN BERHASIL SETELAH VIEW DIPERBAIKI ---
            'waktu_selesai' => $request->waktu_selesai,

            'nilai_tugas'   => $request->nilai_tugas ?? 0,
            'jawaban_siswa' => $request->jawaban_siswa,
            // Pastikan update file jika ada, jika tidak pakai file lama
            'file'          => isset($filename) ? $filename : $tugas->file
        ]);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
    }


    //Controller untuk Laporan Perkembangan siswa
    public function laporanPerkembangan()
    {
        $siswa = Siswa::all(); // atau paginate(12)
        return view('guru.laporan_perkembangan_siswa', compact('siswa'));
    }

    public function detailLaporanPerkembangan($id)
    {
        $siswa = Siswa::findOrFail($id);

        // GUNAKAN GET() AGAR TIDAK ERROR PAGINATION
        // Saya tambahkan orderBy agar data terbaru muncul di atas
        $laporan = LaporanPerkembanganSiswa::where('id_siswa', $id)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung rata-rata
        $rata_rata = TugasSiswa::where('id_siswa', $id)->avg('nilai_tugas');

        return view('guru.detail_laporan_perkembangan_siswa', compact('siswa', 'laporan', 'rata_rata'));
    }

    public function tambahLaporan(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'hari'     => 'required|string',
            'tanggal'  => 'required|date',
            'waktu'    => 'required',
            'mapel'    => 'required|string',
            'catatan'  => 'required|string', // Di form name-nya 'catatan'
        ]);

        // 2. Simpan ke Database
        // Kita simpan input 'catatan' ke kolom 'laporan_perkembangan'
        LaporanPerkembanganSiswa::create([
            'id_siswa' => $request->id_siswa,
            'hari'     => $request->hari,
            'tanggal'  => $request->tanggal,
            'waktu'    => $request->waktu,
            'mapel'    => $request->mapel,
            'laporan_perkembangan' => $request->catatan,

            // Default value (jika diperlukan)
            'id_jadwal_bimbel' => null,
            'nilai_rata_rata'  => 0,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil ditambahkan');
    }

    public function updateLaporan(Request $request, $id)
    {
        $request->validate([
            'hari'     => 'required|string',
            'tanggal'  => 'required|date',
            'waktu'    => 'required',
            'mapel'    => 'required|string',
            'catatan'  => 'required|string',
        ]);

        $laporan = LaporanPerkembanganSiswa::findOrFail($id);

        $laporan->update([
            'hari'     => $request->hari,
            'tanggal'  => $request->tanggal,
            'waktu'    => $request->waktu,
            'mapel'    => $request->mapel,
            'laporan_perkembangan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diperbarui');
    }
}
