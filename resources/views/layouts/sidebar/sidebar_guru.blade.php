<div class="sidebar-siswa">

    <div class="logo-wrapper">
        <img src="{{ asset('img/logo.png') }}" class="sidebar-logo ">
    </div>

    <ul class="menu-list">

        <li class="menu-item {{ request()->routeIs('jadwal_mengajar') ? 'active' : '' }}">
            <a href="{{ route('jadwal_mengajar') }}">
                <i class="bi bi-calendar3"></i>
                Jadwal Mengajar
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('absensi_guru') ? 'active' : '' }}">
            <a href="{{ route('absensi_guru') }}">
                <i class="bi bi-check-square"></i>
                Absensi
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('tugas_siswa') || request()->routeIs('detail_tugas_siswa') || request()->routeIs('detail_tugas_persiswa') ? 'active' : '' }}">
            <a href="{{ route('tugas_siswa') }}">
                <i class="ri-todo-fill"></i>
                Tugas Siswa
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('gaji_guru') ? 'active' : '' }}">
            <a href="{{ route('gaji_guru') }}">
                <i class="ri-wallet-3-fill"></i>
                Gaji Guru
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('materi_pembelajaran') || request()->routeIs('detail_materi_pembelajaran') ? 'active' : '' }}">
            <a href="{{ route('materi_pembelajaran') }}">
                <i class="bi bi-book"></i>
                Materi Pembelajaran
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('video_materi_belajar') ? 'active' : '' }}">
            <a href="{{ route('video_materi_belajar') }}">
                <i class="bi bi-play-btn-fill"></i>
                Video Materi Belajar
            </a>
        </li>

        <li class="menu-item  {{ request()->routeIs('laporan_perkembangan_siswa')|| request()->routeIs('detail_laporan_perkembangan_siswa') ? 'active' : '' }} ">
            <a href="{{ route('laporan_perkembangan_siswa') }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                Laporan Perkembangan Siswa
            </a>
        </li>

    </ul>

</div>
