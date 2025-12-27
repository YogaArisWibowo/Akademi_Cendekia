<?php

use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jadwalcontroller;
use App\Http\Controllers\Data_GuruDanSiswacontroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Penerimaan_Siswacontroller;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Logincontroller;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('landingpages');
})->name('Landing_Page');

//Route buat Admin
Route::get('/login', function () {
    return view('/login');
})->name('Login');

Route::post('/login', [Logincontroller::class, 'authenticate'])->name('Login.post');

Route::get('/register', function () {
    return view('register');
})->name('register');




Route::post('/register', [RegisterController::class, 'store'])->name('Register.post');

Route::middleware(['auth', 'admin'])->group(function () {
    // Halaman Utama Data Guru & Siswa
    Route::get('/admin/admin_Data_GurudanSiswa', [AdminController::class, 'dataPengguna'])->name('admin_Data_GurudanSiswa');
    Route::post('/admin/store-guru', [AdminController::class, 'storeGuru'])->name('guru.store');
    Route::put('/admin/guru/update-status/{id}', [AdminController::class, 'updateGuru'])->name('guru.update');
    Route::post('/admin/store-siswa', [AdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::put('/admin/siswa/update-status/{id}', [AdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::post('/admin/update-status/{role}/{id}', [AdminController::class, 'updateStatus']);
    
    Route::get('/admin/admin_Pencatatan_Gaji_Guru', function () {
    return view('admin.Pencatatan_Gaji_Guru');
    })->name('admin_Pencatatan_Gaji_Guru');

    Route::get('/admin/admin_detail_pencatatan_gaji_guru', function () {
        return view('admin.detail_pencatatan_gaji_guru');
    })->name('admin_detail_pencatatan_gaji_guru');

    Route::get('/admin/admin_Absensi', function () {
        return view('admin.Absensi');
    })->name('admin_Absensi');

    Route::get('/admin/admin_detail_absensi_siswa', function () {
        return view('admin.detail_absensi_siswa');
    })->name('admin_detail_absensi_siswa');

    Route::get('/admin/admin_detail_absensi_guru', function () {
        return view('admin.detail_absensi_guru ');
    })->name('admin_detail_absensi_guru');

    Route::get('/admin/admin_Pembayaran_Siswa', function () {
        return view('admin.Pembayaran_Siswa ');
    })->name('admin_Pembayaran_Siswa');

    Route::get('/admin/admin_detail_pembayaran_siswa', function () {
        return view('admin.detail_pembayaran_siswa ');
    })->name('admin_detail_pembayaran_siswa');

    Route::get('/admin/admin_Materi_Pembelajaran', function () {
        return view('admin.Materi_Pembelajaran ');
    })->name('admin_Materi_Pembelajaran');

    Route::get('/admin/admin_detail_materi_pembelajaran', function () {
        return view('admin.detail_materi_pembelajaran');
    })->name('admin_detail_materi_pembelajaran');

    Route::get('/admin/admin_Video_Materi', function () {
        return view('admin.Video_Materi ');
    })->name('admin_Video_Materi');

    Route::get('/admin/admin_Monitoring_Guru', function () {
        return view('admin.Monitoring_Guru ');
    })->name('admin_Monitoring_Guru');

    Route::get('/admin/admin_detail_monitoring_guru', function () {
        return view('admin.detail_monitoring_guru ');
    })->name('admin_detail_monitoring_guru');

    Route::get('/admin/admin_Laporan_Perkembangan_Siswa', function () {
        return view('admin.Laporan_Perkembangan_Siswa ');
    })->name('admin_Laporan_Perkembangan_Siswa');

    Route::get('/admin/admin_detail_laporan_perkembangan_siswa', function () {
        return view('admin.detail_laporan_perkembangan_siswa ');
    })->name('admin_detail_laporan_perkembangan_siswa');

    Route::get('/admin/admin_jadwal_bimbel', [JadwalController::class, 'index'])->name('admin_Jadwal_Bimbel');
    Route::post('/admin/admin_jadwal_bimbel/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/admin/admin_jadwal_bimbel/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/delete/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/admin/admin_Penerimaan_Siswa', [Penerimaan_Siswacontroller::class, 'index'])->name('admin_Penerimaan_Siswa');
    Route::post('/admin/update-status-siswa/{id}', [Penerimaan_Siswacontroller::class, 'updateStatusSiswa'])->name('update.status.siswa');
});







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

Route::get('/siswa_videomateri', [SiswaController::class, 'videoMateri'])->name('siswa.video');



Route::get('/siswa_laporanperkembangan', [SiswaController::class, 'laporanPerkembangan'])->name('siswa.laporan');