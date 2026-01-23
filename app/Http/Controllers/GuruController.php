<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
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
        // ... (Validasi & Ambil data user - Biarkan sama seperti sebelumnya) ...
        $request->validate([
            'id_mapel' => 'required',
            'nama_materi' => 'required',
            'materi' => 'required',
            'jenis_kurikulum' => 'required',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120',
        ]);

        $guru = Guru::where('id_user', Auth::id())->first();
        $data = $request->all();
        $data['id_guru'] = $guru->id;

        // --- PERBAIKAN UPLOAD (Gunakan public_path) ---
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $cleanName = preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $cleanName;

            // Simpan langsung ke folder public/materi di root project
            $file->move(public_path('materi'), $filename);

            $data['file_materi'] = $filename;
        }
        // ----------------------------------------------

        MateriPembelajaran::create($data);
        return redirect()->route('materi_pembelajaran')->with('success', 'Materi berhasil ditambahkan');
    }

    public function downloadMateri($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);

        // Gunakan public_path agar sinkron dengan saat upload
        $filePath = public_path('materi/' . $materi->file_materi);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'File tidak ditemukan di server.');
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

        $guru = Guru::where('id_user', Auth::id())->first();
        $materi = MateriPembelajaran::where('id_guru', $guru->id)->findOrFail($id);

        $data = $request->except(['file_materi']);

        // --- PERBAIKAN LOGIKA GANTI FILE ---
        if ($request->hasFile('file_materi')) {
            $file = $request->file('file_materi');

            // Bersihkan nama file
            $cleanName = preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $cleanName;

            // --- PERBAIKAN: TEMBAK LANGSUNG KE PUBLIC_HTML ---
            $tujuanUpload = "/home/akat8215/public_html/materi";

            // Pastikan folder ada, kalau belum ada kita buat
            if (!file_exists($tujuanUpload)) {
                mkdir($tujuanUpload, 0755, true);
            }

            $file->move($tujuanUpload, $filename);

            $data['file_materi'] = $filename;
        }
        // -----------------------------------

        $materi->update($data);

        return redirect()->back()->with('success', 'Materi berhasil diperbarui');
    }

    // CONTROLLER MENU VIDEO MATERI
    public function indexVideoMateri(Request $request) // Tambahkan Request $request
    {
        // 1. Ambil ID Guru yang sedang login
        $guru_login = Guru::where('id_user', Auth::id())->first();

        // Safety check
        if (!$guru_login) {
            return redirect()->back()->with('error', 'Data Guru tidak ditemukan.');
        }

        // 2. Query Awal Video (Gunakan query builder dulu, jangan langsung ->get())
        $query = VideoMateri::with(['guru', 'siswa', 'mapel'])
            ->where('id_guru', $guru_login->id);

        // --- TAMBAHAN LOGIKA SEARCH DI SINI ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_materi', 'like', '%' . $search . '%')
                    ->orWhere('jenis_kurikulum', 'like', '%' . $search . '%');
            });
        }
        // ---------------------------------------

        // Eksekusi Query
        $video = $query->orderBy('created_at', 'desc')->get();

        // 3. Ambil Daftar Siswa (Tetap)
        $siswa_ampu = Siswa::whereIn('id', function ($query) use ($guru_login) {
            $query->select('id_siswa')
                ->from('jadwal_bimbel')
                ->where('id_guru', $guru_login->id);
        })->get();

        // 4. Ambil Mapel (Tetap)
        $jadwal_guru = DB::table('jadwal_bimbel')
            ->where('id_guru', $guru_login->id)
            ->first();

        $mapel_guru = null;
        if ($jadwal_guru) {
            $mapel_guru = Mapel::find($jadwal_guru->id_mapel);
        }

        return view('guru.video_materi_belajar', compact('video', 'guru_login', 'siswa_ampu', 'mapel_guru'));
    }

    public function storeVideoMateri(Request $request)
    {
        $request->validate([
            'id_guru' => 'required',
            'id_mapel' => 'required',
            'link_video' => 'required',
            'jenis_kurikulum' => 'required',
            'nama_materi' => 'required',
            'id_siswa' => 'nullable' // Tambahkan validasi nullable
        ]);

        // PERBAIKAN PENTING:
        // Input select 'value=""' akan mengirim string kosong "".
        // Database type Integer akan error jika menerima "". Harus diubah jadi NULL.
        $data = $request->all();
        if (empty($data['id_siswa'])) {
            $data['id_siswa'] = null;
        }

        VideoMateri::create($data);

        return redirect()->back()->with('success', 'Video materi berhasil ditambahkan');
    }

    public function updateVideoMateri(Request $request, $id)
    {
        $video = VideoMateri::findOrFail($id);

        // Ambil data guru dari user yang sedang login
        $guru_login = Guru::where('id_user', Auth::id())->first();

        // PERBAIKAN LOGIKA AKSES:
        // Jangan bandingkan $video->id_guru dengan Auth::id() (ini ID tabel users)
        // Bandingkan dengan $guru_login->id (ini ID tabel gurus)
        if (!$guru_login || $video->id_guru != $guru_login->id) {
            return redirect()->back()->with('error', 'Akses ditolak. Ini bukan video Anda.');
        }

        // Kita gunakan $request->except agar field yang tidak ada di form edit (seperti id_guru/id_mapel) 
        // tidak menimpa data lama dengan null, meskipun update() bawaan Laravel sudah pintar.
        // Tapi kita perlu memastikan 'jenis_kurikulum' terupdate jika ada di form.
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
        // 1. Validasi (SAYA UPDATE AGAR BISA GAMBAR JUGA, SAMA SEPERTI SAAT TAMBAH)
        $request->validate([
            'nama_mapel'    => 'required|string',
            'penugasan'     => 'required|string',
            'tanggal'       => 'required|date',
            'waktu_selesai' => 'required',
            'nilai_tugas'   => 'nullable|numeric|min:0|max:100',
            // Izinkan PDF dan Gambar
            'file'          => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $tugas = TugasSiswa::findOrFail($id);

        // 2. Siapkan data update dasar
        $dataUpdate = [
            'nama_mapel'    => $request->nama_mapel,
            'penugasan'     => $request->penugasan,
            'tanggal'       => $request->tanggal,
            'waktu_selesai' => $request->waktu_selesai,
            'nilai_tugas'   => $request->nilai_tugas ?? 0,
        ];

        // 3. Logika Upload File
        if ($request->hasFile('file')) {
            // Cek apakah file benar-benar valid sebelum diproses
            if ($request->file('file')->isValid()) {

                // Hapus file lama jika ada fisiknya
                if ($tugas->file && file_exists(public_path('uploads/tugas_guru/' . $tugas->file))) {
                    unlink(public_path('uploads/tugas_guru/' . $tugas->file));
                }

                $file = $request->file('file');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $request->nama_mapel) . '.' . $file->getClientOriginalExtension();

                // Pindahkan file
                $file->move(public_path('uploads/tugas_guru'), $filename);

                // Masukkan nama file baru ke array update
                $dataUpdate['file'] = $filename;
            }
        }

        // 4. Debugging (Opsional: Aktifkan jika masih gagal untuk melihat isi dataUpdate)
        // dd($dataUpdate); 

        // 5. Eksekusi Update
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
    public function laporanPerkembangan(Request $request)
    {
        // 1. Ambil ID User yang sedang login
        $id_user_login = Auth::id();

        // 2. Cari data Guru
        $data_guru = Guru::where('id_user', $id_user_login)->first();

        if (!$data_guru) {
            return redirect()->back()->with('error', 'Data Guru tidak ditemukan.');
        }

        $id_guru_asli = $data_guru->id;

        // 3. Query Siswa dengan Filter Pencarian
        $query = Siswa::whereHas('jadwal_bimbel', function ($q) use ($id_guru_asli) {
            $q->where('id_guru', $id_guru_asli);
        });

        // --- LOGIKA PENCARIAN DITAMBAHKAN DI SINI ---
        if ($request->has('search') && $request->search != null) {
            $keyword = $request->search;
            $query->where('nama', 'like', "%$keyword%"); // Mencari berdasarkan nama siswa
        }
        // --------------------------------------------

        // Eksekusi query
        $siswa = $query->get();
        // Jika ingin pagination aktif, ganti ->get() dengan ->paginate(10);

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

        // --- BAGIAN YANG DIUBAH (SEPERTI SISWA CONTROLLER) ---
        // 1. Hitung Average dulu (tetap difilter berdasarkan guru agar spesifik mapel)
        // Catatan: Di sini kita pakai $id karena itu parameter function (bukan $idSiswa)
        $average = TugasSiswa::where('id_siswa', $id)
            ->where('id_guru', $id_guru_asli)
            ->avg('nilai_tugas');

        // 2. Bulatkan nilai. Jika null (belum ada tugas), set ke 0
        $rata_rata = $average ? round($average) : 0;
        // -----------------------------------------------------

        // Ambil Mapel & Jadwal
        $jadwal = JadwalBimbel::with('mapel')
            ->where('id_guru', $id_guru_asli)
            ->where('id_siswa', $id)
            ->first();

        $nama_mapel = $jadwal ? $jadwal->mapel->nama_mapel : '-';

        // Simpan ID Jadwal
        $id_jadwal  = $jadwal ? $jadwal->id : null;

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
