<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel'; // Nama tabel Anda

    protected $fillable = [
        'id_siswa', 
        'nama_mapel', 
        'jenis_kurikulum', 
        'kelas'
    ];

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}