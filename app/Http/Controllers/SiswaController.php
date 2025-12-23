<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;

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
        $jadwal = JadwalBimbel::with(['guru', 'siswa', 'mapel'])->get();
        return view('siswa.siswa_jadwalbimbel', compact('jadwal'));
    }



    // TAMPILKAN HALAMAN ABSENSI + FILTER
    public function absensi(Request $request)
    {
        // ... (kode absensi anda sudah benar, biarkan saja) ...
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Tips: Sebaiknya filter berdasarkan siswa yang login agar tidak melihat data orang lain
        // $userId = Auth::id(); 

        $data = AbsensiSiswa::when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal', $tahun))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.siswa_absensi', compact('data', 'bulan', 'tahun'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'hari'      => 'required',
            'tanggal'   => 'required|date',
            'waktu'     => 'required',
            'mapel'     => 'required',
            'kehadiran' => 'required',
            'bukti'     => 'nullable|image|max:2048', // Validasi file (opsional, max 2MB)
        ]);

        try {
            // 2. Handle Upload Bukti (Cek dulu apakah ada file)
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                // Simpan ke storage/app/public/bukti_absensi
                $buktiPath = $request->file('bukti')->store('bukti_absensi', 'public');
            }

            // 3. Cek Ketersediaan ID Jadwal Bimbel (PENTING!)
            // Karena di database kolom id_jadwal_bimbel TIDAK BOLEH NULL,
            // Kita harus pastikan ID 1 itu ada, atau gunakan trik ini.
            $idJadwal = 1; // Default dummy

            // Opsional: Cek apakah id 1 ada di tabel jadwal_bimbel, jika tidak ada, ambil id pertama yang ada
            if (!JadwalBimbel::find($idJadwal)) {
                // Jika ID 1 tidak ada, kita coba ambil sembarang ID yang ada agar tidak error Foreign Key
                $firstJadwal = JadwalBimbel::first();
                if ($firstJadwal) {
                    $idJadwal = $firstJadwal->id;
                } else {
                    // Jika tabel jadwal kosong sama sekali, ini akan error. 
                    // Solusi: Admin harus isi tabel jadwal_bimbel dulu minimal 1 data.
                    return redirect()->back()->with('error', 'Data Jadwal Bimbel kosong. Hubungi Admin.');
                }
            }

            // 4. Simpan Data
            AbsensiSiswa::create([
                'id_siswa' => 1, // Sebaiknya ganti Auth::id() atau id siswa yang sedang login
                'id_jadwal_bimbel' => $idJadwal,
                'kehadiran' => $request->kehadiran,
                'hari'      => $request->hari,
                'tanggal'   => $request->tanggal,
                'waktu'     => $request->waktu,
                'mapel'     => $request->mapel,
                'catatan'   => $request->catatan,
                'bukti'     => $buktiPath, // Masukkan path file atau null
            ]);

            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tampilkan error jika gagal (berguna untuk debugging)
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
                'tanggal_pembayaran'=> $request->tanggal_pembayaran,
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
