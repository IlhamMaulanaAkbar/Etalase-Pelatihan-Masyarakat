@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Tambah Pendampingan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.assistance.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.assistance.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="assistance_name" class="form-label">Nama Pendampingan</label>
                                        <input type="text" class="form-control" id="assistance_name"
                                            name="assistance_name" value="{{ old('assistance_name') }}">
                                        @error('assistance_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="training_id" class="form-label">Dari Pelatihan</label>
                                            <select name="training_id" id="training_id" class="form-select select2">
                                                <option value="" disabled selected>-- Pilih Pelatihan --</option>
                                                @foreach ($trainings as $training)
                                                    <option value="{{ $training->id }}"
                                                        {{ old('training_id') == $training->id ? 'selected' : '' }}>
                                                        {{ $training->training_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('training_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ old('start_date') }}">
                                            @error('start_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                value="{{ old('end_date') }}">
                                            @error('end_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="deadline_date" class="form-label">Tanggal
                                                Berakhir Pendaftaran</label>
                                            <input type="date" class="form-control" id="deadline_date"
                                                name="deadline_date" value="{{ old('deadline_date') }}">
                                            @error('deadline_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status Pelatihan</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="" disabled selected>-- Pilih Status --</option>
                                                <option value="BUKA" {{ old('status') == 'BUKA' ? 'selected' : '' }}>Buka
                                                </option>
                                                <option value="TUTUP" {{ old('status') == 'TUTUP' ? 'selected' : '' }}>
                                                    Tutup</option>
                                                <option value="SELESAI" {{ old('status') == 'SELESAI' ? 'selected' : '' }}>
                                                    Selesai</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Lokasi Pendampingan</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                                value="{{ old('location') }}">
                                            @error('location')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="target_audience" class="form-label">Target Peserta</label>
                                            <input type="text" class="form-control" id="target_audience"
                                                name="target_audience" value="{{ old('target_audience') }}">
                                            @error('target_audience')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="thumbnail_image" class="form-label">Gambar Thumbnail</label>
                                            <input type="file" class="form-control" id="thumbnail_image"
                                                name="thumbnail_image" accept="image/*">
                                            @error('thumbnail_image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi Pendampingan</label>
                                        <textarea name="description" id="summernote" class="d-none">{{ old('description') }}</textarea>

                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
