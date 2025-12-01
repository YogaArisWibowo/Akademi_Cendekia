<!-- Navbar -->
<nav class="navbar navbar-expand py-3 sticky-top">
    <!-- Left Navbar Links -->
    <ul class="navbar-nav ps-15">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Navbar Title (Centered) -->
    <ul class="navbar-nav mx-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link text-center text-light">@yield('title')</a>
        </li>
    </ul>

    <!-- Right Navbar Links -->
    <ul class="navbar-nav pe-3">
        @if(Auth::check())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle navbar-profile" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Profil
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><span class="dropdown-item">{{ Auth::user()->email }}</span></li>
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link btn btn-primary text-white" href="{{ route('redirect') }}">
                    Login dengan Google
                </a>
            </li>
        @endif
    </ul>
</nav>

<!-- /.navbar -->