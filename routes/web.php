<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jadwalcontroller;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/jadwal_mengajar', function () {
    return view('guru.jadwal_mengajar');
});
Route::get('/login', function () {
    return view('admin.login');
});
Route::get('/Jadwal_Bimbel', [Jadwalcontroller::class, 'index']);

Route::get('/siswa/jadwal_bimbel', function () {

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