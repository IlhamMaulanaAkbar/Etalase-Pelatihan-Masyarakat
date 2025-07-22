@extends('layouts.base-public')

@section('content')
    <section class="bg-white py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0 fw-semibold">Soal Evaluasi</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <p class="mb-3" style="text-align: justify;">
                    Indikator Penilaian:
                    Sangat Buruk (1), Buruk (2), Biasa (3), Baik (4), Sangat Baik (5)
                </p>
            </div>

            <form action="{{ route('public.evaluations.instructor.submit', ['training' => $training->id]) }}" method="POST">
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

                                @if ($question->type == 'scale')
                                    <div class="d-flex flex-column">
                                        @foreach ($question->answers as $index => $answer)
                                            <div class="form-check">
                                                <input class="form-check-input answer-option" type="radio"
                                                    name="answers[{{ $question->id }}]"
                                                    id="q{{ $question->id }}_{{ $answer->id }}"
                                                    value="{{ $index + 1 }}" data-question-id="{{ $question->id }}">
                                                {{-- Kirim 1 sampai 5 --}}
                                                <label class="form-check-label"
                                                    for="q{{ $question->id }}_{{ $answer->id }}">
                                                    {{ $answer->answers }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($question->type == 'text')
                                    <textarea name="answers[{{ $question->id }}]" class="form-control text-answer" rows="3"
                                        data-question-id="{{ $question->id }}"></textarea>
                                @endif

                            </div>
                        @endforeach

                        <!-- Navigasi Bawah -->
                        <div class="d-flex justify-content-between align-items-center mt-4" id="navigationRow">
                            <div id="prevContainer">
                                <button type="button" class="btn btn-outline-secondary d-none" id="prevBtn"><i
                                        class="ti ti-chevron-left"></i>
                                    Sebelumnya</button>
                            </div>
                            <div class="d-flex" id="nextContainer">
                                <button type="button" class="btn btn-outline-secondary" id="nextBtn">Selanjutnya
                                    <i class="ti ti-chevron-right"></i></button>
                                <div class="text-end" id="submitWrapper" data-bs-toggle="tooltip" data-bs-placement="left">
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
            document.querySelectorAll('.answer-option, .text-answer').forEach(input => {
                const eventType = input.tagName.toLowerCase() === 'textarea' ? 'input' : 'change';
                input.addEventListener(eventType, () => {
                    const questionId = input.dataset.questionId;
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
                let allAnswered = true;
                questions.forEach(q => {
                    const questionId = q.querySelector('[data-question-id]').dataset.questionId;
                    const type = q.querySelector('.text-answer') ? 'text' : 'scale';
                    if (type === 'text') {
                        const textarea = q.querySelector('textarea');
                        if (textarea.value.trim() === '') {
                            allAnswered = false;
                        }
                    } else {
                        const radios = q.querySelectorAll('input[type="radio"]');
                        if (![...radios].some(r => r.checked)) {
                            allAnswered = false;
                        }
                    }
                });

                if (allAnswered) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove("disabled");
                    submitWrapper.removeAttribute("data-bs-toggle");
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add("disabled");
                    submitWrapper.setAttribute("data-bs-toggle", "tooltip");
                }
            }

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
