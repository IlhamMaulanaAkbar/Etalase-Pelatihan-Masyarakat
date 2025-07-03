@extends('layouts.base-public')

@section('content')
    <section class="bg-white">
        <div class="container py-5">

            {{-- Header --}}
            <div class="bg-primary text-white p-4 rounded mb-4">
                <h2 class="fw-bolder text-white mt-2">{{ $training->training_name }}</h2>
                <p>{{ $training->category->name }}</p>

                <div class="row g-3">
                    <div class="col-md-4 d-flex align-items-center">
                        <div>
                            <div class="fw-semibold">Tgl. Pelatihan</div>
                            <div><i class="ti ti-calendar-event me-2 fs-4"></i>{{ $training->start_date->format('d M Y') }} -
                                {{ $training->end_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div>
                            <div class="fw-semibold">Lokasi</div>
                            <div><i class="ti ti-map-pin me-2 fs-4"></i>{{ $training->location }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div>
                            <div class="fw-semibold">Alur Seleksi</div>
                            <div><i class="ti ti-recycle me-2 fs-4"></i>Administrasi</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Informasi Utama --}}
                <div class="col-lg-8">
                    <ul class="nav nav-tabs mb-3" id="detailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                type="button" role="tab">Informasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="silabus-tab" data-bs-toggle="tab" data-bs-target="#silabus"
                                type="button" role="tab">Silabus</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="peserta-tab" data-bs-toggle="tab" data-bs-target="#peserta"
                                type="button" role="tab">Peserta</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="detailTabsContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3 social-user pb-3">
                                        <i class="ti ti-world fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Lokasi</div>
                                            <div>{{ $training->location }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center social-user gap-3">
                                        <i class="ti ti-user fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Kuota Peserta</div>
                                            <div>{{ $training->target_audience }} Orang</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center social-user gap-3">
                                        <i class="ti ti-cloud-download fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Silabus</div>
                                            <a href="#" class="text-decoration-none">Download</a>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center social-user gap-3  pt-3">
                                        <i class="ti ti-circle-check fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Sertifikat</div>
                                            <div>BPPMDDTT Banjarmasin</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <hr>

                            <h5 class="fw-bold">Deskripsi</h5>
                            <p>{!! $training->description !!}</p>
                        </div>

                        <div class="tab-pane fade" id="silabus" role="tabpanel">
                            <p>Silabus akan ditampilkan di sini.</p>
                        </div>

                        <div class="tab-pane fade" id="peserta" role="tabpanel">
                            <p>Data peserta akan ditampilkan di sini.</p>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold d-block">Batas Pendaftaran</div>
                                <h5 class="fw-bolder text-black">{{ $training->deadline_date->format('d M Y') }}</h5>
                            </div>
                            <span class="badge bg-success rounded-pill px-4 py-2 fs-2">{{ $training->status }}</span>
                        </div>
                        <div class="mt-2">
                            <form method="POST" action="">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold py-2 fs-5">
                                    Daftar
                                </button>
                            </form>
                        </div>
                        <hr>
                        <div class="p-3 mt-3">
                            <ul class="list-unstyled">

                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-recycle me-2"></i> Alur Seleksi <span
                                        class="ms-auto text-muted">Administrasi</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-user me-2"></i> Kuota <span
                                        class="ms-auto text-muted">{{ $training->target_audience }}
                                        orang</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-circle-check me-2"></i>
                                    <div class="d-flex w-100 align-items-center">
                                        <div class="flex-grow-1">Sertifikasi</div>
                                        <div class="text-muted text-end" style="max-width: 55%; word-break: break-word;">
                                            BPPMDDTT Banjarmasin
                                        </div>
                                    </div>

                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-map-pin me-2"></i>
                                    <div class="d-flex w-100 align-items-center">
                                        <div class="flex-grow-1">Lokasi Pelatihan</div>
                                        <div class="text-muted text-end" style="max-width: 55%; word-break: break-word;">
                                            {{ $training->location }}
                                        </div>
                                    </div>
                                </li>


                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-calendar-event me-2"></i> Waktu Tes Asesmen <span
                                        class="ms-auto text-muted">02 Februari 2023</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-calendar-event me-2"></i> Tgl. Mulai Pelatihan <span
                                        class="ms-auto text-muted">{{ $training->start_date->format('d M Y') }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-calendar-event me-2"></i> Tgl. Selesai Pelatihan <span
                                        class="ms-auto text-muted">{{ $training->end_date->format('d M Y') }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-cloud-download me-2"></i> Silabus <a href="#"
                                        class="ms-auto text-primary fw-semibold text-decoration-none">Download</a>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-eye me-2"></i> Dilihat sebanyak <span
                                        class="ms-auto text-muted">{{ $training->views }}</span>
                                </li>
                            </ul>
                            <div class="mt-3 text-center border-bottom pb-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#shareModal"
                                    data-id="{{ $training->id }}">
                                    <i class="ti ti-share me-1"></i> Bagikan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title">Bagikan pelatihan ini!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="input-group mb-3">
                        <input type="text" id="shareLink" class="form-control" readonly>
                        <button class="btn btn-primary" id="copyBtn">
                            <i class="ti ti-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("shareModal");
            const shareInput = document.getElementById("shareLink");
            const fbShare = document.getElementById("fbShare");
            const twitterShare = document.getElementById("twitterShare");
            const emailShare = document.getElementById("emailShare");

            modal.addEventListener('show.bs.modal', function(e) {
                const button = e.relatedTarget;
                const id = button.getAttribute("data-id");
                const baseUrl = "{{ url('/pelatihan') }}";
                const shareUrl = `${baseUrl}/${id}`;
                shareInput.value = shareUrl;
                fbShare.href =
                    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`;
                twitterShare.href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}`;
                emailShare.href = `mailto:?body=${encodeURIComponent(shareUrl)}`;
            });

            document.getElementById("copyBtn").addEventListener("click", function() {
                shareInput.select();
                document.execCommand("copy");
                this.innerHTML = '<i class="ti ti-check"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="ti ti-link"></i>';
                }, 1500);
            });
        });
    </script>
@endpush
