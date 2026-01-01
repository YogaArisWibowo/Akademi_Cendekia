<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPerkembanganSiswa extends Model
{
    protected $table = 'laporan_perkembangan_siswa';

    protected $fillable = [
        'id_siswa',
        'id_jadwal_bimbel',
        'hari',          // Baru
        'tanggal',       // Baru
        'waktu',         // Baru
        'mapel',         // Baru
        'laporan_perkembangan', // Ini akan kita pakai untuk 'Catatan'
        
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
