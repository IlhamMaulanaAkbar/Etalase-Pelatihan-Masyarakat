@extends('layouts.base-public')

@include('public.test-assessment.partials.ongoing-styles')

@section('content')
    <section class="bg-white py-5 assessment-page">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 assessment-header">
                <h5 class="mb-0 fw-semibold assessment-title">Soal Tes Asesmen Post Test</h5>
                <span class="badge bg-light text-danger border border-danger px-3 py-2 assessment-timer"
                    id="countdown">00m:00s</span>
            </div>

            <form action="{{ route('public.test-assessment.post-test.submit', ['training' => $training->id]) }}"
                method="POST" id="assessmentForm">
                @csrf

                <div class="row border-top pt-4 assessment-content">
                    <!-- Navigasi Soal -->
                    <div class="col-md-3 pe-4 assessment-nav-panel">
                        <div class="assessment-question-grid">
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
                    <div class="col-md-9 ps-4 assessment-question-panel">
                        @foreach ($questions as $index => $question)
                            <div class="question-block mb-4 {{ $loop->first ? '' : 'd-none' }}"
                                data-question-index="{{ $loop->index }}">
                                <p class="fw-semibold assessment-question-text">{{ $loop->iteration }}.
                                    {{ $question->question }}</p>

                                @foreach ($question->answers as $answer)
                                    <div class="form-check mb-2 assessment-answer">
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
                        <div class="d-flex justify-content-between align-items-center mt-4 assessment-actions"
                            id="navigationRow">
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
    @include('public.test-assessment.partials.ongoing-script', [
        'storageKey' => 'assessment:post-test:' . auth('user')->id() . ':' . $training->id,
        'durationSeconds' => 15 * 60,
    ])
@endpush
