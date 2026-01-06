<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerkembanganSiswa;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\TugasSiswa;

class LaporanPerkembanganController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query
        $query = Siswa::latest();

        // 2. Cek Filter Jenjang
        if ($request->has('jenjang') && $request->jenjang != null) {
            $query->where('jenjang', $request->jenjang);
        }

        // 3. Ambil data (pakai get() karena pagination dihandle JS)
        $siswas = $query->get();

        // 4. Kirim ke view
        return view('admin.Laporan_Perkembangan_Siswa', compact('siswas'));
    }

    public function show($id)
    {
        // 1. Ambil data Siswa
        $siswas = Siswa::findOrFail($id);

        // 2. Ambil Laporan
        $laporans = LaporanPerkembanganSiswa::where('id_siswa', $id)
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('waktu', 'desc')
                    ->paginate(10);

        // 3. Hitung Rata-rata Nilai (PERBAIKAN DI SINI)
        // Jangan ambil dari LaporanPerkembanganSiswa, tapi ambil dari TugasSiswa
        // Agar menampilkan rata-rata Real-time seluruh mapel
        
        $nilai = TugasSiswa::where('id_siswa', $id)->avg('nilai_tugas');
        
        // Jika data kosong, set 0
        $nilai = $nilai ? round($nilai) : 0;

        return view('admin.detail_laporan_perkembangan_siswa', compact('siswas', 'laporans', 'nilai'));
    }

    // Fungsi tambahan untuk download (jika tombol unduh difungsikan nanti)
    public function download($id)
    {
        // Logika export PDF bisa ditambahkan di sini
    }
}