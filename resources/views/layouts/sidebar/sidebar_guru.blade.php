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
      padding-top: 1rem;
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
      margin-bottom: 2rem;
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
    <a href="#" class="active"><i class="bi bi-calendar-check me-2"></i> Jadwal Mengajar</a>
    <a href="#"><i class="bi bi-person-check me-2"></i> Absensi</a>
    <a href="#"><i class="bi bi-journal-text me-2"></i> Tugas Siswa</a>
    <a href="#"><i class="bi bi-cash-coin me-2"></i> Gaji</a>
    <a href="#"><i class="bi bi-book me-2"></i> Materi Pembelajaran</a>
    <a href="#"><i class="bi bi-play-circle me-2"></i> Video Materi Belajar</a>
    <a href="#"><i class="bi bi-bar-chart-line me-2"></i> Laporan Perkembangan Siswa</a>
  </div>

  <div class="ms-250 p-4" style="margin-left: 250px;">
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>