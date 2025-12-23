<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
    {
    use Notifiable;

        protected $fillable = [
            'name', 'username', 'password', 'role',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        // Helper functions untuk mempermudah pengecekan
        public function isAdmin() { return $this->role === 'admin'; }
        public function isGuru() { return $this->role === 'guru'; }
        public function isSiswa() { return $this->role === 'siswa'; }
    
        public function guru()
        {
            return $this->hasOne(Guru::class, 'id_user', 'id');
        }

        public function siswa()
        {
            return $this->hasOne(Siswa::class, 'id_user', 'id');
        }
    }
