<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranSiswa extends Model
{
    protected $table = 'pembayaran_siswa';

    protected $fillable = [
        'id_siswa',
        'tanggal_pembayaran',
        'nama_orangtua',
        'nominal',
        'bukti_pembayaran',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}

