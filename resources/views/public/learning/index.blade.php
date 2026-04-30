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
                @foreach ($tabs as $type => $label)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $activeType === $type ? 'active' : '' }}"
                            href="{{ route('public.learning.index', $type === 'all' ? [] : ['type' => $type]) }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <hr class="mb-4">

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                @forelse ($learnings as $learning)
                    @include('public.learning.video-card', ['video' => $learning])
                @empty
                    <div class="col-12 w-100">
                        <div class="d-flex justify-content-center align-items-center py-5 text-center">
                            <p class="mb-0">Belum ada video pada kategori ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Pagination --}}
    @if ($learnings->hasPages())
        <section class="mb-2">
            <div class="container">
                <div class="mt-4 d-flex justify-content-center">
                    {{ $learnings->onEachSide(1)->links() }}
                </div>
            </div>
        </section>
    @endif

    {{-- Modal Video --}}
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame" src="" title="YouTube video" allowfullscreen frameborder="0"
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

                const embedUrl = trigger.getAttribute('data-video-url');
                console.log("Embed URL:", embedUrl);

                videoFrame.src = embedUrl + "?autoplay=1";
            });

            videoModal.addEventListener('hidden.bs.modal', function() {
                videoFrame.src = '';
            });
        });
    </script>
@endpush
