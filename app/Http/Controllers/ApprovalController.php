<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;

class ApprovalController extends Controller
{
    // Tampilan list penerimaan
    public function index()
    {
        $calonGuru = Guru::where('is_approved', false)->get();
        $calonSiswa = Siswa::where('is_approved', false)->get();
        return view('admin.penerimaan', compact('calonGuru', 'calonSiswa'));
    }

    // Fungsi ACC
    public function approveGuru($id)
    {
        Guru::where('id', $id)->update(['is_approved' => true]);
        return back()->with('success', 'Guru telah disetujui.');
    }

    public function approveSiswa($id)
    {
        Siswa::where('id', $id)->update(['is_approved' => true]);
        return back()->with('success', 'Siswa telah disetujui.');
    }
}