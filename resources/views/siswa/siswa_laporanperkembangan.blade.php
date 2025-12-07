@extends('layouts.app_siswa', ['title' => 'Laporan Perkembangan Siswa'])
@section('content')

<!-- Card Nilai Rata-rata -->
<div class="nilai-card d-flex align-items-center justify-content-between mb-4">
    <div class="nilai-text">
        <span>Nilai Rata-rata</span>
    </div>
    <div class="nilai-circle">
        88
    </div>
</div>

<!-- Tabel Data Perkembangan -->
<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mapel</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1.</td>
                <td>Senin</td>
                <td>05–Okt–2025</td>
                <td>15.00</td>
                <td>Matematika</td>
                <td>Baik, memahami materi segitiga</td>
            </tr>

            <tr>
                <td>2.</td>
                <td>Selasa</td>
                <td>06–Okt–2025</td>
                <td>15.00</td>
                <td>IPA</td>
                <td>Perlu latihan soal tambahan</td>
            </tr>

            <tr>
                <td>3.</td>
                <td>Rabu</td>
                <td>07–Okt–2025</td>
                <td>15.00</td>
                <td>Bahasa Indonesia</td>
                <td>Nilai bagus, lancar menulis ringkasan</td>
            </tr>
        </tbody>
    </table>

    <div class="pagination-wrapper mt-3">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page">Selanjutnya</button>
    </div>
</div>

@endsection
