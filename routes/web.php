<?php

use App\Http\Controllers\AbsensiGuruController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jadwalcontroller;
use App\Http\Controllers\Data_GuruDanSiswacontroller;
use App\Http\Controllers\Penerimaan_Siswacontroller;


Route::get('/', function () {
    return view('welcome');
});

//Route buat Admin
Route::get('/login_admin', function () {
    return view('admin.login');
});
Route::get('/admin/Pencatatan_Gaji_Guru', function () {
    return view('admin.Pencatatan_Gaji_Guru');
})->name('Pencatatan_Gaji_Guru');

Route::get('/admin/detail_pencatatan_gaji_guru', function () {
    return view('admin.detail_pencatatan_gaji_guru');
})->name('detail_pencatatan_gaji_guru');

Route::get('/admin/Absensi', function () {
    return view('admin.Absensi');
})->name('Absensi');

Route::get('/admin/detail_absensi_siswa', function () {
    return view('admin.detail_absensi_siswa');
})->name('detail_absensi_siswa');

Route::get('/admin/detail_absensi_guru', function () {
    return view('admin.detail_absensi_guru ');
})->name('detail_absensi_guru');

Route::get('/admin/Pembayaran_Siswa', function () {
    return view('admin.Pembayaran_Siswa ');
})->name('Pembayaran_Siswa');

Route::get('/admin/detail_pembayaran_siswa', function () {
    return view('admin.detail_pembayaran_siswa ');
})->name('detail_pembayaran_siswa');

Route::get('/admin/Materi_Pembelajaran', function () {
    return view('admin.Materi_Pembelajaran ');
})->name('Materi_Pembelajaran');

Route::get('/admin/detail_materi_pembelajaran', function () {
    return view('admin.detail_materi_pembelajaran');
})->name('detail_materi_pembelajaran');

Route::get('/admin/Video_Materi', function () {
    return view('admin.Video_Materi ');
})->name('Video_Materi');

Route::get('/admin/Monitoring_Guru', function () {
    return view('admin.Monitoring_Guru ');
})->name('Monitoring_Guru');

Route::get('/admin/detail_monitoring_guru', function () {
    return view('admin.detail_monitoring_guru ');
})->name('detail_monitoring_guru');

Route::get('/admin/Laporan_Perkembangan_Siswa', function () {
    return view('admin.Laporan_Perkembangan_Siswa ');
})->name('Laporan_Perkembangan_Siswa');

Route::get('/admin/detail_laporan_perkembangan_siswa', function () {
    return view('admin.detail_laporan_perkembangan_siswa ');
})->name('detail_laporan_perkembangan_siswa');

Route::get('/admin/jadwal_bimbel',[JadwalController::class, 'adminindex'])->name('Jadwal_Bimbel');

Route::get('/admin/Data_GurudanSiswa',[Data_GuruDanSiswacontroller::class, 'index'])->name('Data_GurudanSiswa');
Route::get('/admin/Penerimaan_Siswa',[Penerimaan_Siswacontroller::class, 'index'])->name('Penerimaan_Siswa');
//Route buat Guru
Route::get('/jadwal_mengajar', function () {
    return view('guru.jadwal_mengajar');
})->name('jadwal_mengajar');

Route::get('/jadwal_mengajar', [GuruController::class, 'jadwalMengajar'])->name('jadwal_mengajar');

Route::get('/absensi_guru', function () {
    return view('guru.absensi');
});


Route::post('/absensi/store', [GuruController::class, 'store'])->name('absensi.store');
Route::get('/absensi_guru', [GuruController::class, 'index'])->name('absensi_guru');






Route::get('/tugas_siswa', function () {
    return view('guru.tugas_siswa');
})->name('tugas_siswa');

Route::get('/detail_tugas_siswa', function () {
    return view('guru.detail_tugas_siswa');
})->name('detail_tugas_siswa');

Route::get('/gaji_guru', function () {
    return view('guru.gaji');
})->name('gaji_guru');

// Route::get('/materi_pembelajaran', function () {
//     return view('guru.materi_pembelajaran');
// })->name('materi_pembelajaran'); 

// Route::get('/detail_materi_pembelajaran', function () {
//     return view('guru.detail_materi_pembelajaran');
// })->name('detail_materi_pembelajaran');
// Route::get('/materi_pembelajaran', [GuruController::class, 'materiPembelajaran'])->name('materi_pembelajaran');


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