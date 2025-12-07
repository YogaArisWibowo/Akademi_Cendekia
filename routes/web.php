<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route buat Admin


//Route buat Guru
Route::get('/jadwal_mengajar', function () {
    return view('guru.jadwal_mengajar');
})->name('jadwal_mengajar');

Route::get('/absensi_guru', function () {
    return view('guru.absensi');
})->name('absensi_guru');
Route::get('/tugas_siswa', function () {
    return view('guru.tugas_siswa');
})->name('tugas_siswa');
Route::get('/gaji_guru', function () {
    return view('guru.gaji');
})->name('gaji_guru');
Route::get('/materi_pembelajaran', function () {
    return view('guru.materi_pembelajaran');
})->name('materi_pembelajaran');
Route::get('/video_materi_belajar', function () {
    return view('guru.video_materi_belajar');
})->name('video_materi_belajar');
Route::get('/laporan_pekembangan_siswa', function () {
    return view('guru.laporan_pekembangan_siswa');
})->name('laporan_pekembangan_siswa');


//Route buat Siswa
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