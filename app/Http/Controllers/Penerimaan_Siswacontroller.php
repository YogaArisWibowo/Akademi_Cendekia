<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Penerimaan_Siswacontroller extends Controller
{
    Public Function index(){
        
        // Definisikan status default di Controller
        $status_awal_default = 'aktif';

        // Data Dummy DENGAN ID UNIK (Penting untuk Dropdown)
        $data_list = collect([
            (object)[
                'id' => 3, // ID UNIK DITAMBAHKAN
                'nama' => 'Siti',
                'jenjang' => 'SD',
                'kelas' => '6',
                'asal_sekolah' => 'SD N 3 Ngawi',
                'no_hp' => '0857xxxxx',
                'alamat_siswa' => 'Klaten Utara',
                'status' => 'aktif',
            ],
            (object)[
                'id' => 3, // ID UNIK DITAMBAHKAN
                'nama' => 'Siti',
                'jenjang' => 'SD',
                'kelas' => '6',
                'asal_sekolah' => 'SD N 3 Ngawi',
                'no_hp' => '0857xxxxx',
                'alamat_siswa' => 'Klaten Utara',
                'status' => 'aktif',
            ],
            (object)[
                'id' => 3, // ID UNIK DITAMBAHKAN
                'nama' => 'Siti',
                'jenjang' => 'SD',
                'kelas' => '6',
                'asal_sekolah' => 'SD N 3 Ngawi',
                'no_hp' => '0857xxxxx',
                'alamat_siswa' => 'Klaten Utara',
                'status' => 'aktif',
            ],
        ]);

        return view('admin.Penerimaan_Siswa', [
            'jadwal' => $data_list,
            'siswa_list' => $data_list, // Menggunakan data yang sama untuk siswa
            'status_awal' => $status_awal_default, // Mengirimkan status default
        ]);

    }
}
