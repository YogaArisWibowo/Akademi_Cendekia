@extends('layouts.app_admin', ['title' => 'Data Guru & Siswa'])
@section('content')

<style>
    .tambah {
        margin-bottom: 5px;
        display: flex;
        justify-content: flex-end;
        color: white;
        border: none;
        border-radius: 6px;
        background-color: #ffd700;
        font-weight: 500 !important;
        align-items: center;
        width: 102px;
        height: 30px;
    }
    .tambah i {
        color: white;
        font-size: 25px !important;
        padding-left: 5px;
        line-height: 0;
        vertical-align: middle;
        display: inline-block;
    }
    .tambah-siswa {
        margin-bottom: 5px;
        display: flex;
        justify-content: flex-end;
        color: white;
        border: none;
        border-radius: 6px;
        background-color: #ffd700;
        font-weight: 500 !important;
        align-items: center;
        width: 102px;
        height: 30px;
        margin-top: 20px;
    }
    .tambah-siswa i {
        color: white;
        font-size: 25px !important;
        padding-left: 5px;
        line-height: 0;
        vertical-align: middle;
        display: inline-block;
    }
    .data {
        font-weight: 600 !important;
        font-size: 30px;
        padding-left: 15px;
    }
    .data-siswa {
        font-weight: 600 !important;
        font-size: 30px;
        padding-left: 15px;
        padding-top: 20px;
    }
    .custom-status-dropdown {
        border-radius: 15px !important; 
        padding: 5px 15px; 
        border-color: #3f51b5; 
        transition: all 0.3s; /* Efek transisi untuk perubahan warna */
    }

    .status-aktif {
        background-color: #e8f5e9 !important; 
        color: #2e7d32 !important; 
        font-weight: bold;
    }

    .status-non-aktif {
        background-color: #ffebee !important; 
        color: #c62828 !important; 
        font-weight: bold;
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-2">
    <p class="data">Data Guru</p>

    <button
        class="tambah text-center"
        data-bs-toggle="modal"
        data-bs-target="#modalTambahJadwal"
    >
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenjang</th>
                <th>Kelas</th>
                <th>Asal Sekolah</th>
                <th>No Hp</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($jadwal as $i => $j)
        @php
            // Ambil status dari database (data dummy), jika tidak ada, gunakan default dari Controller
            $current_status = $j->status ?? $status_awal;
            $css_class = $current_status == 'aktif' ? 'status-aktif' : 'status-non-aktif';
        @endphp

            <tr id="row-{{ $j->id }}" class="table-{{ $current_status == 'aktif' ? 'success' : 'secondary' }}">
                <td>{{ $j->id }}</td> {{-- Menggunakan ID untuk debugging --}}
                <td>{{ $j->nama }}</td>
                <td>{{ $j->jenjang }}</td>
                <td>{{ $j->kelas }}</td>
                <td>{{ $j->asal_sekolah }}</td>
                <td>{{ $j->no_hp }}</td>
                <td>
                    {{-- Dropdown Status --}}
                    <select
                        class="form-select form-select-sm custom-status-dropdown {{ $css_class }}" 
                        id="status-select-{{ $j->id }}" 
                        aria-label="Status {{ $j->id }}"
                    >
                        <option value="aktif" @if($current_status == 'aktif') selected @endif > Aktif
                        </option>
                        <option value="non aktif" @if($current_status == 'non aktif') selected @endif > Non Aktif
                        </option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-sm btn-info">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="pagination-wrapper">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page active">Selanjutnya</button>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center mb-2 mt-4">
    <p class="data">Data Siswa</p>

    <button
        class="tambah text-center"
        data-bs-toggle="modal"
        data-bs-target="#modalTambahJadwal"
    >
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenjang</th>
                <th>Kelas</th>
                <th>Asal Sekolah</th>
                <th>No Hp</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($jadwal as $i => $j)
        @php
            // Ambil status dari database (data dummy), jika tidak ada, gunakan default dari Controller
            $current_status = $j->status ?? $status_awal;
            $css_class = $current_status == 'aktif' ? 'status-aktif' : 'status-non-aktif';
        @endphp

            <tr id="row-{{ $j->id }}" class="table-{{ $current_status == 'aktif' ? 'success' : 'secondary' }}">
                <td>{{ $j->id }}</td> {{-- Menggunakan ID untuk debugging --}}
                <td>{{ $j->nama }}</td>
                <td>{{ $j->jenjang }}</td>
                <td>{{ $j->kelas }}</td>
                <td>{{ $j->asal_sekolah }}</td>
                <td>{{ $j->no_hp }}</td>
                <td>
                    {{-- Dropdown Status --}}
                    <select
                        class="form-select form-select-sm custom-status-dropdown {{ $css_class }}" 
                        id="status-select-{{ $j->id }}" 
                        aria-label="Status {{ $j->id }}"
                    >
                        <option value="aktif" @if($current_status == 'aktif') selected @endif > Aktif
                        </option>
                        <option value="non aktif" @if($current_status == 'non aktif') selected @endif > Non Aktif
                        </option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-sm btn-info">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="pagination-wrapper">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page active">Selanjutnya</button>
    </div>
</div>

<script>
    $(document).ready(function () {
        
        // 1. Fungsi untuk menerapkan warna awal saat halaman dimuat
        $('[id^="status-select-"]').each(function() {
            var selectedValue = $(this).val();
            var $dropdown = $(this);
            var tableRow = $dropdown.closest('tr');
            
            // Hapus kelas Bootstrap/kustom yang mungkin sudah ada dari Blade/default
            tableRow.removeClass('table-success table-secondary'); 
            $dropdown.removeClass('status-aktif status-non-aktif');
            
            // Terapkan warna awal
            if (selectedValue === "non aktif") {
                $dropdown.addClass("status-non-aktif");
                tableRow.addClass("table-secondary");
            } else {
                $dropdown.addClass("status-aktif");
                tableRow.addClass("table-success");
            }
        });

        // 2. Fungsi untuk menangani perubahan (change event)
        $('[id^="status-select-"]').on("change", function () {
            // Simpan referensi objek
    var $dropdown = $(this);
    var tableRow = $dropdown.closest("tr");
    
    // --- PENTING: HAPUS SEMUA KELAS WARNA ---
    // Hapus kelas warna kustom
    $dropdown.removeClass('status-aktif status-non-aktif');
    // Hapus kelas warna Bootstrap untuk baris
    tableRow.removeClass('table-success table-secondary'); 
    
    // --- Terapkan Kelas Baru ---
    if (selectedValue === "non aktif") {
        // Terapkan Non Aktif
        $dropdown.addClass("status-non-aktif");
        tableRow.addClass("table-secondary"); // Abu-abu
    } else {
        // Terapkan Aktif
        $dropdown.addClass("status-aktif"); 
        tableRow.addClass("table-success"); // Hijau
    }

            console.log("Status diubah ke: " + selectedValue);
        });
    });
</script>

@endsection
