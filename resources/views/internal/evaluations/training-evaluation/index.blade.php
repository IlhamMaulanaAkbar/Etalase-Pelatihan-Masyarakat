@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="mb-3 text-end">
                <a href="{{ route('internal.training.show', ['training' => $training->id]) }}"
                    class="btn btn-primary">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="container py-4">
                        <h5 class="card-title fw-semibold mb-4">Halaman Evaluasi Pelatihan</h5>

                        {{-- Tombol Tambah Pertanyaan --}}
                        <div class="rounded p-4 mb-4 text-center" style="border-style: dashed; border-color: #000; border-width: 2px;">
                            <a href="{{ route('internal.evaluations.training-evaluation.create', ['training' => $training->id]) }}"
                                class="text-decoration-none text-dark fw-semibold d-inline-flex align-items-center gap-2">
                                <i class="ti ti-calendar-plus fs-4"></i> Pertanyaan Evaluasi Baru
                            </a>
                        </div>

                        {{-- Daftar Pertanyaan --}}
                        @forelse($questions as $question)
                            <div
                                class="bg-white rounded-2 border p-3 mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small mb-1">Pertanyaan</div>
                                    <h6 class="fw-semibold mb-0">{{ $question->question }}</h6>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('internal.evaluations.training-evaluation.edit', ['training' => $training->id, 'training_evaluation' => $question->id]) }}"
                                        class="btn btn-dark btn-sm rounded-pill">Edit</a>

                                    <!-- Tombol untuk memunculkan modal -->
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal"
                                        data-action="{{ route('internal.evaluations.training-evaluation.destroy', ['training' => $training->id, 'training_evaluation' => $question->id]) }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- Modal Hapus --}}
                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" id="deleteForm"
                                        action="{{ route('internal.evaluations.training-evaluation.destroy', ['training' => $training->id, 'training_evaluation' => $question->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus pertanyaan ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-primary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">Belum ada pertanyaan ditambahkan.</div>
                        @endforelse

                        {{-- Paginate --}}
                        <div class="mt-4 justify-content-center d-flex">
                            {{ $questions->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = document.getElementById('deleteForm');
            form.setAttribute('action', action);
        });
    </script>
@endpush
