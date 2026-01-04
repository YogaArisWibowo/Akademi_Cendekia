<div class="sidebar-siswa">

    <div class="logo-wrapper">
        <img src="{{ asset('img/logo.png') }}" class="sidebar-logo ">
    </div>

    <ul class="menu-list">

        <li class="menu-item {{ Request::is('jadwal_siswa') ? 'active' : '' }}">
            <a href="/jadwal_siswa">
                <i class="bi bi-calendar3"></i>
                Jadwal Bimbel
            </a>
        </li>

        <li class="menu-item {{ Request::is('siswa_absensi') ? 'active' : '' }}">
            <a href="/siswa_absensi">
                <i class="bi bi-check-square"></i>
                Absensi
            </a>
        </li>

        <li
            class="menu-item {{ request()->routeIs('siswa.siswa_daftartugas') || request()->routeIs('siswa.tugas.*') ? 'active' : '' }}">
            <a href="{{ route('siswa.siswa_daftartugas') }}">
                <i class="ri-todo-fill"></i>
                Tugas Siswa
            </a>
        </li>

        <li class="menu-item {{ Request::is('siswa_pembayaran') ? 'active' : '' }}">
            <a href="/siswa_pembayaran">
                <i class="ri-wallet-3-fill"></i>
                Pembayaran Bimbel
            </a>
        </li>

        <li
            class="menu-item {{ request()->routeIs(['siswa.siswa_daftarmateri', 'siswa.materi.detail']) ? 'active' : '' }}">
            <a href="{{ route('siswa.siswa_daftarmateri') }}">
                <i class="bi bi-book"></i>
                Materi Pembelajaran
            </a>
        </li>

        <li class="menu-item {{ Request::is('siswa_videomateri') ? 'active' : '' }}">
            <a href="/siswa_videomateri">
                <i class="bi bi-play-btn-fill"></i>
                Video Materi Belajar
            </a>
        </li>

        <li class="menu-item {{ Route::is('siswa.laporan') ? 'active' : '' }}">
            <a href="{{ route('siswa.laporan') }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                Laporan Perkembangan Siswa
            </a>
        </li>

    </ul>

</div>
