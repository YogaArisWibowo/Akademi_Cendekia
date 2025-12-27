<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AbsensiSiswa;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalBimbel;
use App\Models\LaporanPerkembanganSiswa;
use App\Models\PembayaranSiswa;
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

    // --- FITUR PEMBAYARAN ---

    // $idSiswa = 1; // Ganti dengan Auth::id();
    // 1. Tampilkan List Pembayaran (Menggantikan view statis kamu)
    public function pencatatanPembayaran(Request $request)
    {
        // Ambil id siswa yang login (sesuaikan guard kamu). Jika belum ada Auth untuk siswa,
        // sementara pakai id 1, tapi disarankan pakai Auth::id().
        $idSiswa = 1;

        // Paginate untuk sinkron dengan UI (misal 10 per halaman)
        $pembayaran = PembayaranSiswa::with('siswa')
            ->where('id_siswa', $idSiswa)
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
            'bukti_pembayaran'   => 'nullable|image|max:2048',
        ]);

        try {
            $idSiswa = 1;

            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            PembayaranSiswa::create([
                'id_siswa'          => $idSiswa,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'nama_orangtua'     => $request->nama_orangtua,
                'nominal'           => $request->nominal,
                'bukti_pembayaran'  => $buktiPath,
            ]);

            return redirect()->route('siswa.pembayaran.index')
                ->with('success', 'Pembayaran berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }


    // --- FITUR VIDEO MATERI ---
    public function videoMateri(Request $request)
    {
        // 1. Ambil keyword pencarian jika ada
        $search = $request->input('search');

        // 2. Query data video
        $videos = VideoMateri::query()
            // Filter pencarian berdasarkan nama materi
            ->when($search, function ($query) use ($search) {
                return $query->where('nama_materi', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
            ->paginate(6); // Tampilkan 6 video per halaman agar rapi di grid

        // 3. Return view
        return view('siswa.siswa_video', compact('videos', 'search'));
    }



    public function laporanPerkembangan()
    {
        // ID Siswa Dummy (Ganti Auth::id() jika sudah pakai login)
        $idSiswa = 1;

        // 1. Ambil Data Laporan (Paginate 5 atau 10 baris)
        $laporan = LaporanPerkembanganSiswa::where('id_siswa', $idSiswa)
            ->orderBy('tanggal', 'desc')
            ->paginate(5);
        $rataRata = LaporanPerkembanganSiswa::where('id_siswa', $idSiswa)->avg('nilai_rata_rata');

        // Jika datanya kosong, set 0 agar tidak error
        $rataRata = $rataRata ? round($rataRata) : 0;

        return view('siswa.siswa_laporanperkembangan', compact('laporan', 'rataRata'));
    }
}
