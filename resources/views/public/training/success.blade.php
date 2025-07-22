@extends('layouts.base-public')

@section('content')
    <section class="min-vh-100 d-flex justify-content-center align-items-center bg-white py-5">
        <div class="border border-1 rounded p-4" style="max-width: 500px; width: 100%;">
            <div class="text-center">
                {{-- Ilustrasi --}}
                <div class="mb-4">
                    <img src="{{ asset('assets/images/illustrations/good-news.png') }}" alt="success" class="img-fluid"
                        style="max-width: 250px;">
                </div>

                {{-- Judul dan Deskripsi --}}
                <h4 class="text-success fw-semibold">Pendaftaran berhasil</h4>
                <p class="mb-4">
                    Untuk tahapan dan proses selanjutnya, silahkan menunggu informasi/pengumuman lebih lanjut dari panitia
                    pelatihan melalui Email/SMS/WA.
                </p>

                {{-- Countdown --}}
                <p class="text-muted mb-0">Pindah menuju halaman Test Asesmen dalam</p>
                <p class="fw-semibold">
                    <span id="countdown">01:00</span> atau
                    <a id="startTestLink"
                        href="{{ route('public.test-assessment.pre-test.start', ['training' => $training->id]) }}"
                        class="text-decoration-none text-primary fw-semibold">
                        Kerjakan Test Asesmen Sekarang
                    </a>
                </p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let seconds = 60;
            let linkClicked = false;
            const countdownElement = document.getElementById('countdown');
            const testLink = document.getElementById('startTestLink');

            testLink.addEventListener('click', function() {
                linkClicked = true;
            });

            countdownElement.textContent = "01:00";

            const timer = setInterval(function() {
                seconds--;
                const m = String(Math.floor(seconds / 60)).padStart(2, '0');
                const s = String(seconds % 60).padStart(2, '0');
                countdownElement.textContent = `${m}:${s}`;

                if (seconds <= 0) {
                    clearInterval(timer);
                    if (!linkClicked) {
                        window.location.href =
                            "{{ route('public.training.show', ['training' => $training->id]) }}";
                    }
                }
            }, 1000);
        });
    </script>
@endpush
