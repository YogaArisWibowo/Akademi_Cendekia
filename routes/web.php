<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Penerimaan_SiswaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\GajiGuruController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\MateriPembelajaranController;


Route::get('/', function () {
    return view('landingpages');
})->name('Landing_Page');

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('Login.post');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('Register.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'admin'])->group(function () {
    
    // Kelola User
    Route::get('/admin/admin_data-guru-siswa', [AdminController::class, 'dataPengguna'])->name('admin_Data_GurudanSiswa');
    Route::post('/admin/guru/store', [AdminController::class, 'storeGuru']);
    Route::put('/admin/guru/update/{id}', [AdminController::class, 'updateGuru']);
    Route::post('/admin/siswa/store', [AdminController::class, 'storeSiswa']);
    Route::put('/admin/siswa/update/{id}', [AdminController::class, 'updateSiswa']);
    Route::put('/admin/{role}/update-status/{id}', [AdminController::class, 'updateStatus']);

    // Mapel
    Route::get('/admin/Tambah_Mapel', [MapelController::class, 'index'])->name('admin_Tambah_Mapel');
    Route::post('/admin/Tambah_Mapel/store', [MapelController::class, 'store'])->name('mapel.store');

    // Gaji
    Route::get('/admin/admin_Pencatatan_Gaji_Guru', [GajiGuruController::class, 'index'])->name('admin_Pencatatan_Gaji_Guru');
    Route::get('/admin/admin_detail_pencatatan_gaji_guru/{id}', [GajiGuruController::class, 'show'])->name('admin_detail_pencatatan_gaji_guru');
    Route::put('/admin/admin_detail_pencatatan_gaji_guru/{id}', [GajiGuruController::class, 'update'])->name('admin_detail_pencatatan_gaji_guru.update');
    Route::post('/admin/admin_detail_pencatatan_gaji_guru/store', [GajiGuruController::class, 'store'])->name('admin_detail_pencatatan_gaji_guru.store');

    // Absensi & Pembayaran
    Route::get('/admin/absensi', [AbsensiController::class, 'index'])->name('admin_Absensi');
    Route::get('/admin/absensi/siswa/{id}', [AbsensiController::class, 'detailSiswa'])->name('admin_detail_absensi_siswa');
    Route::get('/admin/absensi/guru/{id}', [AbsensiController::class, 'detailGuru'])->name('admin_detail_absensi_guru');
    Route::get('/admin/pembayaran-siswa', [PembayaranController::class, 'index'])->name('admin_Pembayaran_Siswa');
    Route::get('/admin/pembayaran-siswa/detail/{id}', [PembayaranController::class, 'detail'])->name('admin_detail_pembayaran_siswa');

    // Materi & Video (View Only)
    Route::get('/admin/admin_materi-pembelajaran', [MateriPembelajaranController::class, 'index'])->name('admin_Materi_Pembelajaran');
    Route::post('/admin/admin_materi-pembelajaran/store', [MateriPembelajaranController::class, 'store'])->name('admin_Materi_Pembelajaran.store');
    Route::get('/admin/admin_detail_materi-pembelajaran/{id}', [MateriPembelajaranController::class, 'show'])->name('admin_detail_materi_pembelajaran');
    Route::put('/admin/admin_detail_materi-pembelajaran/{id}', [MateriPembelajaranController::class, 'update'])->name('admin_Materi_Pembelajaran.update');

    Route::get('/admin/admin_Video_Materi', function () { return view('admin.Video_Materi '); })->name('admin_Video_Materi');
    
    // Monitoring & Laporan
    Route::get('/admin/admin_Monitoring_Guru', function () { return view('admin.Monitoring_Guru '); })->name('admin_Monitoring_Guru');
    Route::get('/admin/admin_detail_monitoring_guru', function () { return view('admin.detail_monitoring_guru '); })->name('admin_detail_monitoring_guru');
    Route::get('/admin/admin_Laporan_Perkembangan_Siswa', function () { return view('admin.Laporan_Perkembangan_Siswa '); })->name('admin_Laporan_Perkembangan_Siswa');
    Route::get('/admin/admin_detail_laporan_perkembangan_siswa', function () { return view('admin.detail_laporan_perkembangan_siswa '); })->name('admin_detail_laporan_perkembangan_siswa');

    // Jadwal Bimbel
    Route::get('/admin/admin_jadwal_bimbel', [JadwalController::class, 'index'])->name('admin_Jadwal_Bimbel');
    Route::post('/admin/admin_jadwal_bimbel/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::put('/admin/admin_jadwal_bimbel/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/delete/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    
    // Penerimaan Siswa
    Route::get('/admin/admin_Penerimaan_Siswa', [Penerimaan_SiswaController::class, 'index'])->name('admin_Penerimaan_Siswa');
    Route::post('/admin/update-status-siswa/{id}', [Penerimaan_SiswaController::class, 'updateStatusSiswa'])->name('update.status.siswa');
});

