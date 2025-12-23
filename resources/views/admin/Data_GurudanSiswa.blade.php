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
        data-bs-target="#modalTambahDataGuru"
    >
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="modal fade" id="modalTambahDataGuru" tabindex="-1" aria-labelledby="modalTambahDataGuru" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- dibuat lebih lebar --}}
            <form id="FormSiswa" method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahDataGuru">Tambah Data Guru </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- Hari --}}
                                <div class="mb-3">
                                    <label>Nama Guru</label>
                                    <input type="text" name="nama" id="nama_guru" class="form-control" required>
                                    </div>

                                {{-- Tanggal --}}
                                <div class="mb-3">
                                    <label>Jenjang</label>
                                    <select name="jenjang" id="jenjang_guru" class="form-control" required>
                                        <option selected disabled>Jenjang</option>
                                        <option value="TK">TK</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                    </select>
                                </div>

                                {{-- Waktu --}}
                                <div class="mb-3">
                                    <label>Kelas</label>
                                    <select name="kelas" id="kelas_guru" class="form-control" required>
                                        <option selected disabled>Kelas</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">

                                {{-- Mapel --}}
                                <div class="mb-3">
                                    <label class="form-label">Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah" id="asal_guru" class="form-control"
                                        required>
                                </div>

                                {{-- Bukti Kehadiran --}}
                                <div class="mb-3">
                                    <label class="form-label">No Hp</label>
                                    <input type="text" name="no_hp" id="hp_guru" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
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
                        <i class="bi bi-pencil-square "onclick="editModeGuru({{ json_encode($j) }})"></i>
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
        data-bs-target="#modalTambahDataSiswa"
    >
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="modal fade" id="modalTambahDataSiswa" tabindex="-1" aria-labelledby="modalTambahDataSiswa" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- dibuat lebih lebar --}}
            <form id="FormSiswa" method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="methodSiswa"></div>
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahDataSiswa">Tambah Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- Hari --}}
                                <div class="mb-3">
                                    <label>Nama Siswa</label>
                                    <input type="text" name="nama" id="nama_siswa" class="form-control" required>
                                    </div>

                                {{-- Tanggal --}}
                                <div class="mb-3">
                                    <label>Jenjang</label>
                                    <select name="jenjang" id="jenjang_siswa" class="form-control" required>
                                        <option selected disabled>Jenjang</option>
                                        <option value="TK">TK</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA">SMA</option>
                                    </select>
                                </div>

                                {{-- Waktu --}}
                                <div class="mb-3">
                                    <label>Kelas</label>
                                    <select name="kelas" id="kelas_siswa" class="form-control" required>
                                        <option selected disabled>Kelas</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">

                                {{-- Mapel --}}
                                <div class="mb-3">
                                    <label class="form-label">Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah" id="asal_siswa" class="form-control"
                                        required>
                                </div>

                                {{-- Bukti Kehadiran --}}
                                <div class="mb-3">
                                    <label class="form-label">No Hp</label>
                                    <input type="text" name="no_hp" id="hp_siswa" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
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
                        <i class="bi bi-pencil-square"onclick="editModeSiswa({{ json_encode($j) }})"></i>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
        // --- LOGIC UNTUK DATA GURU ---
        function editModeGuru(data) {
            // 1. Ubah Judul & Action Form
            document.getElementById('modalTambahDataGuru').querySelector('.modal-title').innerText = "Edit Data Guru";
            const form = document.getElementById('formGuru');
            form.action = "/admin/Data_GurudanSiswa/update/" + data.id; // Sesuaikan URL update Anda
            
            // 2. Tambahkan Method PUT (Laravel requirement for update)
            let methodInput = form.querySelector('input[name="_method"]');
            if(!methodInput){
                form.insertAdjacentHTML('afterbegin', '<input type="hidden" name="_method" value="PUT">');
            }

            // 3. Isi Field dengan data dari Database
            document.getElementById('guru_nama').value = data.nama;
            document.getElementById('guru_jenjang').value = data.jenjang;
            document.getElementById('guru_kelas').value = data.kelas;
            document.getElementById('guru_asal').value = data.asal_sekolah;
            document.getElementById('guru_hp').value = data.no_hp;

            // 4. Buka Modal
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahDataGuru'));
            myModal.show();
        }

        // Tambahkan fungsi reset saat klik tombol "Tambah" agar form kosong kembali
        document.querySelector('[data-bs-target="#modalTambahDataGuru"]').addEventListener('click', function() {
            document.getElementById('modalTambahDataGuru').querySelector('.modal-title').innerText = "Tambah Data Guru";
            const form = document.getElementById('formGuru');
            form.reset();
            form.action = "{{ route('absensi.store') }}";
            let methodInput = form.querySelector('input[name="_method"]');
            if(methodInput) methodInput.remove();
    });
</script>

@endsection
