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
}