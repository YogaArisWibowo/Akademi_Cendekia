@extends('layouts.app_guru', ['title' => 'Gaji Guru'])
@section('content')
    <div class="absensi-header d-flex align-items-center justify-content-between mb-3">
        <div class="left-head d-flex align-items-center gap-3">
            <div class="filter-row d-flex align-items-center">
                {{-- Form Filter Bulan --}}
                <form action="{{ route('gaji_guru') }}" method="GET" class="d-flex align-items-center">
                    <div class="position-relative d-flex align-items-center">

                        {{-- PERBAIKAN DI SINI: --}}
                        {{-- 1. z-index: 10 (Supaya dia di layer paling atas) --}}
                        {{-- 2. position: relative (Supaya z-index jalan) --}}
                        {{-- 3. background-color: #fff (Supaya jelas areanya) --}}

                        <select name="bulan" class="filter-button" onchange="this.form.submit()"
                            style="appearance: none; 
                       -webkit-appearance: none; 
                       padding-right: 30px; 
                       cursor: pointer; 
                       background-color: #fff; 
                       border: 1px solid #ccc; 
                       border-radius: 8px; 
                       padding: 8px 12px;
                       position: relative;
                       z-index: 10;">
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>

                        {{-- Icon tetap di z-index rendah dan pointer-events: none --}}
                        <i class="ri-arrow-down-s-line position-absolute"
                            style="right: 10px; pointer-events: none; z-index: 1;"></i>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="table-general">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Guru Jenjang</th>
                    <th>Rekening / Wallet</th>
                    <th>Gaji Perjam</th>
                    <th>Total Absensi Perbulan</th>
                    <th>Total Gaji</th>
                    <th>Status</th>
                    <th>Unduh Slip Gaji</th>
                </tr>
            </thead>

            <tbody>
                @forelse($riwayatGaji as $key => $gaji)
                    <tr>
                        <td>{{ $riwayatGaji->firstItem() + $key }}.</td>

                        <td style="font-weight: 500;">{{ $guru->nama }}</td>

                        <td>{{ $guru->jenjang ?? '-' }}</td>

                        <td>
                            @if (!empty($guru->no_rekening))
                                <div class="d-flex flex-column">
                                    <span style="font-size: 11px; color: #888;">{{ $guru->rekening ?? 'Bank' }}</span>
                                    <span>{{ $guru->no_rekening }}</span>
                                </div>
                            @elseif(!empty($guru->no_e_wallet))
                                <div class="d-flex flex-column">
                                    <span style="font-size: 11px; color: #888;">{{ $guru->jenis_e_wallet }}</span>
                                    <span>{{ $guru->no_e_wallet }}</span>
                                </div>
                            @else
                                -
                            @endif
                        </td>

                        <td>Rp {{ number_format($gaji->gaji_per_jam_terakhir, 0, ',', '.') }}</td>

                        <td>
                            <div class="d-flex flex-column justify-content-center">
                                {{-- LOGIKA MATEMATIKA: Total Gaji dibagi Gaji Per Jam --}}
                                <span style="font-weight: bold; font-size: 16px; color: #2c3e50;">
                                    @if ($gaji->gaji_per_jam_terakhir > 0)
                                        {{ round($gaji->total_gaji_bulan_ini / $gaji->gaji_per_jam_terakhir) }}
                                    @else
                                        0
                                    @endif
                                </span>
                                <span style="font-size: 11px; color: #888;">Kehadiran</span>
                            </div>
                        </td>

                        <td style="font-weight: bold;">
                            Rp {{ number_format($gaji->total_gaji_bulan_ini, 0, ',', '.') }}
                        </td>

                        <td>
                            {{-- TAMPILKAN LANGSUNG DARI DATABASE --}}
                            <span class="badge badge-hadir" style="text-transform: capitalize;">
                                {{ $gaji->status_pembayaran ?? 'Belum Dibayar' }}
                            </span>
                        </td>

                        {{-- KOLOM BARU: BUTTON DOWNLOAD --}}
                        <td>
                            <a href="{{ route('gaji_guru.download', ['year' => $gaji->year, 'month' => $gaji->month]) }}"
                                class="btn btn-sm btn-danger d-flex align-items-center justify-content-center gap-1"
                                target="_blank"
                                style="text-decoration: none; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                                <i class="ri-file-pdf-line"></i> Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada riwayat gaji.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($riwayatGaji->hasPages())
            <div class="pagination-wrapper mt-3">
                {{ $riwayatGaji->links() }}
            </div>
        @endif
    </div>
@endsection
