<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBimbel extends Model
{
    protected $table = 'jadwal_bimbel';

    protected $fillable = [
        'id_siswa',
        'id_guru',
        'id_mapel',
        'created_at',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'nama_mapel',
        'alamat_siswa'
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
