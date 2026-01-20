<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\AbsensiGuru;
use Carbon\Carbon;

class MonitoringGuruController extends Controller
{
    public function index()
    {
        // 1. Ambil data Guru dengan relasi 'absensi_guru'
        // withCount('absensi_guru') akan menghasilkan property 'absensi_guru_count'
        $gurus = Guru::with('absensi_guru')->withCount('absensi_guru')->get();

        // 2. Proses setiap guru
        $gurus->transform(function ($guru) {
            
            // Ambil data relasi menggunakan nama baru
            $dataAbsensi = $guru->getRelation('absensi_guru');

            // Ambil total dari withCount (namanya otomatis jadi absensi_guru_count)
            $guru->total_hadir = $guru->absensi_guru_count;

            // Hitung Rata-rata Jam Datang
            if ($guru->total_hadir > 0) {
                $avgSeconds = $dataAbsensi->map(function ($absen) {
                    return Carbon::parse($absen->created_at)->secondsSinceMidnight();
                })->avg();
                
                $guru->avg_seconds = $avgSeconds;
                $guru->rata_rata_str = gmdate('H:i', $avgSeconds);
            } else {
                $guru->avg_seconds = 999999; 
                $guru->rata_rata_str = '-';
            }

            return $guru;
        });

        // 3. LOGIKA RANKING "RAJIN"
        $rankRajinIds = $gurus->sortByDesc('total_hadir')
                            ->take(3)
                            ->pluck('id')
                            ->values()
                            ->all();

        // 4. LOGIKA RANKING "TERCEPAT"
        $rankCepatIds = $gurus->where('total_hadir', '>', 0)
                            ->sortBy('avg_seconds')
                            ->take(3)
                            ->pluck('id')
                            ->values()
                            ->all();

        // 5. Sorting Utama Tampilan
        $gurus = $gurus->sortByDesc('total_hadir')->values();

        return view('admin.Monitoring_Guru', compact('gurus', 'rankRajinIds', 'rankCepatIds'));
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        
        // Query manual ke model AbsensiGuru (Tidak terpengaruh nama relasi)
        $riwayat_absensi = AbsensiGuru::where('id_guru', $id)->latest()->get(); 
        $total_absensi = $riwayat_absensi->count();

        return view('admin.detail_monitoring_guru', compact('guru', 'riwayat_absensi', 'total_absensi'));
    }
}