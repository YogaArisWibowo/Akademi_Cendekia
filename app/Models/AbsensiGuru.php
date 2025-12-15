<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiGuru extends Model
{
    protected $table = 'absensi_guru';

    protected $fillable = [
        'id_guru',
        'id_jadwal_bimbel',
        'bukti_foto',
        'laporan_kegiatan',
        'hari',
        'tanggal',
        'mapel',
        'waktu'
    ];
}