<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sidebar Akademi Cendekia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      width: 280px;
      background: linear-gradient(to bottom , #03132A, #1877FF);
      color: white;
      position: fixed;
      padding-bottom: 2rem;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      display: block;
    }
    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 5px;
    }
    .sidebar .active {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
    }
    .logo {
      text-align: center;
      margin-top: 1rem;
    }
    .logo i {
      font-size: 2rem;
    }
    .logo span {
      display: block;
      font-weight: bold;
      font-size: 1.2rem;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="{{ asset('img/logo.png') }}" class="logo-img">
    </div>
    <a href="{{ route('admin_Penerimaan_Siswa') }}" class="{{ request()->routeIs('admin_Penerimaan_Siswa') ? 'active' : '' }}"><i class="bi bi-pencil-square me-2"></i> Penerimaan Siswa</a>
    <a href="{{ route('admin_Tambah_Mapel') }}" class="{{ request()->routeIs('admin_Tambah_Mapel') ? 'active' : '' }}"><i class="bi bi-file-earmark-plus me-2"></i> Tambah Mapel</a>
    <a href="{{ route('admin_Data_GurudanSiswa') }}" class="{{ request()->routeIs('admin_Data_GurudanSiswa') ? 'active' : '' }}"><i class="bi bi-file-earmark-person me-2"></i> Data Guru & Siswa</a>
    <a href="{{ route('admin_Jadwal_Bimbel') }}"  class="{{ request()->routeIs('admin_Jadwal_Bimbel') ? 'active' : '' }}">
      <i class="bi bi-calendar3 me-2"></i> Jadwal Bimbel</a>
    <a href="{{ route('admin_Absensi') }}" class="{{ request()->routeIs('admin_Absensi', 'admin_detail_absensi_siswa', 'admin_detail_absensi_guru') ? 'active' : '' }}"><i class="bi bi-check-square me-2"></i> Absensi</a>
    <a href="{{route('admin_Pembayaran_Siswa')}}" class="{{ request()->routeIs('admin_Pembayaran_Siswa', 'admin_detail_pembayaran_siswa') ? 'active' : ''}}"><i class=" bi bi-wallet me-2"></i> Pembayaran Siswa</a>
    <a href="{{ route('admin_Pencatatan_Gaji_Guru') }}"class="{{ request()->routeIs('admin_Pencatatan_Gaji_Guru','admin_detail_pencatatan_gaji_guru') ? 'active' : '' }}"><i class="bi bi-cash-coin me-2"></i> Pencatatan Gaji Guru</a>
    <a href="{{route('admin_Materi_Pembelajaran')}}" class="{{ request()->routeIs('admin_Materi_Pembelajaran','admin_detail_materi_pembelajaran') ? 'active' : '' }}"><i class="bi bi-book me-2"></i> Materi Pembelajaran</a>
    <a href="{{route('admin_Video_Materi')}}" class="{{ request()->routeIs('admin_Video_Materi') ? 'active' : '' }}"><i class="bi bi-youtube me-2"></i> Video Materi Belajar</a>
    <a href="{{route('admin_Monitoring_Guru')}}" class="{{ request()->routeIs('admin_Monitoring_Guru','admin_detail_monitoring_guru') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph me-2"></i> Monitoring Guru</a>
    <a href="{{route('admin_Laporan_Perkembangan_Siswa')}}" class="{{ request()->routeIs('admin_Laporan_Perkembangan_Siswa','admin_detail_laporan_perkembangan_siswa') ? 'active' : '' }}"><i class="bi bi-file-earmark-text me-2"></i> Laporan Perkembangan Siswa</a>
  </div>

  <div class="ms-250" style="margin-left: 250px;">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>