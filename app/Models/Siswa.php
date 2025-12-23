<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{

    protected $table = 'siswa'; // Nama tabel di database

    protected $fillable = [
        'username', 
        'password', 
        'jenjang', 
        'no_hp', 
        'alamat', 
        'kelas', 
        'asal_sekolah', 
        'nama_orang_tua', 
        'is_approved'
    ];

}
