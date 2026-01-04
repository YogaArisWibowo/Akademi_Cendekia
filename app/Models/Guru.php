<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Authenticatable
{
    use HasFactory;

    protected $table = 'guru';

     protected $fillable = [
        'id_user',
        'nama',
        'password',
        'mapel',
        'no_hp',
        'alamat_guru',
        'jenis_e_wallet', // Sesuaikan jika di DB menggunakan underscore (_)
        'no_e_wallet',
        'rekening',
        'pendidikan_terakhir',
        'status_aktif'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    
}