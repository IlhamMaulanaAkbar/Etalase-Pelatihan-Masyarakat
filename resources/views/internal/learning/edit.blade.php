@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Video Pembelajaran</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.learning.index') }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.learning.update', ['learning' => $learning]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="video_name" class="form-label">Judul Video</label>
                                    <input type="text" class="form-control" id="video_name" name="video_name"
                                        value="{{ old('video_name', $learning->video_name ?? '') }}">
                                    @error('video_name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="uploaded_at" class="form-label">Diupload Tanggal</label>
                                    <input type="date" class="form-control" id="uploaded_at" name="uploaded_at"
                                        value="{{ old('uploaded_at', $learning->uploaded_at->format('Y-m-d')) }}">
                                    @error('uploaded_at')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="video_url" class="form-label">Link Video Youtube</label>
                                    <input type="url" class="form-control" id="video_url" name="video_url"
                                        value="{{ old('video_url', $learning->video_url) }}">
                                    @error('video_url')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
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
