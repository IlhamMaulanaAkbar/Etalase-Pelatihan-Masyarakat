@extends('layouts.base-public')

@section('content')
    {{-- Header --}}
    <section class="bg-light-primary py-5">
        <div class="container">
            <h4 class="text-black fw-semibold mb-0">Video</h4>
            <p class="text-black-50 mb-0">Rekaman momen dan kegiatan dalam video</p>
        </div>
    </section>

    {{-- Filter Tabs --}}
    <section class="py-4">
        <div class="container">
            <ul class="nav nav-pills gap-2" id="video-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all"
                        type="button" role="tab">All</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="event-tab" data-bs-toggle="pill" data-bs-target="#event" type="button"
                        role="tab">Kegiatan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="open-tab" data-bs-toggle="pill" data-bs-target="#open" type="button"
                        role="tab">Pelatihan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="announce-tab" data-bs-toggle="pill" data-bs-target="#announce"
                        type="button" role="tab">Pendampingan</button>
                </li>
            </ul>
            <hr class="mb-4">

            {{-- Tab Content --}}
            <div class="tab-content" id="video-tabContent">
                {{-- All Videos --}}
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                        @foreach ($learnings as $learning)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm bg-light">
                                    <button type="button" class="p-0 border-0 bg-transparent w-100" data-bs-toggle="modal"
                                        data-bs-target="#videoModal" data-embed-url="{{ $learning->embedUrl }}">
                                        <img src="{{ $learning->thumbnail }}" alt="Thumbnail Video"
                                            class="img-fluid rounded-top" style="cursor: pointer;">
                                    </button>
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-1 text-black">{{ $learning->video_name }}</h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($learning->uploaded_at)->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Other Tabs --}}
                <div class="tab-pane fade" id="event" role="tabpanel">
                    <p class="text-muted">Video kategori Event akan ditampilkan di sini.</p>
                </div>
                <div class="tab-pane fade" id="open" role="tabpanel">
                    <p class="text-muted">Video kategori Pembukaan akan ditampilkan di sini.</p>
                </div>
                <div class="tab-pane fade" id="announce" role="tabpanel">
                    <p class="text-muted">Video kategori Pengumuman akan ditampilkan di sini.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Pagination --}}
    <section class="mb-2">
        <div class="container">
            <div class="mt-4 d-flex justify-content-center">
                {{ $learnings->onEachSide(1)->links() }}
            </div>
        </div>
    </section>

    {{-- Modal Video --}}
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame" src="{{ $learning->embedUrl }}" title="YouTube video" allowfullscreen
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const videoModal = document.getElementById('videoModal');
            const videoFrame = document.getElementById('videoFrame');

            videoModal.addEventListener('show.bs.modal', function(event) {
                const trigger = event.relatedTarget;
                if (!trigger) return;

                const videoUrl = trigger.getAttribute('data-video-url'); // ekspektasi: URL biasa
                const embedUrl = convertToEmbedUrl(videoUrl); // harus jadi embed link
                console.log("Embed URL:", embedUrl); // Pastikan ini muncul

                videoFrame.src = embedUrl;
            });


            videoModal.addEventListener('hidden.bs.modal', function() {
                videoFrame.src = '';
            });
        });
    </script>
@endpush
