<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoMateri extends Model
{
    protected $table = 'video_materi';

    protected $fillable = [
        'id_guru',
        'id_siswa',
        'id_mapel',
        'link_video',
        'jenis_kurikulum',
        'nama_materi'
    ];

    public function guru() {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function mapel() {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
