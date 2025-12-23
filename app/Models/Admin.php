<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
class admin extends Authenticatable
{
    // Tambahkan baris ini untuk memaksa Laravel menggunakan tabel 'admin'
    protected $table = 'admin'; 

    protected $fillable = [
        'id_user', 
        'username', 
        'nama', 
        'alamat'
    ];

    protected $hidden = [
        'password',
    ];
}
