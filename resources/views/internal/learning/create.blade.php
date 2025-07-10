@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Tambah Video Pembelajaran</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.learning.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.learning.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="video_name" class="form-label">Judul Video</label>
                                    <input type="text" class="form-control" id="video_name" name="video_name"
                                        value="{{ old('video_name') }}">
                                    @error('video_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="uploaded_at" class="form-label">Diupload Tanggal</label>
                                    <input type="date" class="form-control" id="uploaded_at" name="uploaded_at"
                                        value="{{ old('uploaded_at') }}">
                                    @error('uploaded_at')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Tipe Video</label>
                                    <select class="form-select" id="type" name="type">
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="umum" {{ old('type') == 'umum' ? 'selected' : '' }}>Umum</option>
                                        <option value="pelatihan" {{ old('type') == 'pelatihan' ? 'selected' : '' }}>
                                            Pelatihan</option>
                                        <option value="pendampingan" {{ old('type') == 'pendampingan' ? 'selected' : '' }}>
                                            Pendampingan</option>
                                        <option value="pengumuman" {{ old('type') == 'pengumuman' ? 'selected' : '' }}>
                                            Pengumuman</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="video_url" class="form-label">Link Video Youtube</label>
                                    <input type="url" class="form-control" id="video_url" name="video_url"
                                        value="{{ old('video_url') }}">
                                    @error('video_url')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
