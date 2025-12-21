<?php

use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jadwalcontroller;
use App\Http\Controllers\Data_GuruDanSiswacontroller;
use App\Http\Controllers\Penerimaan_Siswacontroller;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return view('landingpages');
});

//Route buat Admin
Route::get('/login_admin', function () {
    return view('admin.login');
});
Route::get('/admin/Pencatatan_Gaji_Guru', function () {
    return view('admin.Pencatatan_Gaji_Guru');
});
Route::get('/admin/jadwal_bimbel', [JadwalController::class, 'adminindex']);

Route::get('/admin/Data_GurudanSiswa', [Data_GuruDanSiswacontroller::class, 'index']);
Route::get('/admin/Penerimaan_Siswa', [Penerimaan_Siswacontroller::class, 'index']);


//Route buat Guru
// list halaman jadwal mengajar
Route::get('/jadwal_mengajar', [GuruController::class, 'jadwalMengajar'])->name('jadwal_mengajar');

//store absensi
Route::post('/absensi/store', [GuruController::class, 'store'])->name('absensi.store');
//halaman list absensi
Route::get('/absensi_guru', [GuruController::class, 'index'])->name('absensi_guru');






Route::get('/tugas_siswa', [GuruController::class, 'indexTugas'])->name('tugas_siswa');


Route::get('/tugas_siswa/{id}', [GuruController::class, 'detailTugasSiswa'])->name('detail_tugas_siswa');

Route::post('/tugas_siswa/simpan', [GuruController::class, 'simpanTugas'])->name('tugas_siswa.simpan');

Route::get('/tugas_siswa/{id}/detail/{tugas_id}', [GuruController::class, 'detailTugasPerSiswa'])->name('detail_tugas_persiswa');
Route::put('/tugas_siswa/update/{id}', [GuruController::class, 'updateTugas'])->name('tugas_siswa.update');






Route::get('/gaji_guru', function () {
    return view('guru.gaji');
})->name('gaji_guru');



// Halaman list materi
Route::get('/materi_pembelajaran', [GuruController::class, 'indexMateri'])
    ->name('materi_pembelajaran');

// Detail materi
Route::get('/materi_pembelajaran/{id}', [GuruController::class, 'materiPembelajaran'])
    ->name('detail_materi_pembelajaran');

// Store materi
Route::post('/materi_pembelajaran/store', [GuruController::class, 'storeMateri'])
    ->name('store_materi');

// Update materi
Route::put('/materi_pembelajaran/update/{id}', [GuruController::class, 'updateMateri'])
    ->name('update_materi');

// Halaman list vidio
Route::get('/video_materi_belajar', [GuruController::class, 'indexVideoMateri'])->name('video_materi_belajar');
//store vidio
Route::post('/video_materi_belajar/store', [GuruController::class, 'storeVideoMateri'])->name('store_video_materi');
// update vidio
Route::post('/video_materi_belajar/update/{id}', [GuruController::class, 'updateVideoMateri'])->name('update_video_materi');





Route::get('/laporan_perkembangan_siswa', function () {
    return view('guru.laporan_pekembangan_siswa');
})->name('laporan_perkembangan_siswa');



Route::get('/laporan_perkembangan_siswa', [GuruController::class, 'laporanPerkembangan'])->name('laporan_perkembangan_siswa');
Route::get('/detail_laporan_perkembangan_siswa/{id}', [GuruController::class, 'detailLaporanPerkembangan'])->name('detail_laporan_perkembangan_siswa');
Route::post('/laporan_perkembangan_siswa/tambah', [GuruController::class, 'tambahLaporan'])->name('laporan_perkembangan_siswa.tambah');
Route::put('/laporan_perkembangan_siswa/update/{id}', [GuruController::class, 'updateLaporan'])->name('laporan_perkembangan_siswa.update');






//Route buat Siswa
// Route::get('/siswa/siswa_jadwalbimbel', [JadwalController::class, 'siswaindex']);


// Route::get('/jadwal_siswa', [SiswaController::class, 'jadwal']);
Route::get('/jadwal_siswa', [SiswaController::class, 'jadwal'])->name('jadwalbimbel');



// Halaman absensi siswa
Route::get('/siswa_absensi', [SiswaController::class, 'absensi'])->name('absensi.index');

// Simpan absensi
Route::post('/siswa_absensi/store', [SiswaController::class, 'store'])->name('siswa.absensi.store');






Route::get('/siswa/siswa_daftartugas', function () {
    return view('siswa.siswa_daftartugas');
});

Route::get('/siswa/siswa_tugas', function () {
    return view('siswa.siswa_tugas');
});





Route::get('/siswa/siswa_pencatatanpembayaran', function () {
    return view('siswa.siswa_pencatatanpembayaran');
});




// Route untuk Pembayaran
Route::get('/siswa_pembayaran', [SiswaController::class, 'pencatatanPembayaran'])
    ->name('siswa.pembayaran.index');

Route::post('/siswa/pembayaran', [SiswaController::class, 'storePembayaran'])
    ->name('siswa.pembayaran.store');








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
