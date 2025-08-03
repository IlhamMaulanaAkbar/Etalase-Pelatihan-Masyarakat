@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Materi Pendampingan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.lessons.assistance.index', ['assistance' => $assistance->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('internal.lessons.assistance.update', ['assistance' => $assistance->id, 'lesson' => $lesson->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="assistance_id" value="{{ $assistance->id }}">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Materi Pendampingan</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="{{ old('name', $lesson->name) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="file" class="form-label">File Materi Pendampingan</label>
                                    <input type="file" class="form-control" id="file" name="file"
                                        accept=".pdf,.docx,.pptx,.xlsx">
                                    @if ($lesson->file)
                                        <small class="text-muted d-block mt-1">
                                            File saat ini:
                                            <a href="{{ asset('storage/' . $lesson->file) }}" target="_blank">Lihat File</a>
                                        </small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="duration" class="form-label">Durasi Pelajaran</label>
                                    <input type="number" class="form-control" id="duration" name="duration" required
                                        value="{{ old('duration', $lesson->duration) }}"
                                        placeholder="Masukkan durasi dalam jam">
                                    <small class="text-muted d-block mt-1">Contoh: 1 Jam Pelajaran</small>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
