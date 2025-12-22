@extends('layouts.app_admin', ['title' => 'Absensi']) @section('content')

<style>
  /* Container Utama */
.content-wrapper {
    padding: 20px;
    background-color: #f8faff; /* Warna background tipis kebiruan */
}

.section-title {
    font-size: 24px;
    font-weight: 600;
    color: #0d1b3e;
    margin-bottom: 20px;
}

/* Search Bar */
.search-input-wrapper {
    position: relative;
}

.search-input {
    width: 100%;
    padding: 12px 12px 12px 45px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #ffffff;
    font-size: 14px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #cbd5e0;
    font-size: 18px;
}

/* Card Styling */
.custom-card-link {
    text-decoration: none !important; /* Menghilangkan underline link */
    display: block;
}

.custom-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 15px;
    border: 1px solid #edf2f7;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.custom-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.card-body-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.name {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1a202c;
}

.subtitle {
    margin: 4px 0 0 0;
    font-size: 13px;
    color: #718096;
}

/* Badge Biru */
.badge-number {
    background-color: #2b6cb0; /* Biru sesuai gambar */
    color: white;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    box-shadow: 0 4px 6px rgba(43, 108, 176, 0.3);
}

/* Pagination */
.pagination-container {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
}

.btn-page {
    border: none;
    background: transparent;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    color: #4a5568;
    cursor: pointer;
}

.btn-page.active {
    background-color: #ebf4ff;
    color: #3182ce;
    font-weight: 600;
}

.btn-page.next-btn {
    background-color: #c3dafe;
    color: #1a365d;
    font-weight: 500;
    border-radius: 8px;
}

.btn-page:disabled {
    cursor: default;
    background-color: #f7fafc;
}
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 mb-5">
            <h3 class="section-title">Absensi Guru</h3>
            <div class="search-input-wrapper mb-4">
                <i class="ri-search-line search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari">
            </div>

            <div class="list-wrapper">
                @for($i = 0; $i < 6; $i++)
                <a href="{{ route('admin_detail_absensi_guru') }}" class="custom-card-link">
                    <div class="custom-card">
                        <div class="card-body-content">
                            <div class="info">
                                <h5 class="name">Ira Sulistya</h5>
                                <p class="subtitle">Guru jenjang : SD</p>
                            </div>
                            <div class="badge-number">1</div>
                        </div>
                    </div>
                </a>
                @endfor
            </div>

            <div class="pagination-container mt-4">
                <button class="btn-page text-muted" disabled>Sebelumnya</button>
                <button class="btn-page active">1</button>
                <button class="btn-page">2</button>
                <button class="btn-page">3</button>
                <button class="btn-page next-btn">Selanjutnya</button>
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <h3 class="section-title">Absensi Siswa</h3>
            <div class="search-input-wrapper mb-4">
                <i class="ri-search-line search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari">
            </div>

            <div class="list-wrapper">
                @for($i = 0; $i < 6; $i++)
                <a href="{{ route('admin_detail_absensi_siswa') }}" class="custom-card-link">
                    <div class="custom-card">
                        <div class="card-body-content">
                            <div class="info">
                                <h5 class="name">Ira Sulistya</h5>
                                <p class="subtitle">Kelas/jenjang : SD</p>
                            </div>
                            <div class="badge-number">1</div>
                        </div>
                    </div>
                </a>
                @endfor
            </div>

            <div class="pagination-container mt-4">
                <button class="btn-page text-muted" disabled>Sebelumnya</button>
                <button class="btn-page active">1</button>
                <button class="btn-page">2</button>
                <button class="btn-page">3</button>
                <button class="btn-page next-btn">Selanjutnya</button>
            </div>
        </div>
    </div>
</div>

@endsection
