<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pelatihan</title>
    <style>
        @page {
            margin: 30px 30px 20px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            float: left;
            width: 80px;
            height: auto;
            margin-top: 15px;
            margin-left: 25px;
        }

        .header h1,
        .header h2,
        .header p {
            margin: 0;
            text-align: center;
            line-height: 1.3;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header .clear {
            clear: both;
        }

        h3.title {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-before: always;
        }

        .signature-section {
            width: 100%;
            margin-top: 20px;
        }

        .signature-box {
            float: right;
            width: 200px;
            text-align: left;
            margin-right: 20px;
            font-size: 12px;
        }

        .signature-box img.qr {
            width: 80px;
            margin: 5px 0;
        }

        .signed-note {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: left;
            font-style: italic;
            font-size: 11px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <img src="{{ public_path('assets/images/logos/logo.png') }}" alt="Logo">
        <div style="margin-left: 0px;">
            <h1>KEMENTERIAN DESA, PEMBANGUNAN DAERAH TERTINGGAL DAN TRANSMIGRASI RI</h1>
            <h1>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAN PEMBERDAYAAN MASYARAKAT</h1>
            <h2>BALAI PELATIHAN DAN PEMBERDAYAAN MASYARAKAT</h2>
            <h2>DESA, DAERAH TERTINGGAL, DAN TRANSMIGRASI BANJARMASIN</h2>
            <p>Jalan Handil Bhakti KM.9,5 No. 95 Banjarmasin Kalimantan Selatan, 70582 Telp.08115000344</p>
            <p><a href="https://www.kemendesa.go.id">www.kemendesa.go.id</a></p>
        </div>
        <div class="clear"></div>
    </div>

    <h3 class="title">Laporan Pelatihan</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelatihan</th>
                <th>Kategori Pelatihan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Tgl. Berakhir Pendaftaran</th>
                <th>Status Pelatihan</th>
                <th>Lokasi Pelatihan</th>
                <th>Target Peserta</th>
                <th>Total Pendaftar</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;
                Carbon::setLocale('id');
            @endphp

            @foreach ($trainings as $index => $training)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $training->training_name }}</td>
                    <td>{{ $training->category->name ?? '-' }}</td>
                    <td>{{ Carbon::parse($training->start_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ Carbon::parse($training->end_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ Carbon::parse($training->deadline_date)->translatedFormat('d F Y') }}</td>
                    <td>{{ strtoupper($training->status) }}</td>
                    <td>{{ $training->location }}</td>
                    <td>{{ $training->target_audience }} Orang</td>
                    <td>{{ $training->training_users_count }} Orang</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SIGNATURE --}}
    <div class="page-break"></div> {{-- Pisahkan halaman jika tabel terlalu panjang --}}
    <div class="signature-section">
        <div class="signature-box">
            Kepala Balai PPMDDTT Banjarmasin,<br>
            <img src="{{ public_path('assets/images/logos/image.png') }}" class="qr" alt="QR Code"><br>
            <strong>Ahmad Syahir, S.H.I., M.H</strong><br>
            <span>NIP. 197806022011011012</span>
        </div>
        <div class="signed-note">
            Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik.
        </div>
    </div>

</body>

</html>
