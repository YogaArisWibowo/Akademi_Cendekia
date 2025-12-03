<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('Login')</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
            rel="stylesheet"
        />
        <style>
            body {
                margin: 0;
                background: linear-gradient(to bottom, #03132a, #1877ff);
                height: 100vh;
            }
            .navbar a:hover {
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container-fluid border-bottom border-2 pb-3"
            style="border-color: #2F6FCA !important;">
                <img src="{{ asset('img/logo-nav.png') }}" alt="logo" class="logo-img ms-3 "
                style="width: 180px;">
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="collapse navbar-collapse" 
                    id="navbarSupportedContent"
                >
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a
                                class="nav-link active text-white me-4 px-3 py-0 pb-1 border border-2 rounded"
                                style="border-color: #2F6FCA !important;"
                                aria-current="page"
                                href="#"
                                >Beranda</a
                            >
                        </li>
                </div>
            </div>
        </nav>

        <div class="main-content d-flex justify-content-center align-items-center">
            <div class="align-bottom">
                YOGA HITAM
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
