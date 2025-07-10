<div class="col">
    <div class="h-100 border-0 rounded overflow-hidden">
        <button type="button" class="p-0 border-0 bg-transparent w-100" data-bs-toggle="modal" data-bs-target="#videoModal"
            data-video-url="{{ $video->video_url }}">
            <div class="position-relative overflow-hidden rounded-top" style="aspect-ratio: 16 / 9;">
                <img src="{{ $video->thumbnail }}" alt="Thumbnail Video"
                    class="img-fluid w-100 h-100 object-fit-cover rounded" style="cursor: pointer;">
            </div>
        </button>
        <div class="py-3 px-3">
            <h6 class="fw-semibold mb-1 text-black">{{ $video->video_name }}</h6>
            <div class="d-flex text-muted small gap-3 mt-1">
                <div><i class="ti ti-calendar-event me-1"></i>{{ $video->uploaded_at->format('d F Y') }}</div>
                <div><i class="ti ti-eye me-1"></i>{{ $video->views }} Views</div>
            </div>
        </div>
    </div>
</div>
