<?php

// app/Models/MateriPembelajaran.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriPembelajaran extends Model
{
    protected $table = 'materi_pembelajaran';

    protected $fillable = [
        'id_guru',
        'id_siswa',
        'id_mapel',
        'materi',
        'jenis_kurikulum',
        'nama_materi',
        'file_materi',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
