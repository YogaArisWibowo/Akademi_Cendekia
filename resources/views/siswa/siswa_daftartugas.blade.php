@extends('layouts.app_siswa', ['title' => 'Tugas Siswa'])

@section('content')

<div class="daftar-tugas-container">

    <!-- Card Tugas 1 -->
    <a href="/siswa/siswa_tugas" class="tugas-card-link">
        <div class="tugas-card">
            <div class="tugas-header">
                <div class="icon-wrapper">
                    <i class="ri-todo-fill"></i>
                </div>
                <div>
                    <h4 class="tugas-title">Tugas Menghitung Segitiga</h4>
                    <span class="tanggal">11 Nov</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Tugas 2 -->
    <a href="/siswa/siswa_tugas" class="tugas-card-link">
        <div class="tugas-card">
            <div class="tugas-header">
                <div class="icon-wrapper">
                    <i class="ri-todo-fill"></i>
                </div>
                <div>
                    <h4 class="tugas-title">Ringkasan Permintaan & Penawaran</h4>
                    <span class="tanggal">12 Nov</span>
                </div>
            </div>
        </div>
    </a>

</div>

@endsection
