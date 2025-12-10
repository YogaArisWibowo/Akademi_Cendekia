<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\AbsensiGuru;

class AbsensiGuruController extends Controller
{
    public function index()
{
    $absensi = AbsensiGuru::latest()->get();
    return view('guru.absensi', compact('absensi'));
}
    public function store(Request $request)
{
    $request->validate([
        'hari' => 'required',
        'tanggal' => 'required|date',
        'waktu' => 'required',
        'mapel' => 'required',
        'bukti_foto' => 'required|image|mimes:jpg,png,jpeg',
        'laporan_kegiatan' => 'required',
    ]);

    // Upload foto
    $foto = $request->file('bukti_foto');
    $namaFoto = time() . '_' . $foto->getClientOriginalName();
    $foto->move(public_path('uploads/absensi'), $namaFoto);

    AbsensiGuru::create([
        'id_guru' => auth()->user()->id, // sesuaikan
        'id_jadwal_bimbel' => 1, // sesuaikan
        'bukti_foto' => $namaFoto,
        'laporan_kegiatan' => $request->laporan_kegiatan,
        'hari' => $request->hari,
        'tanggal' => $request->tanggal,
        'waktu' => $request->waktu,
    ]);

    return redirect()->back()->with('success', 'Absensi berhasil ditambahkan');
}
}
