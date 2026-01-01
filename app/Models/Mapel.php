<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';

    public function jadwal_bimbel()
    {
        // Mapel memiliki banyak jadwal bimbel
        return $this->hasMany(JadwalBimbel::class, 'id_mapel');
    }
}
