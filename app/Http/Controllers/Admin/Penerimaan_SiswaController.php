<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Siswa;

class Penerimaan_Siswacontroller extends Controller
{
    Public Function index(){
        $siswa = Siswa::all();

    // 2. Kirim variabel $siswa ke view
    // 'admin.penerimaan_siswa' adalah lokasi file blade Anda
    return view('admin.penerimaan_siswa', compact('siswa'));

    }

    public function updateStatusSiswa(Request $request, $id)
    {
        // Temukan data siswa
        $siswa = Siswa::findOrFail($id);
        
        // UPDATE STATUS AKTIF DI DATABASE
        $siswa->status_penerimaan = $request->status_penerimaan;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Status penerimaan siswa berhasil diupdate'
        ]);
    }
}
