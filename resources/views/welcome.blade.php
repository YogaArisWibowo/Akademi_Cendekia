<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Akademi Cendekia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom, #03132A, #1877FF);
      color: white;
      min-height: 100vh;
    }
    .hero {
      padding: 60px 0;
    }
    .hero-text {
      margin-bottom: 30px;
    }
    .hero-img img {
      max-width: 100%;
      border-radius: 10px;
    }
    .navbar .btn {
      margin-left: 10px;
    }
    @media (max-width: 768px) {
      .hero {
        padding: 30px 15px;
      }
      .navbar-brand {
        font-size: 1.2rem;
      }
      .hero-text h1 {
        font-size: 1.8rem;
      }
      .hero-text p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-transparent px-3">
    <div class="container-fluid">
      <img src="{{ asset('img/logo.png') }}" alt="Belajar bersama" class="img-fluid">
      <div class="d-flex">
        <a href="#" class="btn btn-outline-light">Masuk</a>
        <a href="#" class="btn btn-light text-primary">Daftar</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="container hero">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-12 hero-text text-center text-lg-start">
        <h1 class="fw-bold">AKADEMI CENDEKIA</h1>
        <p class="lead mt-3">
          Bergabunglah dengan Akademi Cendekia dan rasakan pengalaman belajar privat yang lebih fokus, efektif, dan menyenangkan!
        </p>
      </div>
      <div class="col-lg-6 col-md-12 hero-img text-center">
        <img src="{{ asset('img/gambar landingpages.png') }}" alt="Belajar bersama" class="img-fluid">
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>