<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    protected $table = 'absensi_siswa';
    protected $fillable = [
        'id_siswa',
        'id_jadwal_bimbel',
        'kehadiran',
        'hari',
        'tanggal',
        'waktu',
        'mapel',
        'catatan',
        'bukti',
    ];
}
