<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{

    protected $table = 'siswa'; // Nama tabel di database

    protected $fillable = [
        'id_user',
        'nama',
        'password',
        'jenjang',
        'no_hp',
        'alamat',
        'kelas',
        'asal_sekolah',
        'nama_orang_tua',
        'status_penerimaan' .
            'status_aktif'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function jadwal_bimbel()
    {
        // Siswa memiliki banyak jadwal bimbel
        return $this->hasMany(JadwalBimbel::class, 'id_siswa');
    }

    public function laporanPerkembangan()
    {
        return $this->hasMany(LaporanPerkembanganSiswa::class, 'id_siswa');
    }
}
