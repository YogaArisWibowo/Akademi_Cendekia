<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Data_GuruDanSiswacontroller extends Controller
{
    Public Function index(){
        
        // Definisikan status default di Controller
        $status_awal_default = 'aktif';

        // Data Dummy DENGAN ID UNIK (Penting untuk Dropdown)
        $data_list = collect([
            (object)[
                'id' => 1, // ID UNIK DITAMBAHKAN
                'nama' => 'Yoga',
                'jenjang' => 'SMP',
                'kelas' => '7',
                'mapel' => 'IPAS',
                'asal_sekolah' => 'SMP N 5 Ngawi',
                'no_hp' => '0823xxxxx',
                'status' => 'aktif',
            ],
            (object)[
                'id' => 2, // ID UNIK DITAMBAHKAN
                'nama' => 'Budi',
                'jenjang' => 'SMA',
                'kelas' => '10',
                'mapel' => 'Kimia',
                'asal_sekolah' => 'SMA N 1 Ngawi',
                'no_hp' => '0821xxxxx',
                'status' => 'non aktif', // Contoh status non aktif
            ],
            (object)[
                'id' => 3, // ID UNIK DITAMBAHKAN
                'nama' => 'Siti',
                'jenjang' => 'SD',
                'kelas' => '6',
                'mapel' => 'Matematika',
                'asal_sekolah' => 'SD N 3 Ngawi',
                'no_hp' => '0857xxxxx',
                'status' => 'aktif',
            ],
        ]);

        return view('admin.Data_GurudanSiswa', [
            'jadwal' => $data_list,
            'siswa_list' => $data_list, // Menggunakan data yang sama untuk siswa
            'status_awal' => $status_awal_default, // Mengirimkan status default
        ]);

    }
}