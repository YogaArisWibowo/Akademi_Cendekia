<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GajiGuruController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel guru
        $guru = Guru::all();

        // Mengirim variabel $gurus ke view
        return view('admin.Pencatatan_Gaji_Guru', compact('guru'));
    }
}