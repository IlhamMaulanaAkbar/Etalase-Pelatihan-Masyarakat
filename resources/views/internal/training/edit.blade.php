@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Pelatihan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.training.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.training.update', $training->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3">
                                        @if ($training->thumbnail_image)
                                            <div class="mb-3">
                                                <small>Thumbnail saat ini:</small><br>
                                                <img src="{{ asset('storage/' . $training->thumbnail_image) }}"
                                                    alt="Thumbnail" style="max-width: 200px;">
                                            </div>
                                        @endif
                                        <label for="thumbnail_image" class="form-label">Gambar Thumbnail
                                        </label>
                                        <input type="file" class="form-control" id="thumbnail_image"
                                            name="thumbnail_image" accept="image/*">
                                        @error('thumbnail_image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="training_name" class="form-label">Nama Pelatihan</label>
                                        <input type="text" class="form-control" id="training_name" name="training_name"
                                            value="{{ old('training_name', $training->training_name) }}">
                                        @error('training_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Kategori Pelatihan</label>
                                            <select name="category_id" id="category_id" class="form-select">
                                                <option value="" disabled>-- Pilih Kategori --</option>
                                                @foreach ($categorys as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $training->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ old('start_date', $training->start_date->format('Y-m-d')) }}">
                                            @error('start_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                value="{{ old('end_date', $training->end_date->format('Y-m-d')) }}">
                                            @error('end_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status Pelatihan</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="BUKA"
                                                    {{ old('status', $training->status) == 'BUKA' ? 'selected' : '' }}>Buka
                                                </option>
                                                <option value="TUTUP"
                                                    {{ old('status', $training->status) == 'TUTUP' ? 'selected' : '' }}>
                                                    Tutup</option>
                                                <option value="SELESAI"
                                                    {{ old('status', $training->status) == 'SELESAI' ? 'selected' : '' }}>
                                                    Selesai</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Lokasi Pelatihan</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                                value="{{ old('location', $training->location) }}">
                                            @error('location')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="target_audience" class="form-label">Target Peserta</label>
                                            <input type="text" class="form-control" id="target_audience"
                                                name="target_audience"
                                                value="{{ old('target_audience', $training->target_audience) }}">
                                            @error('target_audience')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deadline_date" class="form-label">Tanggal Berakhir
                                            Pendaftaran</label>
                                        <input type="date" class="form-control" id="deadline_date" name="deadline_date"
                                            value="{{ old('deadline_date', $training->deadline_date->format('Y-m-d')) }}">
                                        @error('deadline_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi Pelatihan</label>
                                        <textarea name="description" id="summernote" class="d-none">{{ old('description', $training->description) }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
