<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat Pelatihan</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            font-family: 'Georgia', serif;
            background: url('{{ public_path('storage/certificates/template-certificate.jpg') }}') no-repeat center center;
            background-size: cover;
        }

        .container {
            padding: 100px 100px;
            text-align: center;
        }

        .title {
            font-size: 35px;
            font-weight: bold;
            color: #1A2940;
            letter-spacing: 2px;
        }

        .number {
            font-size: 17px;
            margin-top: 8px;
            color: #333;
        }

        .subtitle {
            margin-top: 30px;
            font-size: 16px;
            color: #000;
        }

        .name {
            font-size: 32px;
            margin: 10px 0;
            font-family: 'Brush Script MT', cursive;
            font-weight: bold;
            color: #1A2940;
        }

        .description {
            font-size: 14px;
            margin: 20px auto;
            max-width: 700px;
            line-height: 1.5;
            color: #333;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            margin-right: 80px;
        }

        .signature p {
            margin: 4px 0;
            font-size: 14px;
        }

        .signature-line {
            border: none;
            border-top: 1px solid #000;
            width: 300px;
            margin: 0 auto;

        }

        .qr {
            float: right;
            margin-top: -90px;
            margin-left: 80px;
        }

        .qr img {
            width: 90px;
        }

        .logo {
            text-align: center;
            margin-top: 20px; 
            margin-bottom: 20px;
        }

        .logo img {
            width: 70px;
            height: auto;
            /* margin-left: 25px; */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ public_path('assets/images/logos/logo.png') }}" alt="Logo">
        </div>
        {{-- <div class="description">
            <p>BALAI PELATIHAN DAN PEMBERDAYAAN MASYARAKAT DESA, DAERAH TERTINGGAL, DAN TRANSMIGRASI BANJARMASIN</p>
        </div> --}}
        <div class="title">SERTIFIKAT PELATIHAN</div>
        <div class="number">Nomor : {{ $certificate->certificate_number }}</div>

        <div class="subtitle">DIBERIKAN KEPADA :</div>
        <div class="name">{{ $user->name }}</div>
        <hr class="signature-line">

        <div class="description">
            @php
                use Carbon\Carbon;
                Carbon::setLocale('id');
            @endphp
            Atas Partisipasinya dalam mengikuti {{ $training->training_name ?? 'Pelatihan' }} di
            {{ $training->location ?? 'Balai Pelatihan dan Pemberdayaan Masyarakat Desa, Daerah Tertinggal dan Transmigrasi Banjarmasin' }}
            terhitung mulai dari Tanggal
            {{ ($training->start_date)->translatedFormat('d F Y') }}
            sampai dengan {{ ($training->end_date)->translatedFormat('d F Y') }}.
        </div>

        <div class="signature">
            <p>Banjarmasin, {{ Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>{{ $certificate->leadership_position }},</p>
            <br><br>
            <br><br>
            <br>
            <div class="qr">
                <img src="{{ public_path('storage/' . $certificate->signature_file) }}" alt="QR Code">
            </div>
            <p><strong>{{ $certificate->name_of_leader }}</strong></p>
            <p>NIP. {{ $certificate->identity_number }}</p>
        </div>
    </div>
</body>

</html>
