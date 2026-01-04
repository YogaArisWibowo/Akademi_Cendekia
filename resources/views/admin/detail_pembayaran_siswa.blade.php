@extends('layouts.app_admin', ['title' => 'Detail Pembayaran'])

@section('content')

<style>
    .back {
        background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px;
        color: white; font-weight: 500; font-size: large; cursor: pointer;
        display: flex; align-items: center; justify-content: center; margin-bottom: 20px; text-decoration: none;
    }
    .back i { padding-right: 5px; }

    .header-custom-wrapper { margin-top: 20px; margin-bottom: 30px; }
    .profile-info h3 { margin: 0; font-weight: 700; color: #1f2937; }
    
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }

    .pagination-wrapper { display: flex; gap: 10px; justify-content: center; margin-top: 20px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Pembayaran_Siswa') }}" style="text-decoration: none;">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

<div class="header-custom-wrapper">
    <div class="profile-info">
        <h3>Riwayat Pembayaran: {{ $siswa->nama }}</h3>
        <p class="text-muted">Kelas {{ $siswa->kelas }} / {{ $siswa->jenjang }}</p>
    </div>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas/Jenjang</th>
                <th>Nama Orang Tua</th>
                <th>Nominal</th>
                <th>Bukti</th>
            </tr>
        </thead>

        <tbody>
            @forelse($riwayat as $key => $item)
            <tr>
                <td>{{ $riwayat->firstItem() + $key }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d-m-Y') }}</td>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->kelas }} / {{ $siswa->jenjang }}</td>
                <td>{{ $item->nama_orangtua }}</td>
                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>
                    @if($item->bukti_pembayaran)
                        <a href="{{ asset('bukti_absensi/' . $item->bukti_pembayaran) }}" target="_blank"><u>Lihat Detail</u></a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">Belum ada data pembayaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrapper">
        {{ $riwayat->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection