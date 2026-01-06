<style>
    /* --- CSS SIDEBAR --- */
    .sidebar {
        height: 100vh;
        width: 280px;
        background: linear-gradient(to bottom, #03132A, #1877FF);
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        transition: all 0.3s;
        overflow-y: auto;
        padding-bottom: 50px;
    }

    /* --- BAGIAN LOGO (UPDATE: DIPAKSA BESAR) --- */
    .logo {
        text-align: center;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        padding: 0; /* Hapus padding container agar tidak menjepit gambar */
    }

    .logo-img {
        /* PERUBAHAN DISINI: */
        width: 200px; /* Kita paksa lebarnya jadi 200px */
        height: auto; /* Tinggi menyesuaikan otomatis agar proporsional */
        
        /* Opsional: Jika gambar aslinya kecil dan pecah saat dibesarkan */
        object-fit: contain; 
        display: inline-block;
    }

    /* --- LINK MENU --- */
    .sidebar a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        padding: 12px 25px;
        display: block;
        font-size: 1rem;
        transition: 0.2s;
        border-left: 5px solid transparent;
    }

    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
    }

    /* Status Aktif */
    .sidebar .active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border-left: 5px solid #fff;
        font-weight: 600;
    }

    .sidebar i {
        width: 30px;
        font-size: 1.2rem;
        vertical-align: middle;
    }

    /* Scrollbar */
    .sidebar::-webkit-scrollbar { width: 5px; }
    .sidebar::-webkit-scrollbar-track { background: #03132A; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar { margin-left: -280px; }
        .sidebar.active { margin-left: 0; }
    }
</style>

<div class="sidebar sidebar-admin" id="sidebar-wrapper">
    
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Akademi Cendekia" class="logo-img">
    </div>

    <div class="menu-items">
        <a href="{{ route('admin_Penerimaan_Siswa') }}" class="{{ request()->routeIs('admin_Penerimaan_Siswa') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i> Penerimaan Siswa
        </a>
        
        <a href="{{ route('admin_Tambah_Mapel') }}" class="{{ request()->routeIs('admin_Tambah_Mapel') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i> Tambah Mapel
        </a>
        
        <a href="{{ route('admin_Data_GurudanSiswa') }}" class="{{ request()->routeIs('admin_Data_GurudanSiswa') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-person"></i> Data Guru & Siswa
        </a>
        
        <a href="{{ route('admin_Jadwal_Bimbel') }}" class="{{ request()->routeIs('admin_Jadwal_Bimbel') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Jadwal Bimbel
        </a>
        
        <a href="{{ route('admin_Absensi') }}" class="{{ request()->routeIs('admin_Absensi', 'admin_detail_absensi_siswa', 'admin_detail_absensi_guru') ? 'active' : '' }}">
            <i class="bi bi-check-square"></i> Absensi
        </a>
        
        <a href="{{ route('admin_Pembayaran_Siswa') }}" class="{{ request()->routeIs('admin_Pembayaran_Siswa', 'admin_detail_pembayaran_siswa') ? 'active' : '' }}">
            <i class="bi bi-wallet"></i> Pembayaran Siswa
        </a>
        
        <a href="{{ route('admin_Pencatatan_Gaji_Guru') }}" class="{{ request()->routeIs('admin_Pencatatan_Gaji_Guru','admin_detail_pencatatan_gaji_guru') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i> Pencatatan Gaji Guru
        </a>
        
        <a href="{{ route('admin_Materi_Pembelajaran') }}" class="{{ request()->routeIs('admin_Materi_Pembelajaran','admin_detail_materi_pembelajaran') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Materi Pembelajaran
        </a>
        
        <a href="{{ route('admin_Video_Materi') }}" class="{{ request()->routeIs('admin_Video_Materi') ? 'active' : '' }}">
            <i class="bi bi-youtube"></i> Video Materi Belajar
        </a>
        
        <a href="{{ route('admin_Monitoring_Guru') }}" class="{{ request()->routeIs('admin_Monitoring_Guru','admin_detail_monitoring_guru') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Monitoring Guru
        </a>
        
        <a href="{{ route('admin_Laporan_Perkembangan_Siswa') }}" class="{{ request()->routeIs('admin_Laporan_Perkembangan_Siswa','admin_detail_laporan_perkembangan_siswa') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Laporan Siswa
        </a>
    </div>

</div>