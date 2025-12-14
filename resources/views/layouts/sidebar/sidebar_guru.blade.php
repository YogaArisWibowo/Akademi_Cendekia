{{-- <div class="sidebar">
  <div class="logo">
    <img src="{{ asset('img/logo.png') }}" class="logo-img">
  </div>

  <a href="{{ route('jadwal_mengajar') }}" 
     class="{{ request()->routeIs('jadwal_mengajar') ? 'active' : '' }}">
     <i class="bi bi-calendar-check me-2"></i> Jadwal Mengajar
  </a>

  <a href="{{ route('absensi_guru') }}"
     class="{{ request()->routeIs('absensi_guru') ? 'active' : '' }}">
     <i class="bi bi-person-check me-2"></i> Absensi
  </a>
  <a href="{{ route('tugas_siswa') }}"
     class="{{ request()->routeIs('tugas_siswa') ? 'active' : '' }}">
     <i class="bi bi-journal-text me-2"></i> Tugas Siswa
  </a>
  <a href="{{ route('gaji_guru') }}"
     class="{{ request()->routeIs('gaji_guru') ? 'active' : '' }}">
     <i class="bi bi-cash-coin me-2"></i> Gaji Guru
  </a>
  <a href="{{ route('materi_pembelajaran') }}"
     class="{{ request()->routeIs('materi_pembelajaran') ? 'active' : '' }}">
     <i class="bi bi-book me-2"></i> Materi Pembelajaran
  </a>
  <a href="{{ route('video_materi_belajar') }}"
     class="{{ request()->routeIs('video_materi_belajar') ? 'active' : '' }}">
     <i class="bi bi-play-circle me-2"></i> Video Materi Belajar
  </a>
  <a href="{{ route('laporan_pekembangan_siswa') }}"
     class="{{ request()->routeIs('laporan_pekembangan_siswa') ? 'active' : '' }}">
     <i class="bi bi-bar-chart-line me-2"></i> Laporan Perkembangan Siswa
  </a> 
</div> --}}


<div class="sidebar-siswa">

    <div class="logo-wrapper">
        <img src="{{ asset('img/logo.png') }}" class="sidebar-logo ">
    </div>

    <ul class="menu-list">

        <li class="menu-item {{ request()->routeIs('jadwal_mengajar') ? 'active' : '' }}">
            <a href="{{ route('jadwal_mengajar') }}">
                <i class="bi bi-calendar-event-fill"></i>
                Jadwal Bimbel
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('absensi_guru') ? 'active' : '' }}">
            <a href="{{ route('absensi_guru') }}">
                <i class="bi bi-clipboard-check-fill"></i>
                Absensi
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('tugas_siswa') ? 'active' : '' }}">
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
                <i class="bi bi-book-fill"></i>
                Materi Pembelajaran
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('video_materi_belajar') ? 'active' : '' }}">
            <a href="{{ route('video_materi_belajar') }}">
                <i class="bi bi-play-btn-fill"></i>
                Video Materi Belajar
            </a>
        </li>

        <li class="menu-item  {{ request()->routeIs('laporan_pekembangan_siswa') ? 'active' : '' }} ">
            <a href="{{ route('laporan_pekembangan_siswa') }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                Laporan Perkembangan Siswa
            </a>
        </li>

    </ul>

</div>
