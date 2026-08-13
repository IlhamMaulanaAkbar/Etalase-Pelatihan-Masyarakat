@if ($paginator->hasPages())
    <div class="d-flex justify-content-center justify-content-md-end align-items-center gap-4 flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted">Rows per page:</span>
            <select class="form-select form-select-sm w-auto" disabled>
                <option selected>{{ $paginator->perPage() }}</option>
            </select>
        </div>

        <div class="text-muted small">
            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}
            of {{ $paginator->total() }}
        </div>

        <div class="d-flex gap-3 align-items-center">
            @if ($paginator->onFirstPage())
                <span class="text-muted fs-5"><i class="ti ti-chevron-left"></i></span>
            @else
                <a href="{{ $paginator->appends($appends ?? [])->previousPageUrl() }}" class="pagination-link fs-5">
                    <i class="ti ti-chevron-left"></i>
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->appends($appends ?? [])->nextPageUrl() }}" class="pagination-link fs-5">
                    <i class="ti ti-chevron-right"></i>
                </a>
            @else
                <span class="text-muted fs-5"><i class="ti ti-chevron-right"></i></span>
            @endif
        </div>
    </div>
@endif
