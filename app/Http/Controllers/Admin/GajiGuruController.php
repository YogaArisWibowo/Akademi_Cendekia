<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Guru;
use App\Models\GajiGuru;
use App\Models\AbsensiGuru;
use Illuminate\Http\Request;

class GajiGuruController extends Controller
{
    // Tambahkan method index agar tidak error 'Undefined method'
    public function index()
    {
        $guru = Guru::all();
        return view('admin.Pencatatan_Gaji_Guru', compact('guru'));
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        
        // Menghitung total kehadiran guru tersebut dari tabel absensi
        $jumlah_absensi = AbsensiGuru::where('id_guru', $id)->count();

        // Mengambil data transaksi gaji paling terakhir
        $gaji_guru = GajiGuru::where('id_guru', $id)->latest()->first();

        // LOGIKA PERBAIKAN: 
        // Agar total gaji sinkron (Gaji Perjam x Absensi), kita ambil dari nominal_gaji terakhir
        // bukan menggunakan sum() yang mengakumulasi data lama.
        $totalGaji = $gaji_guru ? $gaji_guru->nominal_gaji : 0;

        return view('admin.detail_pencatatan_gaji_guru', compact('guru', 'gaji_guru', 'totalGaji', 'jumlah_absensi'));
    }

    public function store(Request $request)
    {
        $jumlah_absensi = AbsensiGuru::where('id_guru', $request->id_guru)->count();
        
        // Kalkulasi nominal gaji baru
        $nominal_gaji = $request->gaji_per_jam * $jumlah_absensi;

        GajiGuru::create([
            'id_guru' => $request->id_guru,
            'id_absensi_guru' => 1, // Berikan default ID yang ada di tabel absensi agar tidak error FK
            'gaji_per_jam' => $request->gaji_per_jam,
            'nominal_gaji' => $nominal_gaji,
            'kehadiran' => $request->kehadiran,
        ]);

        return redirect()->back()->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $gaji = GajiGuru::findOrFail($id);
        $jumlah_absensi = AbsensiGuru::where('id_guru', $gaji->id_guru)->count();
        
        // Hitung ulang nominal saat edit agar sinkron
        $nominal_baru = $request->gaji_per_jam * $jumlah_absensi;

        $gaji->update([
            'gaji_per_jam' => $request->gaji_per_jam,
            'nominal_gaji' => $nominal_baru,
            'kehadiran' => $request->kehadiran,
        ]);

        return redirect()->back()->with('success', 'Data gaji berhasil diperbarui.');
    }
}