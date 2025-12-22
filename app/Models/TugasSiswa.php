<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasSiswa extends Model
{
    protected $table = 'tugas_siswa';

    protected $fillable = [
        'id_guru',
        'id_siswa',
        'id_mapel',
        'id_jadwal_bimbel',
        'waktu_mulai',
        'waktu_selesai',
        'alamat_siswa',
        'nama_mapel',
        'penugasan',
        'jawaban_siswa',
        'nilai_tugas',
        'tanggal',
        'file',
    ];
}
