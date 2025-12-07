@extends('layouts.app_siswa', ['title' => 'Pembayaran Bimbel'])

@section('content')

<div class="pembayaran-header d-flex align-items-center justify-content-end mb-3">
    <div class="right-head">
        <a href="#" class="btn-add d-inline-flex align-items-center ">
            <span>Tambah</span>
            <i class="ri-add-line ms-2"></i>
        </a>
    </div>
</div>



<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pembayaran</th>
                <th>Nama Ortu</th>
                <th>Nominal</th>
                <th class="text-center">Bukti Pembayaran</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1.</td>
                <td>Senin, 05–Okt–2025</td>
                <td>Ira S</td>
                <td>500.000</td>
                <td class="text-center"><a href="">Lihat</a></td>
            </tr>

            <tr>
                <td>1.</td>
                <td>Senin, 05–Okt–2025</td>
                <td>Ira S</td>
                <td>500.000</td>
                <td class="text-center"><a href="">Lihat</a></td>
            </tr>

            <tr>
                <td>1.</td>
                <td>Senin, 05–Okt–2025</td>
                <td>Ira S</td>
                <td>500.000</td>
                <td class="text-center"><a href="">Lihat</a></td>
            </tr>

        </tbody>
    </table>

    <div class="pagination-wrapper">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page active">Selanjutnya</button>
    </div>

</div>

@endsection
