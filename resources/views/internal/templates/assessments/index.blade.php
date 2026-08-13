@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">{{ $meta['title'] }}</h5>

                    <form method="GET" class="row g-3 align-items-end mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Kategori Pelatihan</label>
                            <select name="category_id" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                            <a href="{{ route('internal.templates.assessments.index', ['templateType' => $templateType]) }}"
                                class="btn btn-outline-primary w-100">Reset</a>
                        </div>
                    </form>

                    <div class="rounded p-4 mb-4 text-center"
                        style="border-style: dashed; border-color: #000; border-width: 2px;">
                        <a href="{{ route('internal.templates.assessments.create', ['templateType' => $templateType, 'category_id' => $categoryId]) }}"
                            class="text-decoration-none text-dark fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="ti ti-calendar-plus fs-4"></i> Pertanyaan Template Baru
                        </a>
                    </div>

                    @forelse ($questions as $question)
                        @php
                            $correctAnswer = $question->answers->firstWhere('is_correct', true);
                        @endphp
                        <div class="bg-white rounded-2 border p-3 mb-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                <div>
                                    <div class="text-muted small mb-1">{{ $question->category->name }}</div>
                                    <h6 class="fw-semibold mb-1">{{ $question->question }}</h6>
                                    @if ($meta['answer_mode'] === 'choice')
                                        <div class="text-muted small">
                                            Jawaban benar: {{ $correctAnswer?->answer ?? '-' }}
                                        </div>
                                    @else
                                        <div class="text-muted small">
                                            Tipe: {{ $question->question_type === 'text' ? 'Isian Bebas' : 'Skala' }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('internal.templates.assessments.edit', ['templateType' => $templateType, 'question' => $question->id]) }}"
                                        class="btn btn-dark btn-sm rounded-pill">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-action="{{ route('internal.templates.assessments.destroy', ['templateType' => $templateType, 'question' => $question->id]) }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info mb-0">
                            Belum ada template pertanyaan pada kategori ini.
                        </div>
                    @endforelse

                    <div class="mt-4 justify-content-center d-flex">
                        {{ $questions->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus template pertanyaan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('deleteModal')?.addEventListener('show.bs.modal', function(event) {
            document.getElementById('deleteForm').setAttribute('action', event.relatedTarget.dataset.action);
        });
    </script>
@endpush
