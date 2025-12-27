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
            class="menu-item {{ Request::is('siswa/siswa_daftartugas') || Request::is('siswa/siswa_tugas') ? 'active' : '' }}">
            <a href="/siswa/siswa_daftartugas">
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
            class="menu-item {{ Request::is('siswa/siswa_daftarmateri') || Request::is('siswa/siswa_materi') ? 'active' : '' }}">
            <a href="/siswa/siswa_daftarmateri">
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

        <li class="menu-item {{ Request::is('siswa_laporanperkembangan') ? 'active' : '' }}">
            <a href="/siswa_laporanperkembangan">
                <i class="bi bi-file-earmark-text-fill"></i>
                Laporan Perkembangan Siswa
            </a>
        </li>

    </ul>

</div>
