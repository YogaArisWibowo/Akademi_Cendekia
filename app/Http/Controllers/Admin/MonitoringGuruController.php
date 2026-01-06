<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;

class MonitoringGuruController extends Controller
{
    public function index()
    {
        // Ganti paginate() menjadi get()
        $gurus = Guru::latest()->get(); 

        return view('admin.Monitoring_Guru', compact('gurus'));
    }
}