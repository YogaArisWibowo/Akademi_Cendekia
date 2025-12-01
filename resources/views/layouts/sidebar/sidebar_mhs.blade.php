<!-- Sidebar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4 custom-ungu">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset ('img/Logo/Logo D3Mi Simbol.png') }}" srcset="img/Logo/Logo D3Mi Simbol.png" alt="D3MI Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-medium" style="font-size: 16px">Manajemen Informatika</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <!-- Sidebar user panel (optional) -->


        <!-- Sidebar Menu -->
        <nav class="mt-12">
            <ul class="nav nav-pills nav-sidebar flex-column my-auto" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('view_mitra') }}" class="nav-link">
                        <div class="nav-icon">
                            <i><ion-icon src="{{asset ('img/svg/hugeicons--building-05.svg') }}"></ion-icon></i>
                            <p>
                                Mitra KKL
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('berkas_mhs.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <i><ion-icon src="{{asset ('img/svg/solar--document-add-linear.svg') }}"></ion-icon></i>
                            <p>
                                Kirim Berkas
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mahasiswa_logbook.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <i><ion-icon src="{{asset ('img/svg/ph--list-checks-bold.svg') }}"></ion-icon></i>
                            <p>
                                Logbook
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mahasiswa_nilai.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <i><ion-icon src="{{asset ('img/svg/hugeicons--pencil-edit-02.svg') }}"></ion-icon></i>
                            <p>
                                Nilai KKL
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan_magang.index') }}" class="nav-link">
                        <div class="nav-icon">
                            <i><ion-icon src="{{asset ('img/svg/hugeicons--note.svg') }}"></ion-icon></i>
                            <p>
                                Laporan Magang
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('sertifikat_mhs') }}" class="nav-link">
                        <div class="nav-icon">
                            <i><ion-icon src="{{asset ('img/svg/ph--certificate-light.svg') }}"></ion-icon></i>
                            <p>
                                Sertifikat
                            </p>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <a href="javascript:void(0);" class="nav-link"
                        onclick="document.getElementById('logout-form').submit();">
                        <div class="nav-icon">
                            <i><ion-icon src="{{ asset('img/svg/eva--log-out-outline.svg') }}"></ion-icon></i>
                            <p>Logout</p>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <!-- Sidebar user (optional) -->

    </div>
    <!-- /.sidebar -->
</aside>