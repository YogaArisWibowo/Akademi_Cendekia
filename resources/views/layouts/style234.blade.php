<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<!-- swiper -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
<link href="summernote-bs5.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Quicksand:wght@300..700&display=swap"
    rel="stylesheet">

<style>
    :root {
        --font-default: 'Public Sans', sans-serif;
        --color-primary-1: #700070;
        --color-primary-2: #4A1B9D;
        --color-secondary-1: #FFCC00;
        --color-secondary-2: #FFAC00;
        --color-secondary-3: #FF7900;
        --color-purple-transparent: rgba(158, 0, 156, 0.15);
    }

    .modal-backdrop:nth-of-type(2) {
        z-index: 1050 !important;
    }

    .modal:nth-of-type(2) {
        z-index: 1060 !important;
    }

    .content-wrapper {
        background-color: transparent;
    }

    table {
        border: 1px solid black;
    }

    /* Bagian Login */

    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    /* Akhir Bagian Login */

    /* Bagian Navbar */
    .navbar {
        background-image: linear-gradient(to right, #700070, #4A1B9D);
    }

    .navbar-nav .mx-auto {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .nav-item {
        display: flex;
        align-items: center;
        font-size: 24px;
        font-family: var(--font-default);
        font-weight: 600;
    }

    .navbar .navbar-nav .navbar-profile {
        font-size: 16px;
        color: #fff;
    }

    /* Akhir Bagian Navbar */

    /* Bagian Sidebar */

    /* Ubah warna background dan teks untuk elemen sidebar aktif */
    .sidebar .nav-link.active {
        background-color: #fff !important;
        /* Warna latar (ganti sesuai keinginan) */
        color: var(--color-primary-1) !important;
        /* Warna teks */
    }

    /* Jika sidebar memiliki hover effect */
    .sidebar .nav-link.active:hover {
        background-color: #fff !important;
        /* Warna latar saat hover */
        color: var(--color-primary-1) !important;
        /* Warna teks saat hover */
    }



    .main-sidebar {
        background-color: var(--color-primary-1);
    }

    .nav .nav-item .nav-icon p {
        display: inline;
        white-space: nowrap;
        align-items: center;
        font-size: 16px;
        font-family: var(--font-default);
        font-weight: 400;
        margin-left: 12px;
    }

    .nav-item ion-icon {
        font-size: 32px;
        padding-top: 8px;
        margin-right: 12px;
        margin-left: -4px;
    }

    .nav-icon {
        display: flex;
        align-items: center;
    }

    /* Akhir Bagian Sidebar */

    /* Bagian Page Admin-Mitra */
    .text-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .text-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tbl-container {
        max-width: fit-content;
        max-height: fit-content;
    }

    .tbl-fixed {
        overflow-x: scroll;
        overflow-y: scroll;
        height: fit-content;
        max-height: 70vh;
    }

    table {
        min-width: max-content;
        border-collapse: separate;
        width: 100%;
    }

    table thead {
        background-color: var(--color-primary-2);
    }

    table th {
        position: sticky;
        padding: 6px;
        color: #fff;
        text-align: center;
    }

    table tbody {
        background-color: #fff;
    }

    table td {
        padding: 6px;
        overflow-wrap: break-word;
        /* Memungkinkan teks untuk membungkus */
        word-wrap: break-word;
        /* Untuk kompatibilitas dengan browser lama */
        white-space: normal;
        /* Pastikan teks bisa membungkus ke baris baru */
        word-break: break-all;
    }

    /* Akhir Bagian Page Admin-Mitra */

    /* Bagian Mahasiswa Berkas */
    .mahasiswa .card-body h5 {
        color: var(--color-primary-1);
        font-size: 20px;
        font-family: var(--font-default);
        font-weight: 600;
    }

    .mahasiswa .card-body .btn {
        background-color: transparent;
        color: var(--color-primary-1);
        border: 1.5px solid var(--color-primary-1);
        font-family: var(--font-default);
        font-weight: 600;
        font-size: 16px;
    }

    .mahasiswa .card-body .btn:hover {
        background-color: var(--color-primary-1);
        color: white;
    }

    /* Akhir Bagian Mahasiswa Berkas */

    /* Bagian Dashboard Mitra */
    .mhs-aktif {
        margin-bottom: 16px;
    }

    .mhs-aktif h1 {
        font-size: 24px;
        font-family: var(--font-default);
        font-weight: 600;
    }

    .mhs-aktif a {
        color: #4A1B9D;
        font-size: 12px;
        font-family: var(--font-default);
        font-weight: 600;
    }

    .kotak1 {
        background-color: var(--color-purple-transparent);
        border-radius: 8px;
    }

    .kotak1 ion-icon {
        color: #700070;
        font-size: 96px;
        margin-right: 36px;
    }

    .teks1 {
        display: inline-block;
        font-family: var(--font-default);
        margin-top: 16px;
    }

    .box-berita {
        border-radius: 8px;
        background-color: var(--color-purple-transparent);
    }

    .almt-mitra a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
        border-radius: 16px;
        transition: background-color 0.3s;
    }

    .almt-mitra a:hover {
        background-color: var(--color-purple-transparent);
    }


    /* Akhir Bagian Dashboard Mitra */

    /* Bagian Logbook Mitra */

    .form-select {
        border: 1.5px solid var(--color-secondary-3);
        background-color: transparent;
    }

    .table thead {
        background-color: var(--color-primary-2);
    }

    /* Styling dasar untuk button */
    .btn-filter {
        padding: 7px 20px;
        font-size: 14px;
        color: #652cc9;
        background-color: #fff;
        border: 2px solid #652cc9;
        border-radius: 5px;
        font-weight: medium;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-filter:hover {
        background-color: #652cc9;
        color: white;
    }

    /* Styling saat button dalam keadaan aktif */
    .btn-filter.active {
        background-color: #652cc9;
        color: white;
    }

    /* Akhir Bagian Logbook Mitra */

    /* Bagian Penilaian Mitra */

    .content-filter-title ion-icon {
        color: #700070;
        font-size: 24px;
        margin-right: 8px;
    }

    .penilaianmitra .btn {
        background-color: transparent;
        color: var(--color-primary-1);
        border: 1.5px solid var(--color-primary-1);
        font-family: var(--font-default);
        font-weight: 600;
        font-size: 16px;
    }

    .penilaianmitra .btn:hover {
        background-color: var(--color-primary-1);
        color: white;
    }

    /* Akhir Bagian Penilaian Mitra */

    /* Bagian View Profil Mitra */

    .container .card {
        box-shadow: inset;
        border-radius: 12px;
    }

    .img-fluid {
        border-radius: 8px;
        border: 1.5px solid var(--color-primary-2);
    }

    .card-title {
        font-family: var(--font-default);
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .mitra-link .pilih-mitra {
        background-color: transparent;
        border: 1.5px solid var(--color-secondary-3);
        border-radius: 8px;
    }

    .mitra-link .card-text {
        color: var(--color-secondary-3);
        font-family: var(--font-default);
        font-weight: 500;
        font-size: 16px;
    }

    .medsos-mitra ion-icon {
        color: black;
        font-size: 24px;
        padding: 4px 8px;
    }

    .almt-mitra .card-text {
        color: black;
        font-family: var(--font-default);
        font-weight: 500;
        font-size: 12px;
    }

    .profilmitra .btn {
        background-color: transparent;
        color: var(--color-primary-1);
        border: 1.5px solid var(--color-primary-1);
        font-family: var(--font-default);
        font-weight: 600;
        font-size: 16px;
    }

    .profilmitra .btn:hover {
        background-color: var(--color-primary-1);
        color: white;
    }

    /* Akhir Bagian View Profil Mitra */

    /* Bagian Edit Profil Mitra */
    .content-edit-profil-mitra {
        border-radius: 8px;
    }

    .content-edit-profil-mitra label {
        color: #700070;
        font-family: var(--font-default);
        font-weight: 600;
    }

    .form-check-label {
        font-family: var(--font-default);
        font-weight: 400;
        font-size: 12px;
    }

    .card-header ion-icon {
        font-size: 24px;
        margin-right: 12px;
    }

    .card-footer .btn,
    .card-header .btn {
        background-color: transparent;
        color: var(--color-primary-1);
        border: 1.5px solid var(--color-primary-1);
        font-family: var(--font-default);
        font-weight: 600;
        font-size: 16px;
    }

    */ .card-footer .btn:hover,
    .card-header .btn:hover {
        background-color: var(--color-primary-1);
        color: white;
    }

    /* Akhir Bagian Edit Profil Mitra */

    /* Bagian Penilaian DPL */

    .penilaiandpl .btn {
        background-color: transparent;
        color: var(--color-primary-1);
        border: 1.5px solid var(--color-primary-1);
        font-family: var(--font-default);
        font-weight: 600;
        font-size: 16px;
    }

    .penilaiandpl .btn:hover {
        background-color: var(--color-primary-1);
        color: white;
    }

    /* Admin Laporan Magang */

    /* Kontainer utama untuk kolom sortable */
    .sort-container {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        /* Jarak antara teks dan ikon */
    }

    /* Tombol sorting */
    .sort-btn {
        display: inline-flex;
        align-items: center;
        color: #adadad;
        text-decoration: none;
        font-size: 1rem;
        /* Ukuran ikon */
        transition: color 0.2s ease;
    }

    /* Hover untuk tombol */
    .sort-btn:hover {
        color: #fff;
    }

    /* Status tombol aktif */
    .sort-btn.active {
        color: #fff;
        font-weight: bold;
    }

    /* Penataan tabel */
    .sortable-column {
        text-align: left;
        white-space: nowrap;
        /* Hindari teks terpotong */
    }

    /* Admin Logbook */
    .content-month a h5 {
        color: #000;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .content-month h5 span {
        font-size: .8rem;
    }

    .adminLogbook .connectedSortable .card-body .img-fluid {
        border: 1px solid transparent !important;
    }
</style>


{{-- css logbook --}}
<style>
    /* body{
    background-color: blueviolet;
} */
    :root {
        --white-color: #fff;
        --dark-color: #252525;
        --primary-color: #700070;
        --secondary-color: #f3961c;
        --light-pink-color: #faf4f5;
        --medium-gray-color: #ccc;

        /* Font size */
        --font-sizq: 0.9rem;
        --font-size-n: 1rem;
        --font-size-m: 1.12rem;
        --font-size-1: 1.5rem;
        --font-size-xl: 2rem;
        --font-size-xxl: 2.3rem;

        /* Border radius */
        --border-radius-s: 8px;
        --border-radius-m: 30px;
        --border-radius-circle: 50%;
        /* site max width */
        --site-max-width: 1300px;
    }


    /* styling untuk whole site */
    ul {
        list-style: none;
    }

    a {
        text-decoration: none;
    }

    button {
        cursor: pointer;
        border: none;
        background: none;
    }

    img {
        width: auto;
    }


    /* styling navbar */
    header {
        background-color: var(--primary-color);
    }

    .navbar .nav-logo .logo-text {
        color: var(--white-color);
    }

    .navbar .nav-menu .nav-link {
        color: var(--white-color);
    }

    .custom-max-width {
        width: 1200px;
    }

    .custom-max-height {
        height: 300px;
    }

    .status-icon {
        padding-right: 4px;
    }


    .form-container {
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        text-align: center;
        font-size: 24px;
        color: #6a1b9a;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    /* .form-group label { 
    width: 45%; 
} */

    .form-group input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-buttons {
        text-align: center;
        margin-top: 20px;
    }

    .form-buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-buttons .edit-button {
        background-color: #fff;
        color: #6a1b9a;
        margin-right: 10px;
        border: solid;
    }

    .form-buttons .save-button {
        background-color: #6a1b9a;
        color: white;
    }

    img[alt="Icon-checklist"] {
        color: green;
    }

    .checklist-icon {
        color: green;
        text-decoration: solid;
    }

    .mhsLogbook .card .card-body::after {
        content: none;
        display: none;
    }

    .pending-icon {
        color: #FFAC00;
    }

    .cross-icon {
        color: #C00F0C;
    }


    .panahkanan-icon {
        color: #700070;
    }

    .panahkiri-icon {
        color: #700070;
    }

    img[alt="Icon-next"] {
        margin-left: 8px;
        color: green;
    }

    img[alt="Icon-back"] {
        margin-right: 8px;
        color: green;
    }


    .buttons button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .buttons .edit-button {
        background-color: #fff;
        color: #6a1b9a;
        margin-right: 10px;
        border: solid;
    }

    .buttons .save-button {
        background-color: #6a1b9a;
        color: white;
    }


    .contentRight1 {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
        /* Optional: adjust the spacing between buttons and image */
    }

    .edit-button,
    .save-button {
        width: 100%;
        /* Optional: adjust the button width */
        margin: 5px 0;
        /* Optional: adjust the spacing between buttons */
    }

    .connectedSortable {
        margin-right: 16px;
    }

    .upload-section {
        background-color: white;
        padding: 56px;
        border-radius: 10px;
        text-align: center;
        margin-top: 20px;
    }


    .upload-section h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .upload-box {
        border: 2px dashed #800080;
        padding: 56px;
        border-radius: 10px;
        display: inline-block;
        cursor: pointer;
    }

    .upload-box button {
        background-color: #800080;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Styling dasar untuk button */
    .btn-filter {
        padding: 7px 20px;
        font-size: 14px;
        color: #652cc9;
        background-color: #fff;
        border: 2px solid #652cc9;
        border-radius: 5px;
        font-weight: medium;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-filter:hover {
        background-color: #652cc9;
        color: white;
    }

    /* Styling saat button dalam keadaan aktif */
    .btn-filter.active {
        background-color: #652cc9;
        color: white;
    }


    /* untuk menurunkan opacity */
    .redup {
        opacity: 0.5;
    }
</style>

<link href="{{ asset('css/custom.css') }}" rel="stylesheet">