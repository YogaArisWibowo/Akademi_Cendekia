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
        'link_video',     // Di view nanti ini Link Youtube
        'jenis_kurikulum',
        'nama_materi'     // Di view nanti ini Judul/Ringkasan
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

    // --- TAMBAHAN: Helper untuk ambil ID Youtube ---
    public function getYoutubeIdAttribute()
    {
        $url = $this->link_video;
        if(empty($url)) return null;

        // Cek pola URL Youtube (Short & Long)
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return null; // Jika link bukan youtube valid
    }
}