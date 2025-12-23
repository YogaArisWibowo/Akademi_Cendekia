<?php

namespace App\Models;

// WAJIB: Gunakan Authenticatable, bukan Model biasa agar bisa login
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Guru extends Authenticatable
{


    // Nama tabel di database Anda
    protected $table = 'guru';

    /**
     * Kolom yang dapat diisi melalui form register (Mass Assignment).
     * Pastikan semua name="" yang ada di Blade Register ada di sini.
     */
    protected $fillable = [
        'username',
        'password',
        'mapel',
        'alamat',
        'jenis_e_wallet', // Sesuaikan jika di DB menggunakan underscore (_)
        'no_e_wallet',
        'rekening',
        'pendidikan_terakhir',
        'is_approved', // Kolom untuk status ACC Admin
    ];

    /**
     * Kolom yang disembunyikan (tidak muncul saat data dipanggil)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'password' => 'hashed',    // Otomatis mengenali hash bcrypt
        'is_approved' => 'boolean', // Memastikan nilai 0/1 menjadi false/true
    ];
}