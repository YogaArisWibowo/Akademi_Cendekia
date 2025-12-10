@extends('layouts.app_siswa', ['title' => 'Tugas Siswa'])

@section('content')

<a href="/siswa/siswa_daftartugas" class="back-btn">
    <i class="ri-arrow-left-line"></i> Kembali
</a>

<div class="tugas-siswa-card">

    <div class="tugas-info">
        <div class="tugas-header">
            <div class="icon-wrapper">
                <i class="ri-todo-fill"></i>
            </div>

            <div>
                <h4 class="tugas-title">Tugas Menghitung Segitiga</h4>
                <span class="tanggal">11 Nov</span>
            </div>
        </div>

        <hr class="detail-line">

        <span class="label">Detail Tugas :</span>
        <p class="detail-text">
            Buatlah ringkasan materi mengenai Permintaan dan Penawaran pada Bab 3 buku Ekonomi. Ringkasan harus mencakup:

            Pengertian Permintaan dan Faktor-faktor yang Mempengaruhi Permintaan, termasuk harga, pendapatan, selera, serta barang substitusi dan komplementer.

            Pengertian Penawaran dan Faktor-faktor yang Mempengaruhi Penawaran, seperti biaya produksi, teknologi, jumlah produsen, serta ekspektasi harga.

            Penjelasan mengenai Hukum Permintaan dan Penawaran disertai contoh nyata dalam kehidupan sehari-hari.

            Buat grafik sederhana (boleh gambar tangan) yang menunjukkan kurva permintaan dan penawaran.

            Jelaskan bagaimana keseimbangan pasar (equilibrium) terjadi dan faktor apa saja yang dapat menyebabkan perubahan titik keseimbangan.

            Tuliskan minimal 2 contoh kasus dari berita atau kejadian nyata yang berhubungan dengan perubahan permintaan atau penawaran di Indonesia.

            Ringkasan ditulis dengan rapi, minimal 2 halaman, dan dikumpulkan dalam bentuk PDF atau foto tulisan tangan.
        </p>
    </div>

    <div class="jawaban-container mt-4">

        <!-- Judul -->
        <div class="jawaban-header">
            <span>Jawaban</span>
            <span class="nilai">..... / 100</span>
        </div>

        <!-- LIST JAWABAN – masih kosong karena belum ada upload -->
        <div class="jawaban-list">
            <!-- Contoh dummy untuk ngecek tinggi -->
            <!-- Nanti ini dihapus kalau backend sudah ada -->
            <div class="jawaban-item">
                <i class="ri-file-line file-icon"></i>
                <span class="file-name">Tugas_Ekonomi_Hafidz.pdf</span>
                <span class="file-size">420 KB</span>
            </div>

            <div class="jawaban-item">
                <i class="ri-image-line file-icon"></i>
                <span class="file-name">foto_tugas1.jpg</span>
                <span class="file-size">1.2 MB</span>
            </div>
        </div>

        <!-- Tombol Unggah -->
        <button class="btn-unggah-tugas w-100 mt-3">
            <i class="ri-add-line"></i> Unggah Tugas
        </button>

    </div>


</div>

@endsection