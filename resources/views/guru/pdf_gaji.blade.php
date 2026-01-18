<!DOCTYPE html>
<html>

<head>
    <title>Slip Gaji Guru</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        /* Header Layout */
        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        .header-logo {
            width: 80px;
            vertical-align: middle;
        }

        /* Sesuaikan ukuran logo */
        .header-text {
            text-align: left;
            vertical-align: middle;
            padding-left: 15px;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a73e8;
            text-transform: uppercase;
        }

        /* Table Layout mirip Excel/Doc */
        .table-gaji {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table-gaji th,
        .table-gaji td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table-gaji th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Signature Section (Kanan Bawah) */
        .signature-container {
            float: right;
            width: 200px;
            text-align: center;
            margin-top: 20px;
        }

        .signature-date {
            margin-bottom: 5px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            margin: 10px auto;
        }

        /* Utility */
        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <table class="header">
        <tr>
            {{-- Ganti src dengan path logo Anda. Gunakan public_path untuk PDF --}}
            {{-- <td width="10%"><img src="{{ public_path('img\logo.png') }}" class="header-logo" alt="Logo"></td> --}}
            <td class="header-text">
                <div class="header-title">AKADEMI CENDEKIA</div>
                <div>Laporan Rekapitulasi Gaji Guru</div>
            </td>
        </tr>
    </table>

    <h3 style="text-align: center; margin-bottom: 20px;">Slip Gaji Periode
        {{ \Carbon\Carbon::create()->month($dataGaji->month)->translatedFormat('F') }} {{ $dataGaji->year }}</h3>

    {{-- TABEL UTAMA (Sesuai kolom di docx) --}}
    <table class="table-gaji">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama</th>
                <th>Guru Jenjang</th>
                <th>Rekening / Wallet</th>
                <th>Gaji Perjam</th>
                <th>Total Absensi</th>
                <th>Total Gaji</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1.</td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->jenjang ?? '-' }}</td>
                <td>
                    @if (!empty($guru->no_rekening))
                        {{ $guru->rekening }} - {{ $guru->no_rekening }}
                    @elseif(!empty($guru->no_e_wallet))
                        {{ $guru->jenis_e_wallet }} - {{ $guru->no_e_wallet }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($dataGaji->gaji_per_jam_terakhir, 0, ',', '.') }}</td>
                <td class="text-center">
                    {{ round($dataGaji->total_gaji_bulan_ini / ($dataGaji->gaji_per_jam_terakhir > 0 ? $dataGaji->gaji_per_jam_terakhir : 1)) }}
                    
                </td>
                <td class="text-right" style="font-weight: bold;">
                    Rp {{ number_format($dataGaji->total_gaji_bulan_ini, 0, ',', '.') }}
                </td>
                <td class="text-center" style="text-transform: capitalize;">
                    {{ $dataGaji->status_pembayaran }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- BAGIAN TANDA TANGAN (Sesuai posisi di docx) --}}
    <div class="signature-container">
        <div class="signature-date">{{ $tanggalCetak }}</div>
        <div class="signature-title">Pemilik Bimbel</div>

        {{-- Ganti src dengan gambar QR Code Anda --}}
        <img src="{{ public_path('img\tanda_tangan_yoga.png') }}" class="qr-code" alt="QR Signature">

        {{-- <div style="margin-top: 5px;">( _________________ )</div> --}}
    </div>

    <div class="clear"></div>

</body>

</html>
