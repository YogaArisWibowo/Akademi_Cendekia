<?php

namespace App\Http\Controllers;

use App\Models\AbsensiGuru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $data = AbsensiGuru::when($bulan, function ($q) use ($bulan) {
            return $q->whereMonth('tanggal', $bulan);
        })
            ->when($tahun, function ($q) use ($tahun) {
                return $q->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.absensi', compact('data', 'bulan', 'tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'mapel' => 'required',
            'bukti' => 'required|mimes:jpg,jpeg',
            'catatan' => 'nullable'
        ]);

        // Simpan file bukti foto
        $file = $request->file('bukti');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti_absensi'), $namaFile);

        AbsensiGuru::create([
            'id_guru' => 1,
            'id_jadwal_bimbel' => 1,
            'mapel' => $request->mapel, // INI WAJIB ADA
            'bukti_foto' => $namaFile,
            'laporan_kegiatan' => $request->catatan,
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
        ]);

        return redirect()->route('absensi_guru')->with('success', 'Absensi berhasil ditambahkan');
    }
}
