@if (session()->has('alert'))
    @php
        $alert = session()->get('alert');
    @endphp
    <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show mt-3" role="alert">
        {{ $alert['message'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
