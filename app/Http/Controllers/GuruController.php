<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
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
use App\Models\GajiGuru;
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
        // --- LANGKAH 1: AMBIL ID GURU YANG LOGIN TERLEBIH DAHULU ---
        // Kita butuh ID ini untuk memfilter history absensi & jadwal
        $idGuru = Auth::user()->guru->id;

        // --- BAGIAN 2: FILTER HISTORY ABSENSI ---
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // PERBAIKAN DISINI: Tambahkan where('id_guru', $idGuru)
        $data = AbsensiGuru::where('id_guru', $idGuru)
            ->when($bulan, function ($q) use ($bulan) {
                return $q->whereMonth('tanggal', $bulan);
            })
            ->when($tahun, function ($q) use ($tahun) {
                return $q->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        // --- BAGIAN 3: LOGIKA PENGECEKAN JADWAL (TOMBOL TAMBAH) ---

        // 1. Ambil Waktu Sekarang
        $waktuSekarang = \Carbon\Carbon::now();
        $jamSekarang = $waktuSekarang->format('H:i:s');

        // 2. Mapping Hari Manual (Inggris -> Indo Uppercase)
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
        $hariIni = $mapHari[$hariInggris] ?? strtoupper($hariInggris);

        // 3. Cari Jadwal yang Sesuai untuk Tombol Tambah
        $jadwalAktif = \App\Models\JadwalBimbel::where('id_guru', $idGuru)
            ->where('hari', $hariIni)
            ->whereTime('waktu_mulai', '<=', $jamSekarang)
            ->whereTime('waktu_selesai', '>=', $jamSekarang)
            ->first();

        // --- BAGIAN 4: LEMPAR KE VIEW ---
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

    public function indexMateri(Request $request)
    {
        // 1. Ambil User yang Login (ini ID dari tabel users, misal: 6)
        $userLogin = Auth::user();

        // 2. CARI DATA GURU BERDASARKAN ID_USER
        $guruAsli = Guru::where('id_user', $userLogin->id)->first();

        // Cek jika data guru tidak ditemukan (misal admin yang login, bukan guru)
        if (!$guruAsli) {
            return redirect()->back()->with('error', 'Akun Anda tidak terdaftar sebagai Guru!');
        }

        $id_guru_sebenarnya = $guruAsli->id;

        // 3. Ambil Jenjang (Untuk Filter)
        $jenjang = Siswa::select('jenjang')->distinct()->pluck('jenjang');

        // 4. Query Materi (Pakai ID Guru yang asli: 3)
        $query = MateriPembelajaran::with(['guru', 'mapel', 'siswa'])
            ->where('id_guru', $id_guru_sebenarnya);

        if ($request->filled('jenjang')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('jenjang', $request->jenjang);
            });
        }

        $materi = $query->orderBy('created_at', 'desc')->get();

        // 5. FILTER SISWA BERDASARKAN JADWAL (Pakai ID Guru: 3)
        $id_siswa_bimbingan = DB::table('jadwal_bimbel')
            ->where('id_guru', $id_guru_sebenarnya)
            ->pluck('id_siswa');

        // Ambil data siswa (akan muncul Mikael id:2 jika sesuai jadwal)
        $siswa = Siswa::whereIn('id', $id_siswa_bimbingan)->get();

        // 6. FILTER MAPEL BERDASARKAN JADWAL
        $id_mapel_ajar = DB::table('jadwal_bimbel')
            ->where('id_guru', $id_guru_sebenarnya)
            ->pluck('id_mapel');

        $mapel = Mapel::whereIn('id', $id_mapel_ajar)->get();

        // Kirim variable $guruAsli ke view agar namanya benar "Dewi Dini"
        return view('guru.materi_pembelajaran', compact('materi', 'guruAsli', 'siswa', 'mapel', 'jenjang'));
    }

    public function storeMateri(Request $request)
    {
        $request->validate([
            'id_siswa' => 'nullable',
            'id_mapel' => 'required',
            'nama_materi' => 'required',
            'materi' => 'required',
            'jenis_kurikulum' => 'required',
            // Validasi file: Opsional, max 5MB, format tertentu
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        // AMBIL ID GURU ASLI
        $guru = Guru::where('id_user', Auth::id())->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data Guru tidak valid.');
        }

        $data = $request->all();
        $data['id_guru'] = $guru->id;

        // --- LOGIKA UPLOAD FILE ---
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');

            // Buat nama file unik: waktu_namafileasli
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke folder: storage/app/public/materi
            // Pastikan folder ini nanti dilink ke public
            $file->storeAs('public/materi', $filename);

            // Masukkan nama file ke array data untuk disimpan ke DB
            $data['file_materi'] = $filename;
        }
        // ---------------------------

        MateriPembelajaran::create($data);

        return redirect()->route('materi_pembelajaran')->with('success', 'Materi berhasil ditambahkan');
    }

    public function downloadMateri($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);

        // Cek apakah kolom file_materi ada isinya
        if (!$materi->file_materi) {
            return back()->with('error', 'Materi ini tidak memiliki file lampiran.');
        }

        // Tentukan path file (sesuai dengan tempat kita upload di storeMateri: public/materi)
        $filePath = 'public/materi/' . $materi->file_materi;

        // Cek fisik file di storage
        if (Storage::exists($filePath)) {
            // Download file
            return Storage::download($filePath, $materi->file_materi);
        } else {
            return back()->with('error', 'File fisik tidak ditemukan di server.');
        }
    }

    // Halaman Detail Materi
    public function materiPembelajaran($id)
    {
        // 1. Ambil User Login
        $userLogin = Auth::user();

        // 2. Cari Data Guru Asli
        $guruAsli = Guru::where('id_user', $userLogin->id)->first();

        if (!$guruAsli) {
            abort(403, 'Akses ditolak. Anda bukan Guru.');
        }

        // 3. Query Materi menggunakan ID GURU ASLI
        $materi = MateriPembelajaran::with(['guru', 'mapel', 'siswa'])
            ->where('id_guru', $guruAsli->id) // Pakai ID 3, bukan 6
            ->findOrFail($id);

        return view('guru.detail_materi_pembelajaran', compact('materi'));
    }

    // Proses Update Materi (Termasuk Ganti File)
    public function updateMateri(Request $request, $id)
    {
        $request->validate([
            'nama_materi' => 'required',
            'materi' => 'required',
            'jenis_kurikulum' => 'required',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        // Ambil ID Guru Asli untuk keamanan
        $guru = Guru::where('id_user', Auth::id())->first();

        // Cari materi dan pastikan milik guru yang login
        $materi = MateriPembelajaran::where('id_guru', $guru->id)->findOrFail($id);

        $data = $request->except(['file_materi']);

        // --- LOGIKA GANTI FILE ---
        if ($request->hasFile('file_materi')) {
            // 1. Hapus file lama jika ada (Opsional, agar storage tidak penuh)
            if ($materi->file_materi && Storage::exists('public/materi/' . $materi->file_materi)) {
                Storage::delete('public/materi/' . $materi->file_materi);
            }

            // 2. Upload file baru
            $file = $request->file('file_materi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/materi', $filename);

            // 3. Masukkan nama file baru ke data update
            $data['file_materi'] = $filename;
        }
        // -------------------------

        $materi->update($data);

        return redirect()->back()->with('success', 'Materi berhasil diperbarui');
    }

    // CONTROLLER MENU VIDEO MATERI
    public function indexVideoMateri()
    {
        // 1. Ambil ID Guru yang sedang login
        // Asumsi: Guru login menggunakan sistem Auth Laravel
        // $guru_login = Auth::user();

        // Jika Auth menggunakan tabel users tapi relasi ke guru, gunakan:
        $guru_login = Guru::where('id_user', Auth::id())->first();

        // 2. Ambil Video KHUSUS milik guru tersebut
        $video = VideoMateri::with(['guru', 'siswa', 'mapel'])
            ->where('id_guru', $guru_login->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Ambil Daftar Siswa sesuai Jadwal Bimbel guru tersebut
        // Mengambil semua siswa yang ada di jadwal_bimbel dengan id_guru ini
        $siswa_ampu = Siswa::whereIn('id', function ($query) use ($guru_login) {
            $query->select('id_siswa')
                ->from('jadwal_bimbel')
                ->where('id_guru', $guru_login->id);
        })->get();

        // 4. Ambil Mapel yang diampu guru tersebut dari Jadwal Bimbel
        // Kita ambil record jadwal pertama untuk mendapatkan mapelnya
        $jadwal_guru = DB::table('jadwal_bimbel')
            ->where('id_guru', $guru_login->id)
            ->first();

        $mapel_guru = null;
        if ($jadwal_guru) {
            $mapel_guru = Mapel::find($jadwal_guru->id_mapel);
        }

        // Kirim data spesifik ke view
        return view('guru.video_materi_belajar', compact('video', 'guru_login', 'siswa_ampu', 'mapel_guru'));
    }

    public function storeVideoMateri(Request $request)
    {
        $request->validate([
            'id_guru' => 'required',
            'id_mapel' => 'required',
            'link_video' => 'required',
            'jenis_kurikulum' => 'required',
            'nama_materi' => 'required'
        ]);

        VideoMateri::create($request->all());

        return redirect()->back()->with('success', 'Video materi berhasil ditambahkan');
    }

    // Update function tetap sama, hanya validasi akses jika perlu
    public function updateVideoMateri(Request $request, $id)
    {
        $video = VideoMateri::findOrFail($id);

        // Pastikan guru hanya bisa edit videonya sendiri
        if ($video->id_guru != Auth::id()) { // Sesuaikan jika pakai Auth::user()->id
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $video->update($request->all());

        return redirect()->back()->with('success', 'Video materi berhasil diperbarui');
    }


    //controller untuk tugas siswa
    public function indexTugas()
    {
        // 1. Ambil ID User yang sedang login (Contoh: 6 - Dewi Dini)
        $user_id_login = Auth::id();

        // 2. Cari profil Guru yang punya id_user tersebut
        // Kita cari di tabel 'guru' kolom 'id_user'
        $guru_profile = Guru::where('id_user', $user_id_login)->first();

        // Cek keamanan: Jika akun login tapi belum ada data di tabel guru
        if (!$guru_profile) {
            // Return halaman kosong agar tidak error
            return view('guru.tugas_siswa', ['siswa' => \App\Models\Siswa::whereRaw('1 = 0')->paginate(10)]);
        }

        // 3. Ambil ID Guru Asli (Contoh: akan dapat angka 3)
        $id_guru_asli = $guru_profile->id;

        // 4. Cari jadwal bimbel yang id_guru-nya adalah 3
        $id_siswa_diampu = JadwalBimbel::where('id_guru', $id_guru_asli)
            ->pluck('id_siswa')
            ->unique();

        // 5. Ambil data Siswa sesuai ID yang ditemukan
        $siswa = Siswa::whereIn('id', $id_siswa_diampu)->paginate(10);

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
        // 1. Ambil Data Guru yang sedang Login
        $user_id = Auth::id();
        $guru = Guru::where('id_user', $user_id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data Guru tidak ditemukan.');
        }

        // 2. Ambil Data Siswa & Mapel
        $siswa = Siswa::find($request->id_siswa);
        $mapel = Mapel::find($request->id_mapel);

        // --- PROSES UPLOAD FILE ---
        $nama_file_database = null; // Default null jika tidak ada file

        if ($request->hasFile('file')) {
            // Validasi ekstensi dan ukuran (opsional tapi disarankan)
            $request->validate([
                'file' => 'mimes:pdf,jpg,jpeg,png|max:2048' // Max 2MB
            ]);

            $file = $request->file('file');
            // Buat nama unik: waktu_namamapel_namasiswa.ext
            $filename = time() . '_' . preg_replace('/\s+/', '_', $mapel->nama_mapel) . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder: public/uploads/tugas_guru
            // Pastikan folder ini ada, atau Laravel akan membuatnya
            $file->move(public_path('uploads/tugas_guru'), $filename);

            $nama_file_database = $filename;
        }
        // --------------------------

        // 3. Simpan ke Database
        TugasSiswa::create([
            'id_siswa'          => $request->id_siswa,
            'id_mapel'          => $request->id_mapel,
            'penugasan'         => $request->penugasan,

            // Simpan nama file ke kolom 'file'
            'file'              => $nama_file_database,

            // Tanggal & Waktu
            'tanggal'           => $request->tanggal,
            'waktu_mulai'       => \Carbon\Carbon::now()->format('H:i:s'),
            'waktu_selesai'     => $request->waktu_selesai,

            // Data Otomatis
            'id_guru'           => $guru->id,
            'id_jadwal_bimbel'  => null,

            // Data Pelengkap
            'alamat_siswa'      => $siswa->alamat ?? '-',
            'nama_mapel'        => $mapel->nama_mapel,
            'jawaban_siswa'     => 'Belum mengerjakan',
            'nilai_tugas'       => 0,
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
        // 1. Validasi (Hapus validasi jawaban_siswa karena inputnya sudah tidak ada)
        $request->validate([
            'nama_mapel'    => 'required|string',
            'penugasan'     => 'required|string',
            'tanggal'       => 'required|date',
            'waktu_selesai' => 'required',
            'nilai_tugas'   => 'nullable|numeric|min:0|max:100',
            'file'          => 'nullable|mimes:pdf|max:2048', // Maksimal 2MB
        ]);

        $tugas = TugasSiswa::findOrFail($id);

        // 2. Tampung data yang akan diupdate ke variable array
        // PERBAIKAN: Hapus 'jawaban_siswa' dari sini agar jawaban siswa yang sudah ada TIDAK TERTIMPA / Error
        $dataUpdate = [
            'nama_mapel'    => $request->nama_mapel,
            'penugasan'     => $request->penugasan,
            'tanggal'       => $request->tanggal,
            'waktu_selesai' => $request->waktu_selesai,
            'nilai_tugas'   => $request->nilai_tugas ?? 0,
        ];

        // 3. Logika Upload File (Hanya jika ada file baru)
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($tugas->file && file_exists(public_path('uploads/tugas_guru/' . $tugas->file))) {
                unlink(public_path('uploads/tugas_guru/' . $tugas->file));
            }

            // Upload file baru
            $file = $request->file('file');
            // Buat nama unik
            $filename = time() . '_' . preg_replace('/\s+/', '_', $request->nama_mapel) . '.' . $file->getClientOriginalExtension();

            // Simpan ke folder public/uploads/tugas_guru
            $file->move(public_path('uploads/tugas_guru'), $filename);

            // Masukkan nama file baru ke array update
            $dataUpdate['file'] = $filename;
        }

        // 4. Eksekusi Update
        $tugas->update($dataUpdate);

        return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
    }



    //Gaji Guru
    public function gajiGuru(Request $request)
    {
        $userId = Auth::id();
        $guru = Guru::where('id_user', $userId)->firstOrFail();

        // Query Dasar
        // PERBAIKAN: Saya tambahkan COUNT(id) as total_kehadiran
        $query = GajiGuru::selectRaw('
                YEAR(created_at) as year, 
                MONTH(created_at) as month, 
                SUM(nominal_gaji) as total_gaji_bulan_ini,
                COUNT(id) as total_kehadiran, 
                MAX(gaji_per_jam) as gaji_per_jam_terakhir,
                MAX(kehadiran) as status_pembayaran,
                MAX(created_at) as created_at
            ')
            ->where('id_guru', $guru->id);

        // Filter Bulan
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('created_at', $request->bulan);
        }

        $riwayatGaji = $query->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(10);

        $riwayatGaji->appends($request->all());

        return view('guru.gaji', compact('riwayatGaji', 'guru'));
    }

    public function downloadGajiPDF($year, $month)
    {
        $userId = Auth::id();
        $guru = Guru::where('id_user', $userId)->firstOrFail();

        // Query spesifik untuk bulan dan tahun yang dipilih
        $dataGaji = GajiGuru::selectRaw('
            YEAR(created_at) as year, 
            MONTH(created_at) as month, 
            SUM(nominal_gaji) as total_gaji_bulan_ini,
            COUNT(id) as total_kehadiran, 
            MAX(gaji_per_jam) as gaji_per_jam_terakhir,
            MAX(kehadiran) as status_pembayaran
        ')
            ->where('id_guru', $guru->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('year', 'month')
            ->firstOrFail(); // Mengambil satu baris data saja

        // Generate tanggal cetak (misal: hari ini atau akhir bulan gaji)
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');

        // Load view khusus PDF
        $pdf = Pdf::loadView('guru.pdf_gaji', compact('guru', 'dataGaji', 'tanggalCetak'))
            ->setPaper('a4', 'portrait'); // Set ukuran kertas

        // Download file dengan nama dinamis
        return $pdf->download('Slip_Gaji_' . $guru->nama . '_' . $month . '-' . $year . '.pdf');
    }




    //Controller untuk Laporan Perkembangan siswa
    public function laporanPerkembangan()
    {
        // 1. Ambil ID User yang sedang login
        $id_user_login = Auth::id();

        // 2. Cari data Guru berdasarkan id_user tersebut
        $data_guru = Guru::where('id_user', $id_user_login)->first();

        // Cek jika data guru tidak ditemukan (misal login sebagai admin bukan guru)
        if (!$data_guru) {
            return redirect()->back()->with('error', 'Data Guru tidak ditemukan untuk user ini.');
        }

        // 3. Ambil ID GURU Asli (Primary Key tabel guru)
        $id_guru_asli = $data_guru->id;

        // 4. Gunakan ID GURU Asli untuk filter jadwal
        $siswa = Siswa::whereHas('jadwal_bimbel', function ($q) use ($id_guru_asli) {
            $q->where('id_guru', $id_guru_asli);
        })->get();

        return view('guru.laporan_perkembangan_siswa', compact('siswa'));
    }

    public function detailLaporanPerkembangan($id)
    {
        $id_user_login = Auth::id();
        $guru = Guru::where('id_user', $id_user_login)->firstOrFail();
        $id_guru_asli = $guru->id;

        $siswa = Siswa::findOrFail($id);

        // Ambil laporan
        $laporan = LaporanPerkembanganSiswa::where('id_siswa', $id)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung rata-rata
        $rata_rata = TugasSiswa::where('id_siswa', $id)
            ->where('id_guru', $id_guru_asli)
            ->avg('nilai_tugas');

        // Ambil Mapel & Jadwal
        $jadwal = JadwalBimbel::with('mapel')
            ->where('id_guru', $id_guru_asli)
            ->where('id_siswa', $id)
            ->first();

        $nama_mapel = $jadwal ? $jadwal->mapel->nama_mapel : '-';
        // TAMBAHAN: Simpan ID Jadwal untuk dikirim ke view
        $id_jadwal  = $jadwal ? $jadwal->id : null;

        // Jangan lupa kirim 'id_jadwal' ke compact
        return view('guru.detail_laporan_perkembangan_siswa', compact('siswa', 'laporan', 'rata_rata', 'nama_mapel', 'id_jadwal'));
    }

    // Di dalam GuruController.php

    public function tambahLaporan(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'id_jadwal_bimbel' => 'required',
            'hari'     => 'required|string',
            'tanggal'  => 'required|date',
            'waktu'    => 'required',
            'mapel'    => 'required|string',
            'catatan'  => 'required|string',
        ]);

        // 2. Ambil data Guru untuk menghitung rata-rata
        $id_user_login = Auth::id();
        $guru = Guru::where('id_user', $id_user_login)->first();

        // Default nilai 0 jika guru tidak ditemukan atau error
        $nilai_rata_rata = 0;

        if ($guru) {
            // Hitung rata-rata dari tabel TugasSiswa
            $nilai_rata_rata = TugasSiswa::where('id_siswa', $request->id_siswa)
                ->where('id_guru', $guru->id)
                ->avg('nilai_tugas');

            // Jika belum ada tugas (hasil null), set ke 0
            if ($nilai_rata_rata === null) {
                $nilai_rata_rata = 0;
            }
        }

        // 3. Simpan ke Database
        LaporanPerkembanganSiswa::create([
            'id_siswa' => $request->id_siswa,
            'id_jadwal_bimbel' => $request->id_jadwal_bimbel,
            'hari'     => $request->hari,
            'tanggal'  => $request->tanggal,
            'waktu'    => $request->waktu,
            'mapel'    => $request->mapel,
            // Gunakan hasil perhitungan di atas
            'nilai_rata-rata'  => $nilai_rata_rata,
            'laporan_perkembangan' => $request->catatan,
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
