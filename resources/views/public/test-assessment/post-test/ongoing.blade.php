@extends('layouts.base-public')

@section('content')
    <section class="bg-white py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-semibold">Soal Tes Asesmen Post Test</h5>
                <span class="badge bg-light text-danger border border-danger px-3 py-2" id="countdown">00m:00s</span>
            </div>

            <form action="{{ route('public.test-assessment.post-test.submit', ['training' => $training->id]) }}"
                method="POST">
                @csrf

                <div class="row border-top pt-4">
                    <!-- Navigasi Soal -->
                    <div class="col-md-3 border-end pe-4">
                        <div class="d-grid gap-2" style="grid-template-columns: repeat(5, 1fr); display: grid;">
                            @foreach ($questions as $index => $question)
                                <button type="button"
                                    class="btn btn-outline-secondary nav-button {{ $loop->first ? 'btn-dark text-white' : '' }}"
                                    data-index="{{ $loop->index }}" data-question-id="{{ $question->id }}">
                                    {{ $loop->iteration }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Konten Soal -->
                    <div class="col-md-9 ps-4">
                        @foreach ($questions as $index => $question)
                            <div class="question-block mb-4 {{ $loop->first ? '' : 'd-none' }}"
                                data-question-index="{{ $loop->index }}">
                                <p class="fw-semibold text-black">{{ $loop->iteration }}. {{ $question->question }}</p>

                                @foreach ($question->answers as $answer)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input answer-option" type="radio"
                                            name="answers[{{ $question->id }}]"
                                            id="q{{ $question->id }}_{{ $answer->id }}" value="{{ $answer->answer }}"
                                            data-question-id="{{ $question->id }}">
                                        <label class="form-check-label" for="q{{ $question->id }}_{{ $answer->id }}">
                                            {{ $answer->answer }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <!-- Navigasi Bawah -->
                        <div class="d-flex justify-content-between align-items-center mt-4" id="navigationRow">
                            <div id="prevContainer">
                                <button type="button" class="btn btn-outline-secondary d-none" id="prevBtn"><i
                                        class="ti ti-chevron-left"></i>
                                    Sebelumnya</button>
                            </div>
                            <div class="d-flex gap-2" id="nextContainer">
                                <button type="button" class="btn btn-outline-secondary" id="nextBtn">Selanjutnya
                                    <i class="ti ti-chevron-right"></i></button>
                                <div class="text-end mt-4" id="submitWrapper" data-bs-toggle="tooltip"
                                    data-bs-placement="left">
                                    <button type="submit" class="btn btn-secondary disabled" id="submitBtn" disabled>
                                        Selesaikan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" id="hiddenSubmitBtn" class="d-none"></button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentIndex = 0;
            const questions = document.querySelectorAll(".question-block");
            const navButtons = document.querySelectorAll(".nav-button");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const submitBtn = document.getElementById("submitBtn");
            const submitWrapper = document.getElementById("submitWrapper");

            const totalQuestions = questions.length;

            function updateView(index) {
                questions.forEach((q, i) => {
                    q.classList.toggle("d-none", i !== index);
                });

                navButtons.forEach((btn, i) => {
                    btn.classList.toggle("btn-dark", i === index);
                    btn.classList.toggle("text-white", i === index);
                    btn.classList.toggle("btn-outline-white", i !== index);
                });

                prevBtn.classList.toggle("d-none", index === 0);
                nextBtn.classList.toggle("d-none", index === totalQuestions - 1);

                // Kontrol visibilitas tombol submit
                if (index === totalQuestions - 1) {
                    submitWrapper.classList.remove("d-none");
                } else {
                    submitWrapper.classList.add("d-none");
                }
            }

            navButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    currentIndex = parseInt(btn.dataset.index);
                    updateView(currentIndex);
                });
            });

            prevBtn.addEventListener("click", () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateView(currentIndex);
                }
            });

            nextBtn.addEventListener("click", () => {
                if (currentIndex < totalQuestions - 1) {
                    currentIndex++;
                    updateView(currentIndex);
                }
            });

            // Update warna tombol navigasi jika dijawab
            document.querySelectorAll('.form-check-input').forEach(input => {
                input.addEventListener("change", () => {
                    const questionId = input.name.match(/\d+/)[0];
                    const btn = document.querySelector(
                        `.nav-button[data-question-id="${questionId}"]`);
                    if (btn) {
                        btn.classList.remove("btn-outline-secondary");
                        btn.classList.add("btn-muted");
                    }
                    checkAllAnswered();
                });
            });

            function checkAllAnswered() {
                const answered = new Set();
                document.querySelectorAll('.form-check-input:checked').forEach(input => {
                    const name = input.name;
                    answered.add(name);
                });

                if (answered.size === totalQuestions) {
                    // Semua soal dijawab
                    submitBtn.disabled = false;
                    submitBtn.classList.remove("disabled");
                    submitWrapper.removeAttribute("data-bs-toggle");
                    submitWrapper.removeAttribute("data-bs-placement");
                    submitWrapper.removeAttribute("title");

                    const tooltip = bootstrap.Tooltip.getInstance(submitWrapper);
                    if (tooltip) tooltip.dispose();
                } else {
                    // Belum semua dijawab
                    submitBtn.disabled = true;
                    submitBtn.classList.add("disabled");
                    submitWrapper.setAttribute("data-bs-toggle", "tooltip");
                    submitWrapper.setAttribute("data-bs-placement", "left");
                    submitWrapper.setAttribute("title", "Pastikan semua jawaban telah terisi.");

                    new bootstrap.Tooltip(submitWrapper);
                }
            }
            // Countdown 30 menit
            const countdownElement = document.getElementById('countdown');
            let duration = 1 * 60; // detik

            const timerInterval = setInterval(() => {
                const minutes = Math.floor(duration / 60);
                const seconds = duration % 60;
                countdownElement.textContent =
                    `${minutes.toString().padStart(2, '0')}m:${seconds.toString().padStart(2, '0')}s`;

                if (--duration < 0) {
                    clearInterval(timerInterval);
                    document.getElementById("hiddenSubmitBtn").click();
                }
            }, 1000);

            // Init pertama
            updateView(currentIndex);
            checkAllAnswered();

            // Inisialisasi tooltip secara global
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(el) {
                return new bootstrap.Tooltip(el);
            });

            setInterval(() => {
                fetch("{{ url('/keep-alive') }}", {
                    method: "GET",
                    credentials: "same-origin"
                });
            }, 60000); // 60 detik
        });
    </script>
@endpush
