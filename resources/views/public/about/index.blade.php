@extends('layouts.base-public')

@section('content')
    {{-- Section Header --}}
    <section class="bg-light-primary py-5">
        <div class="container">
            <h5 class="text-black fw-semibold mb-0">Tentang</h5>
            <h4 class="text-black fw-semibold mb-0">Etalase Pelatihan Masyarakat</h4>
        </div>
    </section>

    {{-- Section Content --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                {{-- Kiri: Teks --}}
                <div class="col-lg-6 text-black">
                    <p class="mb-3" style="text-align: justify;">
                        <strong>E-LATMAS</strong>, atau Etalase Pelatihan Masyarakat, adalah sistem informasi pelatihan yang
                        diselenggarakan oleh Balai Pelatihan dan Pemberdayaan Masyarakat Desa, Daerah Tertinggal, dan
                        Transmigrasi Banjarmasin.
                    </p>
                    <p class="mb-3" style="text-align: justify;">
                        E-LATMAS sebagai <strong><em>One Stop Layanan Pelatihan</em></strong> mempublikasikan informasi
                        seperti jenis
                        pelatihan, jadwal dan tempat pelaksanaan, target peserta, dan syarat pendaftaran. Selain itu,
                        masyarakat dapat melakukan pendaftaran secara online.
                    </p>
                    <p class="mb-3" style="text-align: justify;">
                        Informasi pelatihan yang dipublikasikan adalah pelatihan yang diselenggarakan oleh BPPMDDTT
                        Banjarmasin
                        di wilayah kerja Balai yang meliputi Provinsi Kalimantan Selatan, Provinsi Kalimantan Tengah,
                        Provinsi Kalimantan Timur, dan Provinsi Kalimantan Utara.
                    </p>
                    <p class="mb-0" style="text-align: justify;">
                        E-LATMAS bertujuan untuk memberikan kemudahan kepada masyarakat untuk memperoleh informasi terkait
                        pelatihan yang diselenggarakan oleh BPPMDDTT Banjarmasin.
                    </p>
                </div>

                {{-- Kanan: Gambar --}}
                <div class="col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('assets/images/illustrations/neutral-info.png') }}" alt="Ilustrasi" class="img-fluid"
                        style="max-height: 380px;">
                </div>
            </div>
        </div>
    </section>
@endsection
