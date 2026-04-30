@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Jadwal Pelatihan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.schedules.training.index', ['training' => $training->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('internal.schedules.training.update', ['training' => $training->id, 'schedule' => $schedule->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="training_id" value="{{ $training->id }}">

                                <div class="mb-3">
                                    <label for="meeting_number" class="form-label">Pertemuan Ke</label>
                                    <input type="number" class="form-control" id="meeting_number" name="meeting_number"
                                        required value="{{ old('meeting_number', $schedule->meeting_number) }}" min="1">
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="date" name="date" required
                                        value="{{ old('date', $schedule->date->format('Y-m-d')) }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_time" class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" required
                                            value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_time" class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" required
                                            value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="material_title" class="form-label">Judul Materi</label>
                                    <input type="text" class="form-control" id="material_title" name="material_title"
                                        required value="{{ old('material_title', $schedule->material_title) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="material_description" class="form-label">Deskripsi Materi</label>
                                    <textarea class="form-control" id="material_description" name="material_description" rows="4">{{ old('material_description', $schedule->material_description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="speaker_name" class="form-label">Nama Narasumber</label>
                                    <input type="text" class="form-control" id="speaker_name" name="speaker_name" required
                                        value="{{ old('speaker_name', $schedule->speaker_name) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="file" class="form-label">File Materi</label>
                                    <input type="file" class="form-control" id="file" name="file"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx,.xlsx">
                                    @error('file')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                    @if ($schedule->file)
                                        <small class="text-muted d-block mt-1">
                                            File saat ini:
                                            <a href="{{ asset('storage/' . $schedule->file) }}" target="_blank">Lihat File</a>
                                        </small>
                                    @endif
                                    <small class="text-muted d-block mt-1">Format: PDF, DOC, DOCX, PPT, PPTX, XLSX. Maksimal 10MB.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="duration" class="form-label">Durasi Pelajaran</label>
                                    <input type="number" class="form-control" id="duration" name="duration"
                                        value="{{ old('duration', $schedule->duration) }}"
                                        placeholder="Masukkan durasi dalam JP">
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
