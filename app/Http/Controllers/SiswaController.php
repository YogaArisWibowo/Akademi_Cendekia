<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AbsensiSiswa;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalBimbel;
use App\Models\LaporanPerkembanganSiswa;
use App\Models\MateriPembelajaran;
use App\Models\PembayaranSiswa;
use App\Models\Siswa;
use App\Models\TugasSiswa;
use App\Models\VideoMateri;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    //jadwal bimbel siswa
    public function jadwal()
    {
        // 1. Ambil data siswa dari user yang sedang login
        // Pastikan di Model User sudah ada relasi 'siswa' (seperti langkah sebelumnya)
        $siswa = Auth::user()->siswa;

        // Cek jaga-jaga jika akun user belum terhubung ke data siswa
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan untuk akun ini.');
        }

        // 2. Ambil jadwal hanya milik siswa tersebut
        // Kita gunakan paginate() agar pagination di view nanti berfungsi (bukan get())
        $jadwal = JadwalBimbel::with(['guru', 'siswa', 'mapel'])
            ->where('id_siswa', $siswa->id) // <--- INI KUNCINYA
            ->orderBy('hari', 'desc') // Opsional: urutkan data
            ->paginate(10); // Menampilkan 10 data per halaman

        return view('siswa.siswa_jadwalbimbel', compact('jadwal'));
    }



    // TAMPILKAN HALAMAN ABSENSI + FILTER
    public function absensi(Request $request)
    {
        // 1. Setup Waktu & Hari (PENTING: Timezone Asia/Jakarta)
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');

        $waktuSekarang = Carbon::now();
        $jamSekarang   = $waktuSekarang->format('H:i:s');
        $hariInggris   = $waktuSekarang->format('l');

        // Mapping Hari (Server Inggris -> DB Indonesia Uppercase)
        $mapHari = [
            'Sunday' => 'MINGGU',
            'Monday' => 'SENIN',
            'Tuesday' => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday' => 'KAMIS',
            'Friday' => 'JUMAT',
            'Saturday' => 'SABTU'
        ];
        $hariIni = $mapHari[$hariInggris];

        // 2. Cari Jadwal Aktif untuk Siswa yang Login
        // Asumsi: Anda punya relasi siswa di user, atau sesuaikan id_siswa
        $idSiswa = Auth::user()->siswa->id ?? Auth::id();

        $jadwalAktif = JadwalBimbel::where('id_siswa', $idSiswa)
            ->where('hari', $hariIni)
            ->whereTime('waktu_mulai', '<=', $jamSekarang)
            ->whereTime('waktu_selesai', '>=', $jamSekarang)
            ->first(); // Ambil 1 data saja

        // 3. Ambil Data History Absensi (Kode lama Anda)
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Filter history milik siswa ini saja
        $data = AbsensiSiswa::where('id_siswa', $idSiswa)
            ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
            ->orderBy('tanggal', 'desc')
            ->get();

        // Kirim $jadwalAktif ke view
        return view('siswa.siswa_absensi', compact('data', 'bulan', 'tahun', 'jadwalAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kehadiran' => 'required',
            'bukti'     => 'nullable|image|max:2048',
            'id_jadwal_bimbel' => 'required' // Wajib ada dari hidden input
        ]);

        try {
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $buktiPath = $request->file('bukti')->store('bukti_absensi', 'public');
            }

            // Simpan Data
            AbsensiSiswa::create([
                'id_siswa' => Auth::user()->siswa->id, // Sesuaikan dengan auth anda
                'id_jadwal_bimbel' => $request->id_jadwal_bimbel, // Ambil ID asli
                'kehadiran' => $request->kehadiran,
                'hari'      => $request->hari,
                'tanggal'   => $request->tanggal,
                'waktu'     => $request->waktu,
                'mapel'     => $request->mapel,
                'catatan'   => $request->catatan,
                'bukti'     => $buktiPath,
            ]);

            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }




    //  UNTUK TUGAS SISWA
    public function indexTugas()
    {
        // 1. Ambil ID User yang sedang login (Ini akan dapat angka 4)
        $id_user_login = Auth::id();

        // Cek login
        if (!$id_user_login) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        // 2. Cari data Siswa berdasarkan id_user
        // Kita cari di tabel siswa, mana yang id_user-nya = 4
        $siswa = Siswa::where('id_user', $id_user_login)->first();

        // Cek apakah data siswa ditemukan
        if (!$siswa) {
            // Jika user login tapi datanya tidak ada di tabel siswa
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan untuk user ini.');
        }

        // 3. Ambil data tugas menggunakan ID SISWA (Ini akan pakai angka 2)
        // Sekarang kita pakai $siswa->id (angka 2), BUKAN $id_user_login (angka 4)
        $daftar_tugas = TugasSiswa::where('id_siswa', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        // 4. Kirim ke view
        return view('siswa.siswa_daftartugas', compact('daftar_tugas'));
    }


    public function showTugas($id)
    {
        $id_user_login = Auth::id();
        $siswa = \App\Models\Siswa::where('id_user', $id_user_login)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil tugas berdasarkan ID dan pastikan milik siswa tersebut
        $tugas = TugasSiswa::where('id', $id)
            ->where('id_siswa', $siswa->id)
            ->firstOrFail();

        return view('siswa.siswa_tugas', compact('tugas'));
    }

    public function uploadTugas(Request $request, $id)
    {
        // 1. Validasi File (Wajib PDF, Maks 2MB)
        $request->validate([
            'file_jawaban' => 'required|mimes:pdf|max:2048',
        ]);

        // 2. Ambil Data Tugas
        $tugas = TugasSiswa::find($id);

        if ($request->hasFile('file_jawaban')) {
            // Hapus file lama jika ada (opsional, agar storage tidak penuh)
            if ($tugas->jawaban_siswa && file_exists(public_path('uploads/jawaban/' . $tugas->jawaban_siswa))) {
                unlink(public_path('uploads/jawaban/' . $tugas->jawaban_siswa));
            }

            // Simpan file baru
            $file = $request->file('file_jawaban');
            $filename = time() . '_' . $file->getClientOriginalName();
            // File akan disimpan di folder: public/uploads/jawaban
            $file->move(public_path('uploads/jawaban'), $filename);

            // Update Database
            $tugas->jawaban_siswa = $filename;
            $tugas->save();
        }

        return redirect()->back()->with('success', 'Tugas berhasil diunggah!');
    }








    // --- FITUR PEMBAYARAN ---

    public function pencatatanPembayaran(Request $request)
    {
        // 1. Ambil ID User yang login (Mikael login pakai User ID berapa?)
        $userId = Auth::id();

        // 2. Cari data siswa berdasarkan user yang login
        $siswa = Siswa::where('id_user', $userId)->first();

        // Validasi jika data siswa belum disambungkan
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // 3. Gunakan ID Siswa yang asli (Mikael itu ID 2)
        $pembayaran = PembayaranSiswa::with('siswa')
            ->where('id_siswa', $siswa->id) // Pakai $siswa->id, JANGAN angka 1 manual
            ->orderBy('tanggal_pembayaran', 'desc')
            ->paginate(10);

        return view('siswa.siswa_pencatatanpembayaran', compact('pembayaran'));
    }

    public function storePembayaran(Request $request)
    {
        $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'nama_orangtua'      => 'required|string|max:50',
            'nominal'            => 'required|integer|min:1',
            'metode_pembayaran'  => 'required|string', // Validasi baru
            'bukti_pembayaran'   => 'required|image|max:2048', // Saya ubah jadi required karena transfer manual butuh bukti
        ]);

        try {
            $userId = Auth::id();
            $siswa = Siswa::where('id_user', $userId)->first();

            if (!$siswa) {
                return back()->with('error', 'Data siswa tidak valid.');
            }

            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            PembayaranSiswa::create([
                'id_siswa'           => $siswa->id,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'nama_orangtua'      => $request->nama_orangtua,
                'nominal'            => $request->nominal,
                'metode_pembayaran'  => $request->metode_pembayaran, // Simpan metode
                'bukti_pembayaran'   => $buktiPath,
            ]);

            return redirect()->route('siswa.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi admin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }




    //Materi Pembelajaran
    public function indexMateri(Request $request)
    {
        $userId = Auth::id();
        $siswa = Siswa::where('id_user', $userId)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }


        $query = MateriPembelajaran::with(['guru', 'mapel'])
            ->where('id_siswa', $siswa->id);

        // LOGIKA PENCARIAN
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_materi', 'like', '%' . $request->search . '%');
        }

        $materis = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('siswa.siswa_daftarmateri', compact('materis'));
    }

    public function showMateri($id)
    {
        // Mengambil data materi beserta relasinya
        $materi = MateriPembelajaran::with(['guru', 'mapel'])->findOrFail($id);

        $userId = Auth::id();
        $siswa = Siswa::where('id_user', $userId)->first();

        // Validasi akses: Pastikan materi ini memang untuk siswa tersebut
        if ($materi->id_siswa != $siswa->id) {
            abort(403, 'Anda tidak memiliki akses ke materi ini.');
        }

        return view('siswa.siswa_materi', compact('materi'));
    }

    public function downloadMateri($id)
    {
        $materi = MateriPembelajaran::findOrFail($id);

        // Pastikan path sesuai dengan tempat Anda menyimpan file (biasanya di public/uploads atau storage)
        $filePath = public_path('uploads/materi/' . $materi->file_materi);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return back()->with('error', 'File tidak ditemukan.');
        }
    }


    // --- FITUR VIDEO MATERI ---
    public function videoMateri(Request $request)
    {
        // 1. Ambil ID User yang sedang login
        $userId = Auth::id();

        // 2. Cari data Siswa berdasarkan id_user (Relasi dari tabel Siswa)

        $siswa = Siswa::where('id_user', $userId)->first();

        // Cek validasi jika user login bukan siswa (misal admin iseng akses url ini)
        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        // 3. Ambil keyword pencarian jika ada
        $search = $request->input('search');

        // 4. Query data video KHUSUS untuk siswa yang login
        $videos = VideoMateri::query()
            // FILTER UTAMA: Hanya tampilkan video milik siswa ini
            ->where('id_siswa', $siswa->id)

            // Filter pencarian (jika user mengetik di search bar)
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_materi', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // 5. Return view
        return view('siswa.siswa_video', compact('videos', 'search'));
    }



    public function laporanPerkembangan()
    {
        // 1. Ambil ID User yang sedang login
        $userId = Auth::id();

        // 2. Cari data Siswa berdasarkan id_user
        $siswa = Siswa::where('id_user', $userId)->first();

        // Cek jika data siswa belum ada
        if (!$siswa) {
            abort(403, 'Data Siswa tidak ditemukan untuk akun ini.');
        }

        // 3. Ambil ID Siswa
        $idSiswa = $siswa->id;

        // 4. Ambil Data Laporan
        $laporan = LaporanPerkembanganSiswa::where('id_siswa', $idSiswa)
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        // 5. Hitung Rata-rata dari tabel TUGAS_SISWA
        // PERBAIKAN: Gunakan kolom 'nilai_tugas', bukan 'nilai_rata_rata'
        $average = TugasSiswa::where('id_siswa', $idSiswa)->avg('nilai_tugas');

        // Bulatkan nilai. Jika null, set ke 0
        $rata_rata = $average ? round($average) : 0;

        // 6. Return View
        // PERBAIKAN: compact harus menggunakan nama variabel yang sama ($rata_rata -> 'rata_rata')
        return view('siswa.siswa_laporanperkembangan', compact('siswa', 'laporan', 'rata_rata'));
    }
}
