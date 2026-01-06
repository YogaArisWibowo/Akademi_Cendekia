<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Akademi Cendekia</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('css/landingpages.css') }}">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('img/logo.png') }}" alt="Akademi Cendekia Logo" class="d-inline-block align-text-top">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="d-flex gap-3 align-items-center mt-3 mt-lg-0">
            <a href="{{route('register')}}" class="btn-nav-outline">Daftar</a>
            <a href="{{route('login')}}" class="btn-nav-solid">Masuk</a>
        </div>
      </div>
    </div>
  </nav>

  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        
        <div class="col-lg-6 hero-text">
          <h1>AKADEMI CENDEKIA</h1>
          <p>
            Bergabunglah dengan Akademi Cendekia dan rasakan pengalaman belajar privat 
            yang lebih fokus, efektif, dan menyenangkan!
          </p>
          <a href="{{route('register')}}" class="btn-cta">Gabung Sekarang</a>
        </div>

        <div class="col-lg-6 hero-img text-center text-lg-end">
           <img src="{{ asset('img/gambar landingpages.png') }}" alt="Siswa Belajar" class="img-fluid">
        </div>

      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>