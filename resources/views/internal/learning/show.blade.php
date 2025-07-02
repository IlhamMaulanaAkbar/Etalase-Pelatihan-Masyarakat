@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Detail Video Pembelajaran</h5>
                    <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
                        <!-- Dropdown di kiri -->
                        <div class="dropdown dropstart">
                            <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-dots-vertical fs-6"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                        href="{{ route('internal.learning.edit', ['learning' => $learning]) }}">
                                        <i class="fs-4 ti ti-edit"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $learning->id }}').submit();">
                                        <i class="fs-4 ti ti-trash"></i> Delete
                                    </a>
                                    <form id="delete-form-{{ $learning->id }}"
                                        action="{{ route('internal.learning.destroy', $learning) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- Tombol Kembali di kanan -->
                        <a href="{{ route('internal.learning.index') }}" class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="card d-flex flex-column flex-md-row align-items-start gap-3 p-3">
                        <!-- Embed video (ganti thumbnail) -->
                        <div class="me-4">
                            <iframe src="{{ $embedUrl }}" class="w-100"
                                style="max-width: 400px; height: 170px; border-radius: 8px;" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Detail video -->
                        <div class="w-100">
                            <p class="mb-1 fw-semibold text-muted">Nama Video</p>
                            <h6 class="fw-bolder fs-5">{{ $learning->video_name }}</h6>

                            <p class="mt-3 mb-1 fw-semibold text-muted">Tanggal Upload</p>
                            <p class="fw-bolder">{{ $learning->uploaded_at->format('d F Y') }}</p>

                            <p class="mt-3 mb-1 fw-semibold text-muted">Link YouTube</p>
                            <a href="{{ $learning->video_url }}" class="text-decoration-none text-primary fw-semibold"
                                target="_blank">
                                {{ $learning->video_url }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
