<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/jadwal_mengajar', function () {
    return view('guru.jadwal_mengajar');
});

Route::get('/siswa/jadwal_bimbel', function () {

    // Dummy data biar tabelnya tampil seperti contoh
    $jadwal = collect([
        (object)[
            'hari' => 'Senin',
            'tanggal' => '05-Okt-2025',
            'waktu' => '15.00',
            'mapel' => 'IPAS',
            'guru' => 'Ira Sulistya',
            'nama_siswa' => 'Hafidz',
            'alamat_siswa' => 'Jl. Kenari',
        ],
        (object)[
            'hari' => 'Senin',
            'tanggal' => '05-Okt-2025',
            'waktu' => '15.00',
            'mapel' => 'IPAS',
            'guru' => 'Ira Sulistya',
            'nama_siswa' => 'Hafidz',
            'alamat_siswa' => 'Jl. Kenari',
        ],
        (object)[
            'hari' => 'Senin',
            'tanggal' => '05-Okt-2025',
            'waktu' => '15.00',
            'mapel' => 'IPAS',
            'guru' => 'Ira Sulistya',
            'nama_siswa' => 'Hafidz',
            'alamat_siswa' => 'Jl. Kenari',
        ],
    ]);

    return view('siswa.jadwal_bimbel', compact('jadwal'));
});

Route::get('/siswa/absensi', function () {
    return view('siswa.absensi', [
        'title' => 'Absensi'
    ]);
});

Route::get('/siswa/daftar_tugas', function () {
    return view('siswa.daftar_tugas');
});

Route::get('/siswa/tugas_siswa', function () {
    return view('siswa.tugas_siswa');
});

Route::get('/siswa/pencatatanpembayaran', function () {
    return view('siswa.pencatatanpembayaran');
});

Route::get('/siswa/laporanperkembangan', function () {
    return view('siswa.laporanperkembangan');
});