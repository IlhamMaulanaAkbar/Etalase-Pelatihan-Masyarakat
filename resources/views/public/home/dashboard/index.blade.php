@extends('layouts.base-public')

@section('content')
    <section class="bg-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- KIRI: Teks -->
                <div class="col-lg-6 text-center text-lg-start ps-lg-7">
                    <p class="text-black fw-semibold mb-2">#E-LATMAS</p>
                    <h1 class="fw-bolder text-primary display-5 mb-3">Etalase Pelatihan Masyarakat</h1>
                    <p class="text-black fs-3 mb-4 pe-lg-5">
                        Selamat Datang di Website Etalase Pelatihan Masyarakat (E–LATMAS) oleh Balai Pelatihan dan
                        Pemberdayaan Masyarakat Desa, Daerah Tertinggal, dan Transmigrasi Banjarmasin
                    </p>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="{{ route('public.about.index') }}"
                            class="btn btn-outline-primary px-4 py-2 fw-semibold">Tentang Kami</a>
                    </div>
                </div>
                <!-- KANAN: Ilustrasi -->
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <img src="{{ asset('assets/images/products/search.png') }}" alt="Ilustrasi" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container py-5">
            <h4 class="text-black mb-4 fw-semibold">Pilihan Layanan</h4>
            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-start p-0 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="assets/images/logos/thumbnail.png" class="img-fluid w-100" alt="AI Engineer">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-1">Pelatihan</h6>
                            <p class="card-text small mb-2">Temukan berbagai pelatihan berkualitas yang sesuai dengan
                                kebutuhan Anda.</p>
                            <a href="{{ route('public.training.index') }}"
                                class="btn btn-outline-primary w-100">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-start p-0 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="assets/images/logos/thumbnail.png" class="img-fluid w-100" alt="AI Engineer">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-1">Pendampingan</h6>
                            <p class="card-text small mb-2">Temukan berbagai pendampingan untuk mendukung perkembangan Anda.
                            </p>
                            <a href="#" class="btn btn-outline-primary w-100">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-start p-0 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="assets/images/logos/thumbnail.png" class="img-fluid w-100" alt="AI Engineer">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-1">Pembelajaran</h6>
                            <p class="card-text small mb-2">Temukan berbagai materi pembelajaran untuk memperluas wawasan
                                Anda.</p>
                            <a href="{{ route('public.learning.index') }}"
                                class="btn btn-outline-primary w-100">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-semibold text-white">Pelatihan Terbaru</h4>
                    <p class="mb-0">Ayo, ikuti pelatihan menarik yang dapat meningkatkan keterampilan kamu. Belajar jadi
                        lebih asyik dan praktis.</p>
                </div>
                <a href="{{ route('public.training.index') }}"
                    class="text-white fw-semibold text-decoration-none d-flex align-items-center">
                    Lihat Semua <i class="ti ti-chevron-right"></i>
                </a>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <!-- Card -->
                @foreach ($trainings as $training)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 rounded-4 overflow-hidden">
                            <img src="{{ asset('storage/' . $training->thumbnail_image) }}" class="card-img-top"
                                alt="gambar-pelatihan">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <small class="text-muted d-block mb-2">Pelatihan</small>
                                    <div class="fw-semibold small mb-2">
                                        <a href="{{ route('public.training.show', ['training' => $training]) }}"
                                            class="fw-semibold text-dark text-decoration-none hover-underline">{{ str($training->training_name)->limit(50) }}</a>

                                    </div>
                                </div>
                                <div class="text-muted small"><i class="ti ti-calendar-event"></i><span
                                        class="ms-1">{{ $training->start_date->format('d M Y') }}
                                        - {{ $training->end_date->format('d M Y') }}</span></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5 bg-light-primary">
        <div class="container">
            <div class="row align-items-center">
                {{-- Kolom Kiri: Judul dan tombol --}}
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="fw-bolder text-primary display-6 mb-3">Kembangkan diri dengan <br>E-LATMAS sekarang </h1>
                    <p class="text-muted mb-4 pe-lg-5">
                        Berikut adalah data E-LATMAS (Etalase Pelatihan Masyarakat) <br>
                        Balai Pemberdayaan dan Pemberdayaan
                        Masyarakat Desa, Daerah Tertinggal, dan Transmigrasi Banjarmasin
                    </p>
                    <a href="{{ route('public.training.index') }}" class="btn btn-primary px-4 py-2 fw-semibold"
                        onmouseover="this.classList.replace('btn-primary', 'btn-outline-primary')"
                        onmouseout="this.classList.replace('btn-outline-primary', 'btn-primary')">
                        Yuk Ikuti Kegiatan
                    </a>


                </div>

                {{-- Kolom Kanan: Statistik --}}
                <div class="col-lg-6">
                    <div class="row g-3">
                        {{-- Card 1 --}}
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
                                    <div>
                                        <small class="text-muted">Pelatihan</small>
                                        <h4 class="fw-bolder text-primary mb-0">{{ $totalTrainings }}</h4>
                                    </div>
                                    <i class="ti ti-chalkboard text-muted fs-2"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Card 2 --}}
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
                                    <div>
                                        <small class="text-muted">Pendampingan</small>
                                        <h4 class="fw-bolder text-primary mb-0">{{ $totalAssistances}}</h4>
                                    </div>
                                    <i class="ti ti-chalkboard text-muted fs-2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
                                    <div>
                                        <small class="text-muted">Peserta</small>
                                        <h4 class="fw-bolder text-primary mb-0 ">{{ $totalUsers }}</h4>
                                    </div>
                                    <i class="ti ti-users text-muted fs-2"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Card 3 --}}
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
                                    <div>
                                        <small class="text-muted">Video</small>
                                        <h4 class="fw-bolder text-primary mb-0">{{ $totalLearnings }}</h4>
                                    </div>
                                    <i class="ti ti-brand-youtube text-muted fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div> {{-- row --}}
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <small class="text-primary mb-3">Tanya E-LATMAS</small>
            <h4 class="text-black mb-3 fw-semibold">Pertanyaan Umum</h4>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Bagaimana cara mengetahui jadwal pelatihan yang tersedia?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            1. Jadwal pelatihan dapat diakses secara mandiri melalui website <br>
                            2. klik menu pelatihan pada halaman depan website <br>
                            3. klik menu sortir untuk mengetahui waktu dan jenis judul pelatihan <br>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Apa saja persyaratan untuk mengikuti pelatihan?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            1. Persyaratan dapat dilihat pada menu jadwal pelatihan.<br>
                            2. Setelah masuk ke dalam jadwal pelatihan, pilih pelatihan yang ingin di ikuti dan klik. <br>
                            3. Persyaratan akan muncul dan mohon dibaca dengan teliti. <br>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            Bagaimana cara mendaftar untuk mengikuti pelatihan?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            1. Klik menu pelatihan pada halaman depan website <br>
                            2. Pilih dan klik jadwal pelatihan yang di inginkan <br>
                            3. Baca dan pahami persyaratannya <br>
                            4. Klik tombol daftar pada pojok kanan <br>
                            5. Isi formulir yang terbuka dan klik daftar/submit <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
