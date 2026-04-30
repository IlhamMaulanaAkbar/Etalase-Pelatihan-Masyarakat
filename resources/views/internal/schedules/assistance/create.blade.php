@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Tambah Materi Pendampingan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.schedules.assistance.index', ['assistance' => $assistance->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.schedules.assistance.store', ['assistance' => $assistance->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assistance_id" value="{{ $assistance->id }}">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Materi Pendampingan</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        value="{{ old('name') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">File Materi Pendampingan</label>
                                    <input type="file" class="form-control" id="file" name="file" required
                                        value="{{ old('file') }}" accept='.pdf,.docx,.pptx, .xlsx'>
                                </div>
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Durasi Pelajaran</label>
                                    <input type="number" class="form-control" id="duration" name="duration" required
                                        value="{{ old('duration') }}" placeholder="Masukkan durasi dalam jam">
                                    <span>
                                        <p class="text-muted fs-1">Contoh : 1 Jam Pelajaran</p>
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
