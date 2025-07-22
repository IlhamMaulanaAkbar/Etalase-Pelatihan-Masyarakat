@extends('layouts.base-public')

@section('content')
    <main>
        <section class="container py-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Ilustrasi -->
                        <div class="col-md-6 text-center">
                            <h5 class="mt-3 fw-semibold">Evaluasi - Instruktur {{ $training->id }}</h5>
                            <img src="{{ asset('assets/images/illustrations/mobile-computer.png') }}" alt="Quiz Illustration"
                                class="img-fluid" style="max-height: 300px;">
                        </div>

                        <!-- Panduan -->
                        <div class="col-md-6">
                            <div class="bg-light-primary p-5 rounded border">
                                <p class="fw-semibold mb-2"><strong>Yth. Bapak / Ibu</strong></p>
                                <p class="mb-2" style="text-align: justify;">
                                    Kami dari <strong>Balai Pelatihan dan Pemberdayaan Masyarakat Desa, Daerah Tertinggal
                                        dan Transmigrasi Banjarmasin</strong> melakukan Evaluasi Pelatihan guna mengetahui
                                    sejauh mana pelatihan ini bermanfaat, serta menjadi bahan perbaikan dan peningkatan
                                    kualitas pelatihan di masa mendatang.
                                </p>
                                <p class="mb-3" style="text-align: justify;">
                                    Kami mengharapkan Bapak / Ibu untuk berpartisipasi dalam mengisi lembar kuisioner ini
                                    dengan menjawab pertanyaan yang ada pada form ini.
                                </p>
                                <p class="mb-3" style="text-align: justify;">
                                    Atas perhatian dan partisipasi Bapak / Ibu, kami mengucapkan terima kasih.
                                </p>
                                

                                <!-- Tombol Mulai -->
                                <a href="{{ route('public.evaluations.instructor.ongoing', ['training' => $training->id]) }}"
                                    class="btn btn-primary w-100 rounded-pill">
                                    ▶ MULAI EVALUASI INSTRUKTUR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
