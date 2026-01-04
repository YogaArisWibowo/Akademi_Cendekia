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
        'status_penerimaan'.
        'status_aktif'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }   
    
    public function absensi_siswa() 
    {
        return $this->hasMany(AbsensiSiswa::class, 'id_siswa');
    }
}
