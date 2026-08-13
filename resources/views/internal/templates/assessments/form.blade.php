<div class="mb-4">
    <label class="form-label fw-semibold">Kategori Pelatihan</label>
    <select name="category_id" class="form-select" required>
        <option value="">Pilih Kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected((string) old('category_id', $selectedCategoryId ?? $question?->category_id) === (string) $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">Pertanyaan</label>
    <div class="input-group">
        <span class="input-group-text bg-white border">
            <i class="ti ti-calendar-plus fs-6"></i>
        </span>
        <input type="text" class="form-control border-start-0" name="question"
            placeholder="Tulis pertanyaan anda" required value="{{ old('question', $question?->question) }}">
    </div>
    @error('question')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

@if ($meta['answer_mode'] === 'choice')
    <label class="form-label fw-semibold">Jawaban</label>
    @php
        $answers = old('answers')
            ? collect(old('answers'))->pluck('text')->all()
            : ($question?->answers?->pluck('answer')->all() ?? []);
        $correctIndex = old('correct_answer');
        if ($correctIndex === null && $question) {
            $correctIndex = $question->answers->values()->search(fn($answer) => $answer->is_correct);
        }
    @endphp

    @for ($i = 0; $i < 4; $i++)
        <div class="input-group mb-3">
            <span class="input-group-text bg-white border">
                <i class="ti ti-file-pencil fs-6"></i>
            </span>
            <input type="text" class="form-control border-start-0" name="answers[{{ $i }}][text]"
                placeholder="Tulis pilihan jawaban" required value="{{ $answers[$i] ?? '' }}">

            <div class="input-group-text">
                <input class="form-check-input mt-0" type="radio" name="correct_answer" value="{{ $i }}"
                    required @checked((string) $correctIndex === (string) $i)>
                <span class="ms-2">Benar</span>
            </div>
        </div>
    @endfor
    <small class="fst-normal">*Pilih salah satu jawaban yang benar</small>
@else
    <div class="mb-4">
        <label class="form-label fw-semibold">Tipe Jawaban</label>
        <select class="form-select" name="question_type" id="typeSelect" required>
            <option value="scale" @selected(old('question_type', $question?->question_type ?? 'scale') === 'scale')>Skala</option>
            <option value="text" @selected(old('question_type', $question?->question_type) === 'text')>Isian Bebas</option>
        </select>
    </div>

    <div id="scaleOptions" class="mb-4">
        <label class="form-label fw-semibold">Opsi Skala</label>
        @php
            $scaleAnswers = old('answers') ?? ($question?->answers?->pluck('answer')->all() ?? []);
        @endphp
        @for ($i = 0; $i < 5; $i++)
            <div class="input-group mb-2">
                <span class="input-group-text bg-white border">
                    <i class="ti ti-file-pencil fs-6"></i>
                </span>
                <input type="text" class="form-control border-start-0 scale-answer-input" name="answers[]"
                    placeholder="Opsi Skala {{ $i + 1 }}"
                    value="{{ $scaleAnswers[$i] ?? '' }}">
            </div>
        @endfor
        <small class="text-muted fst-italic">*Isi jika tipe jawaban adalah Skala</small>
    </div>
@endif

@if ($meta['answer_mode'] === 'evaluation')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('typeSelect');
                const scaleOptions = document.getElementById('scaleOptions');
                const scaleInputs = scaleOptions?.querySelectorAll('input') ?? [];

                function toggleScaleOptions() {
                    const isScale = typeSelect.value === 'scale';
                    scaleOptions.style.display = isScale ? 'block' : 'none';
                    scaleInputs.forEach(input => input.disabled = !isScale);
                }

                toggleScaleOptions();
                typeSelect.addEventListener('change', toggleScaleOptions);
            });
        </script>
    @endpush
@endif
