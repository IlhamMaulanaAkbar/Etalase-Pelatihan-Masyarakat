@extends('layouts.base-public')

@section('content')
    <main>
        <section class="container py-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Ilustrasi -->
                        <div class="col-md-6 text-center">
                            <h5 class="mt-3 fw-semibold">Test Asesmen (Pre-Test) - Pelatihan {{ $training->id }}</h5>
                            <img src="{{ asset('assets/images/illustrations/mobile-computer.png') }}" alt="Quiz Illustration"
                                class="img-fluid" style="max-height: 300px;">
                        </div>

                        <!-- Panduan -->
                        <div class="col-md-6">
                            <div class="bg-light-primary p-5 rounded border">
                                <h6 class="fw-semibold mb-2">Panduan:</h6>
                                <p class="mb-2">Sebelum Mengerjakan, harap membaca panduan berikut:</p>
                                <ol class="mb-3 list-item">
                                    <li class="mb-2 ps-3">Pastikan koneksi internet stabil dan disarankan menggunakan
                                        browser versi terbaru.
                                    </li>
                                    <li class="mb-2 ps-3">Peserta wajib menjawab seluruh soal Tes Asesmen sesuai dengan tema
                                        pelatihan.</li>
                                    <li class="mb-2 ps-3">Setelah tes dimulai, waktu tidak dapat dihentikan dan tes tidak
                                        dapat diulang.</li>
                                </ol>
                                <p>Skor untuk soal yang sudah dijawab tetap terhitung walaupun peserta belum menekan
                                    tombol submit atau mengalami force majeure.</p>

                                <!-- Tombol Mulai -->
                                <a href="{{ route('public.test-assessment.pre-test.ongoing', ['training' => $training->id]) }}"
                                    class="btn btn-primary w-100 rounded-pill">
                                    ▶ MULAI TES ASESMEN
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
