@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Detail Pendampingan</h5>
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
                                        href="{{ route('internal.assistance.edit', ['assistance' => $assistance]) }}">
                                        <i class="fs-4 ti ti-edit"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item d-flex align-items-center gap-3"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $assistance->id }}').submit();">
                                        <i class="fs-4 ti ti-trash"></i> Delete
                                    </a>
                                    <form id="delete-form-{{ $assistance->id }}"
                                        action="{{ route('internal.assistance.destroy', $assistance) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('internal.training.index') }}" class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Thumbnail:</label><br>
                                    @if ($assistance->thumbnail_image)
                                        <img src="{{ asset('storage/' . $assistance->thumbnail_image) }}" alt="Thumbnail"
                                            class="img-fluid" style="max-width: 200px;">
                                    @else
                                        <p>-</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pendampingan</label>
                                        <p>{{ $assistance->assistance_name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Mulai</label>
                                        <p>{{ $assistance->start_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Selesai</label>
                                        <p>{{ $assistance->end_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Berakhir Pendaftaran</label>
                                        <p>{{ $assistance->deadline_date->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Dari Pelatihan</label>
                                        <p>{{ $assistance->training->training_name ?? '-' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Pelatihan</label>
                                        <p>{{ $assistance->status }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lokasi Pelatihan</label>
                                        <p>{{ $assistance->location }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Target Peserta</label>
                                        <p>{{ $assistance->target_audience }}</p>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi Pendampingan</label>
                                    <div>{!! $assistance->description !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
