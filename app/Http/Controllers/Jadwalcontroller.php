<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Jadwalcontroller extends Controller
{
   Public Function adminindex(){
        // Dummy data biar tabelnya tampil seperti contoh
        $jadwal = collect([
            (object)[
                'hari' => 'Senin',
                'tanggal' => '05-Okt-2025',
                'waktu' => '15.00',
                'mapel' => 'IPAS',
                'guru' => 'Ira Sulistya',
                'nama_siswa' => 'Hafidz',
                'alamat_siswa' => 'Jl. Kenari',
            ],
            (object)[
                'hari' => 'Senin',
                'tanggal' => '05-Okt-2025',
                'waktu' => '15.00',
                'mapel' => 'IPAS',
                'guru' => 'Ira Sulistya',
                'nama_siswa' => 'Hafidz',
                'alamat_siswa' => 'Jl. Kenari',
            ],
            (object)[
                'hari' => 'Senin',
                'tanggal' => '05-Okt-2025',
                'waktu' => '15.00',
                'mapel' => 'IPAS',
                'guru' => 'Ira Sulistya',
                'nama_siswa' => 'Hafidz',
                'alamat_siswa' => 'Jl. Kenari',
            ],
        ]);

        return view('admin.Jadwal_Bimbel', compact('jadwal'));

        // $user = Auth::user();

        // if ($user->role === 'admin') {
        //     return view('admin.Jadwal_Bimbel', compact('jadwal'));
        // } else {
        //     return view('siswa.jadwal_bimbel', compact('jadwal'));
        // }

    }

    Public Function siswaindex(){
        // Dummy data biar tabelnya tampil seperti contoh
        $jadwal = collect([
            (object)[
                'hari' => 'Senin',
                'tanggal' => '05-Okt-2025',
                'waktu' => '15.00',
                'mapel' => 'IPAS',
                'guru' => 'Ira Sulistya',
                'nama_siswa' => 'Hafidz',
                'alamat_siswa' => 'Jl. Kenari',
            ],
            (object)[
                'hari' => 'Senin',
                'tanggal' => '05-Okt-2025',
                'waktu' => '15.00',
                'mapel' => 'IPAS',
                'guru' => 'Ira Sulistya',
                'nama_siswa' => 'Hafidz',
                'alamat_siswa' => 'Jl. Kenari',
            ],
            (object)[
                'hari' => 'Senin',
                'tanggal' => '05-Okt-2025',
                'waktu' => '15.00',
                'mapel' => 'IPAS',
                'guru' => 'Ira Sulistya',
                'nama_siswa' => 'Hafidz',
                'alamat_siswa' => 'Jl. Kenari',
            ],
        ]);

        return view('siswa.siswa_jadwalbimbel', compact('jadwal'));

    }

}
