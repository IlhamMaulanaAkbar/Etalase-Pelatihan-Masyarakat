<!DOCTYPE html>
<html>

<head>
    <title>Laporan Total Pengguna</title>
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
            table-layout: fixed;
            /* Penting agar lebar kolom konsisten */
            word-wrap: break-word;
            /* Supaya teks panjang membungkus */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            padding: 4px;
            /* Lebih kecil agar muat */
            font-size: 9px;
            /* Diperkecil agar muat semua */
        }

        th {
            background-color: #f2f2f2;
            white-space: normal; /* Izinkan wrap */
        }

        /* .page-break {
            page-break-before: always;
        } */

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

    <h3 class="title">Laporan Total Pengguna</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No. Handphone</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Provinsi</th>
                <th>Kota/Kab</th>
                <th>Kecamatan</th>
                <th>Desa/Kelurahan</th>
                <th>Pekerjaan</th>
                <th>Tingkat Pendidikan Terakhir</th>
                <th>Institusi Pendidikan</th>
                <th>Total Pelatihan Diikuti</th>
                <th>Total Pendampingan Diikuti</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;
                Carbon::setLocale('id');
            @endphp

            @foreach ($users as $index => $user)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->phone }}
                    </td>
                    <td>
                        {{ $user->place_of_birth }}
                    </td>
                    <td>{{ Carbon::parse($user->date_of_birth)->translatedFormat('d F Y') }}</td>
                    <td>
                        {{ $user->gender }}
                    </td>
                    <td>
                        {{ $user->religion }}
                    </td>
                    <td>
                        {{ $user->nusaProvince?->name ?? '-' }}
                    </td>
                    <td>
                        {{ $user->nusaRegency?->name ?? '-' }}
                    </td>
                    <td>
                        {{ $user->nusaDistrict?->name ?? '-' }}
                    </td>
                    <td>
                        {{ $user->nusaVillage?->name ?? '-' }}
                    </td>
                    <td>
                        {{ $user->job }}
                    </td>
                    <td>
                        {{ $user->education }}
                    </td>
                    <td>
                        {{ $user->education_institutions }}
                    </td>
                    <td>
                        {{ $user->training_users->count() }} Pelatihan
                    </td>
                    <td>
                        {{ $user->assistance_users->count() }} Pendampingan
                    </td>
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
