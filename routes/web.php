<?php

use App\Http\Controllers\AbsensiGuruController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jadwalcontroller;

Route::get('/', function () {
    return view('welcome');
});

//Route buat Admin
Route::get('/login_admin', function () {
    return view('admin.login');
});
Route::get('/admin/jadwal_bimbel',[JadwalController::class, 'adminindex']);
//Route buat Guru
Route::get('/jadwal_mengajar', function () {
    return view('guru.jadwal_mengajar');
})->name('jadwal_mengajar');

Route::get('/absensi_guru', function () {
    return view('guru.absensi');
})->name('absensi_guru');
Route::post('/absensi/store', [AbsensiGuruController::class, 'store'])->name('absensi.store');
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
Route::get('/siswa/siswa_jadwalbimbel',[JadwalController::class, 'siswaindex']);

Route::get('/siswa/siswa_absensi', function () {
    return view('siswa.siswa_absensi', [
        'title' => 'Absensi'
    ]);
});

Route::get('/siswa/siswa_daftartugas', function () {
    return view('siswa.siswa_daftartugas');
});

Route::get('/siswa/siswa_tugas', function () {
    return view('siswa.siswa_tugas');
});

Route::get('/siswa/siswa_pencatatanpembayaran', function () {
    return view('siswa.siswa_pencatatanpembayaran');
});

Route::get('/siswa/siswa_laporanperkembangan', function () {
    return view('siswa.siswa_laporanperkembangan');
});

Route::get('/siswa/siswa_daftarmateri', function () {
    return view('siswa.siswa_daftarmateri');
});

Route::get('/siswa/siswa_materi', function () {
    return view('siswa.siswa_materi');
});

Route::get('/siswa/siswa_video', function () {
    return view('siswa.siswa_video');
});