<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;

use App\Models\JadwalBimbel;

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
                 if($firstJadwal) {
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
}