<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\AbsensiGuru;
use App\Models\AbsensiSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Halaman Utama
    public function index(Request $request)
    {
        $data_guru = Guru::withCount('absensi_guru')->get();
        $data_siswa = Siswa::withCount('absensi_siswa')->get();
        return view('admin.absensi', compact('data_guru', 'data_siswa'));
    }

    // Detail Guru
    public function detailGuru(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $absensi = AbsensiGuru::where('id_guru', $id)
            ->when($request->bulan, fn($q) => $q->whereMonth('created_at', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('created_at', $request->tahun))
            ->latest()->paginate(10);

        return view('admin.detail_absensi_guru', compact('guru', 'absensi'));
    }

    // Detail Siswa
    public function detailSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $absensi = AbsensiSiswa::where('id_siswa', $id)
            ->when($request->bulan, fn($q) => $q->whereMonth('created_at', $request->bulan))
            ->when($request->tahun, fn($q) => $q->whereYear('created_at', $request->tahun))
            ->latest()->paginate(10);

        return view('admin.detail_absensi_siswa', compact('siswa', 'absensi'));
    }
}