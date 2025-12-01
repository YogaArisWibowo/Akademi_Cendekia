<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('judul')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background-color: #f8f9fa;
    }
    .main-content {
      margin-left: 280px; /* menyesuaikan lebar sidebar */
      padding-left: 20px;
    }
  </style>
</head>
<body>
  @include('layouts.sidebar.sidebar_guru') <!-- Sidebar tetap fixed -->

  <div class="main-content">
    <!-- Konten jadwal bisa ditambahkan di sini -->
    <h2>Jadwal Mengajar</h2>
    
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>