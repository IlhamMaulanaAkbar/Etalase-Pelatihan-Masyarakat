@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Pertanyaan Evaluasi</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.evaluations.instructor-evaluation.index', ['training' => $training->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('internal.evaluations.instructor-evaluation.update', ['training' => $training->id, 'instructor_evaluation' => $question->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Pertanyaan -->
                                <div class="mb-4">
                                    <label for="question" class="form-label fw-semibold">Pertanyaan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border">
                                            <i class="ti ti-calendar-plus fs-6"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" name="question"
                                            id="question" placeholder="Tulis pertanyaan"
                                            value="{{ old('question', $question->question) }}" required>
                                    </div>
                                </div>

                                <!-- Tipe Jawaban -->
                                <div class="mb-4">
                                    <label for="type" class="form-label fw-semibold">Tipe Jawaban</label>
                                    <select class="form-select" name="type" id="typeSelect" required>
                                        <option value="scale"
                                            {{ old('type', $question->type) === 'scale' ? 'selected' : '' }}>Skala</option>
                                        <option value="text"
                                            {{ old('type', $question->type) === 'text' ? 'selected' : '' }}>Isian Bebas
                                        </option>
                                    </select>
                                </div>

                                <!-- Opsi Skala -->
                                <div id="scaleOptions" class="mb-4">
                                    <label class="form-label fw-semibold">Opsi Skala</label>
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="input-group mb-2">
                                            <span class="input-group-text bg-white border">
                                                <i class="ti ti-file-pencil fs-6"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" name="answers[]"
                                                placeholder="Opsi Skala {{ $i + 1 }}"
                                                value="{{ old('answers.' . $i, $answers[$i]->answers ?? '') }}">
                                        </div>
                                    @endfor
                                    <small class="text-muted fst-italic">*Kosongkan jika tipe jawaban adalah Isian
                                        Bebas</small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Perbarui Pertanyaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        const typeSelect = document.getElementById('typeSelect');
        const scaleOptions = document.getElementById('scaleOptions');

        function toggleScaleOptions() {
            scaleOptions.style.display = typeSelect.value === 'scale' ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', toggleScaleOptions);
        typeSelect.addEventListener('change', toggleScaleOptions);
    </script>
@endpush
