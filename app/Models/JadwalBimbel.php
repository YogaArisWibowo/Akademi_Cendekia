<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBimbel extends Model
{
    protected $table = 'jadwal_bimbel';

    protected $fillable = [
        'id_guru',
        'id_siswa',
        'id_mapel',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'nama_mapel',
        'alamat_siswa'
    ];

    // Relasi ke tabel guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    // Relasi ke tabel mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
