<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiGuru extends Model
{
    protected $table = 'gaji_guru';

    protected $fillable = [
        'id_guru',
        'id_absensi_guru', // Digunakan untuk Jumlah Absensi
        'gaji_per_jam',    // Pindahan dari tabel guru
        'nominal_gaji',    // Ini akan menyimpan Total Gaji
        'kehadiran'
    ];


    // Relasi ke Table Guru (untuk ambil Nama, Jenjang, Rekening)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    // Relasi ke Table AbsensiGuru (untuk ambil Tanggal & Waktu mengajar)
    public function absensi()
    {
        return $this->belongsTo(AbsensiGuru::class, 'id_absensi_guru');
    }
}