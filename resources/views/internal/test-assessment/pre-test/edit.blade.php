@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Pertanyaan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.test-assessment.pre-test.index', ['training' => $training->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('internal.test-assessment.pre-test.update', ['training' => $training->id, 'pre_test' => $question->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="training_id" value="{{ $training->id }}">

                                <!-- Pertanyaan -->
                                <div class="mb-4">
                                    <label for="question" class="form-label fw-semibold">Pertanyaan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border">
                                            <i class="ti ti-calendar-plus fs-6"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" name="question"
                                            id="question" placeholder="Tulis pertanyaan anda" required
                                            value="{{ old('question', $question->question) }}">
                                    </div>
                                </div>

                                <!-- Jawaban -->
                                <label class="form-label fw-semibold">Jawaban</label>

                                @foreach ($question->answers as $index => $answer)
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border">
                                            <i class="ti ti-file-pencil fs-6"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0"
                                            name="answers[{{ $index }}][text]" placeholder="Tulis pilihan jawaban"
                                            value="{{ old("answers.$index.text", $answer->answer) }}" required>

                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="radio" name="correct_answer"
                                                value="{{ $index }}" {{ $answer->is_correct ? 'checked' : '' }}>
                                            <span class="ms-2">Benar</span>
                                        </div>
                                    </div>
                                @endforeach

                                <small class="fst-normal">*Pilih salah satu jawaban yang benar</small>

                                <button type="submit" class="btn btn-primary w-100 mt-4">Update Pertanyaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
