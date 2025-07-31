@if ($acceptedParticipants->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="fs-2 fw-semibold mb-0">No</th>
                    <th class="fs-2 fw-semibold mb-0">No. Registrasi</th>
                    <th class="fs-2 fw-semibold mb-0">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($acceptedParticipants as $index => $participant)
                    <tr>
                        <td>
                            <p class="fs-2 fw-normal">{{ $index + 1 }}</p>
                        </td>
                        <td>
                            <p class="fs-2 fw-normal">{{ $participant->registration_number ?? 'N/A' }}
                            </p>
                        </td>
                        <td>
                            <span class="fs-2 fw-normal">DITERIMA</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end justify-content-center justify-content-md-end align-items-center gap-4 flex-wrap">
        {{-- Dropdown rows per page --}}
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted">Rows per page:</span>
            <select id="rowsPerPage" class="form-select form-select-sm w-auto">
                @foreach ([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Info jumlah halaman --}}
        <div class="text-muted small">
            {{ $acceptedParticipants->firstItem() }} – {{ $acceptedParticipants->lastItem() }}
            of {{ $acceptedParticipants->total() }}
        </div>

        <div class="d-flex gap-3 align-items-center">
            @if ($acceptedParticipants->onFirstPage())
                <span class="text-muted">❮</span>
            @else
                <a href="{{ $acceptedParticipants->previousPageUrl() }}" class="pagination-link">❮</a>
            @endif

            @if ($acceptedParticipants->hasMorePages())
                <a href="{{ $acceptedParticipants->nextPageUrl() }}" class="pagination-link">❯</a>
            @else
                <span class="text-muted">❯</span>
            @endif
        </div>
    </div>
@else
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="fs-2 fw-semibold mb-0">No</th>
                    <th class="fs-2 fw-semibold mb-0">No. Registrasi</th>
                    <th class="fs-2 fw-semibold mb-0">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center fs-2 fw-normal">Tidak ada peserta yang diterima.</td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
