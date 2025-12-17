@extends('layouts.app_siswa', ['title' => 'Jadwal Bimbel'])

@section('content')
    <div class="table-container">
        <table class="table-general">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Mapel</th>
                    <th>Nama Guru</th>
                    <th>Nama Siswa</th>
                    <th>Alamat Siswa</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($jadwal as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ optional($item->created_at)->format('d-M-Y') }}</td>
                        <td>{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                        <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $item->guru->nama ?? '-' }}</td>
                        <td>{{ $item->siswa->nama ?? '-' }}</td>
                        <td>{{ $item->alamat_siswa }}</td>
                    </tr>
                @endforeach
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