Route::middleware(['auth', 'guru'])->group(function () {
    
    Route::get('/jadwal_mengajar', [GuruController::class, 'jadwalMengajar'])->name('jadwal_mengajar');
    Route::get('/gaji_guru', function () { return view('guru.gaji'); })->name('gaji_guru');

    // Absensi
    Route::get('/absensi_guru', [GuruController::class, 'index'])->name('absensi_guru');
    Route::post('/absensi/store', [GuruController::class, 'store'])->name('absensi.store');

    // Tugas
    Route::get('/tugas_siswa', [GuruController::class, 'indexTugas'])->name('tugas_siswa');
    Route::get('/tugas_siswa/{id}', [GuruController::class, 'detailTugasSiswa'])->name('detail_tugas_siswa');
    Route::post('/tugas_siswa/simpan', [GuruController::class, 'simpanTugas'])->name('tugas_siswa.simpan');
    Route::get('/tugas_siswa/{id}/detail/{tugas_id}', [GuruController::class, 'detailTugasPerSiswa'])->name('detail_tugas_persiswa');
    Route::put('/tugas_siswa/update/{id}', [GuruController::class, 'updateTugas'])->name('tugas_siswa.update');

    // Materi
    Route::get('/materi_pembelajaran', [GuruController::class, 'indexMateri'])->name('materi_pembelajaran');
    Route::get('/materi_pembelajaran/{id}', [GuruController::class, 'materiPembelajaran'])->name('detail_materi_pembelajaran');
    Route::post('/materi_pembelajaran/store', [GuruController::class, 'storeMateri'])->name('store_materi');
    Route::put('/materi_pembelajaran/update/{id}', [GuruController::class, 'updateMateri'])->name('update_materi');
    Route::get('/materi_pembelajaran/download/{id}', [GuruController::class, 'downloadMateri'])->name('download_materi');

    // Video
    Route::get('/video_materi_belajar', [GuruController::class, 'indexVideoMateri'])->name('video_materi_belajar');
    Route::post('/video_materi_belajar/store', [GuruController::class, 'storeVideoMateri'])->name('store_video_materi');
    Route::post('/video_materi_belajar/update/{id}', [GuruController::class, 'updateVideoMateri'])->name('update_video_materi');

    // Laporan Perkembangan (Saya hapus versi 'function' karena redundant)
    Route::get('/laporan_perkembangan_siswa', [GuruController::class, 'laporanPerkembangan'])->name('laporan_perkembangan_siswa');
    Route::get('/detail_laporan_perkembangan_siswa/{id}', [GuruController::class, 'detailLaporanPerkembangan'])->name('detail_laporan_perkembangan_siswa');
    Route::post('/laporan_perkembangan_siswa/tambah', [GuruController::class, 'tambahLaporan'])->name('laporan_perkembangan_siswa.tambah');
    Route::put('/laporan_perkembangan_siswa/update/{id}', [GuruController::class, 'updateLaporan'])->name('laporan_perkembangan_siswa.update');
});

Route::middleware(['auth', 'siswa'])->group(function () {
    
    // Jadwal
    Route::get('/jadwal_siswa', [SiswaController::class, 'jadwal'])->name('jadwalbimbel');

    // Absensi
    Route::get('/siswa_absensi', [SiswaController::class, 'absensi'])->name('absensi.index');
    Route::post('/siswa_absensi/store', [SiswaController::class, 'store'])->name('siswa.absensi.store');

    // Tugas (Saya hapus versi 'function view' agar pakai controller)
    Route::get('/siswa_daftartugas', [SiswaController::class, 'indexTugas'])->name('siswa.siswa_daftartugas');
    Route::get('/siswa/siswa_tugas/{id}', [SiswaController::class, 'showTugas'])->name('siswa.tugas.show');
    Route::post('/siswa/siswa_tugas/{id}/upload', [SiswaController::class, 'uploadTugas'])->name('siswa.tugas.upload');

    // Pembayaran
    Route::get('/siswa_pembayaran', [SiswaController::class, 'pencatatanPembayaran'])->name('siswa.pembayaran.index');
    Route::post('/siswa/pembayaran', [SiswaController::class, 'storePembayaran'])->name('siswa.pembayaran.store');

    // Materi
    Route::get('/siswa/materi', [SiswaController::class, 'indexMateri'])->name('siswa.siswa_daftarmateri');
    Route::get('/siswa/materi/{id}', [SiswaController::class, 'showMateri'])->name('siswa.materi.detail');
    Route::get('/siswa/materi/download/{id}', [SiswaController::class, 'downloadMateri'])->name('download_materi');

    // Video & Laporan
    Route::get('/siswa_videomateri', [SiswaController::class, 'videoMateri'])->name('siswa.video');
    Route::get('/siswa_laporanperkembangan', [SiswaController::class, 'laporanPerkembangan'])->name('siswa.laporan');
});