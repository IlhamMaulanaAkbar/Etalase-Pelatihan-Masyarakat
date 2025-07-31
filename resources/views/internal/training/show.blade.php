@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Detail Pelatihan</h5>
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
                                        href="{{ route('internal.training.edit', ['training' => $training]) }}">
                                        <i class="fs-4 ti ti-edit"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center gap-3"
                                        data-bs-toggle="modal" data-bs-target="#deleteTrainingModal{{ $training->id }}">
                                        <i class="fs-4 ti ti-trash"></i> Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Tombol Kembali di kanan -->
                        <div class="d-flex flex-wrap gap-6">
                            <!-- Example single danger button -->
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-success dropdown-toggle text-white d-flex align-items-center"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-square-plus fs-4 me-2"></i>Tambah
                                </button>
                                <ul class="dropdown-menu animated flipInX">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('internal.test-assessment.pre-test.index', ['training' => $training->id]) }}">Pre
                                            Test</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('internal.test-assessment.post-test.index', ['training' => $training->id]) }}">Post
                                            Test</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('internal.evaluations.training-evaluation.index', ['training' => $training->id]) }}">Evaluasi
                                            Pelatihan</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('internal.evaluations.instructor-evaluation.index', ['training' => $training->id]) }}">Evaluasi
                                            Instruktur</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('internal.lessons.training.index', ['training' => $training->id]) }}">Materi
                                            Pelatihan</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('internal.certificates.index', ['training' => $training->id]) }}">Sertifikat
                                            Pelatihan</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ route('internal.training.index') }}" class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Thumbnail:</label><br>
                                    @if ($training->thumbnail_image)
                                        <img src="{{ asset('storage/' . $training->thumbnail_image) }}" alt="Thumbnail"
                                            class="img-fluid" style="max-width: 200px;">
                                    @else
                                        <p>-</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pelatihan</label>
                                        <p>{{ $training->training_name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Mulai</label>
                                        <p>{{ $training->start_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Selesai</label>
                                        <p>{{ $training->end_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Berakhir Pendaftaran</label>
                                        <p>{{ $training->deadline_date->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kategori Pelatihan</label>
                                        <p>{{ $training->category->name ?? '-' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Pelatihan</label>
                                        <p>{{ $training->status }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lokasi Pelatihan</label>
                                        <p>{{ $training->location }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Target Peserta</label>
                                        <p>{{ $training->target_audience }}</p>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi Pelatihan</label>
                                    <div>{!! $training->description !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="deleteTrainingModal{{ $training->id }}" tabindex="-1"
                aria-labelledby="deleteTrainingModalLabel{{ $training->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title w-100 text-center text-white" id="deleteTrainingModalLabel{{ $training->id }}">
                                Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body text-center">
                            Apakah Anda yakin ingin menghapus pelatihan ini?
                            <br><strong>"{{ $training->training_name }}"</strong>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <form id="delete-form-{{ $training->id }}"
                                action="{{ route('internal.training.destroy', $training) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
