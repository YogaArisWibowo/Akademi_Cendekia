<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\PembayaranSiswa;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Halaman Daftar Siswa (Sudah dibuat sebelumnya)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenjang = $request->input('jenjang');
        $kelas = $request->input('kelas');

        $query = Siswa::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }
        if ($jenjang) {
            $query->where('jenjang', $jenjang);
        }
        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        $siswa = $query->get();
        return view('admin.pembayaran_siswa', compact('siswa'));
    }

    // Halaman Detail Riwayat Pembayaran (Tugas Baru)
    public function detail($id)
    {
        // 1. Ambil data siswa yang dimaksud
        $siswa = Siswa::findOrFail($id);

        // 2. Ambil riwayat pembayaran berdasarkan model PembayaranSiswa
        // Menggunakan id_siswa sesuai kolom di model Boss
        $riwayat = PembayaranSiswa::where('id_siswa', $id)
                    ->orderBy('tanggal_pembayaran', 'desc')
                    ->paginate(10);

        return view('admin.detail_pembayaran_siswa', compact('siswa', 'riwayat'));
    }
}