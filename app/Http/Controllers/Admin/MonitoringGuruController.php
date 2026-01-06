<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\AbsensiGuru;

class MonitoringGuruController extends Controller
{
    public function index()
    {
        // Ganti paginate() menjadi get()
        $gurus = Guru::latest()->get(); 

        return view('admin.Monitoring_Guru', compact('gurus'));
    }

    public function show($id)
    {
        // 1. Ambil data Guru
        $guru = Guru::findOrFail($id);

        // 2. Ambil SEMUA data Absensi (Ganti paginate ke get)
        $riwayat_absensi = AbsensiGuru::where('id_guru', $id)
                            ->latest()
                            ->get(); 

        // 3. Hitung total (Gunakan count() karena ini adalah Collection, bukan Paginator)
        $total_absensi = $riwayat_absensi->count();

        return view('admin.detail_monitoring_guru', compact('guru', 'riwayat_absensi', 'total_absensi'));
    }
}