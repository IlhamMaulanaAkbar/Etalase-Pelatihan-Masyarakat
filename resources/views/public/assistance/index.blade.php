@extends('layouts.base-public')

@section('content')
    <section class="py-5 bg-light-primary">
        <div class="container py-3">
            <h1 class="fw-bolder mb-7">Rencanakan dan pilih jadwal pendampingan sesuai dengan kebutuhan pengembangan kompetensi Anda.</h1>

            {{-- Filter Section --}}
            <form action="{{ route('public.assistance.index') }}" method="GET">
                <div class="row g-2 d-flex align-items-end justify-content-center mb-4">

                    <div class="col-md-3">
                        <label class="form-label">Urutkan Berdasarkan</label>
                        <select name="sort" class="form-select border-2" onchange="this.form.submit()">
                            <option value="" @selected(request('sort') == '')>Semua Urutan</option>
                            <option value="latest" @selected(request('sort') == 'latest')>Terbaru</option>
                            <option value="oldest" @selected(request('sort') == 'oldest')>Terlama</option>
                            <option value="az" @selected(request('sort') == 'az')>A-Z</option>
                        </select>
                    </div>

                    {{-- Lokasi / Status --}}
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select border-2" onchange="this.form.submit()">
                            <option value="" @selected(request('status') == '')>Semua Status</option>
                            <option value="BUKA" @selected(request('status') == 'BUKA')>BUKA</option>
                            <option value="TUTUP" @selected(request('status') == 'TUTUP')>TUTUP</option>
                            <option value="SELESAI" @selected(request('status') == 'SELESAI')>SELESAI</option>
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-2">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control border-2" value="{{ request('date') }}"
                            onchange="this.form.submit()">
                    </div>

                    {{-- Kata Kunci --}}
                    <div class="col-md-3">
                        <label class="form-label">Telusuri Pendampingan</label>
                        <input type="text" name="keyword" class="form-control border-2"
                            placeholder="Cari Pendampingan..." value="{{ request('keyword') }}">
                    </div>

                    {{-- Tombol Cari --}}
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <section class="bg-light py-4">
        <div class="container py-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($assistances as $assistance)
                    <div class="col">
                        <div class="card d-flex flex-column shadow-sm h-100">
                            <img src="{{ asset('storage/' . $assistance->thumbnail_image) }}" class="card-img-top"
                                alt="Pendampingan">

                            {{-- Card Body --}}
                            <div class="card-body flex-grow-1 d-flex flex-column">
                                {{-- <h6 class="fw-semibold mb-1 text-muted">{{ $assistance->training->training_name ?? '-' }}</h6> --}}
                                <a href="{{ route('public.assistance.show', ['assistance' => $assistance]) }}"
                                    class="mb-3 fs-3 text-dark fw-semibold">
                                    {{ str($assistance->assistance_name)->limit(65) }}
                                </a>
                                <div class="d-flex align-items-center text-muted small mb-1">
                                    <span class="fw-medium">
                                        <i class="ti ti-map-pin me-2"></i>{{ $assistance->location }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-0">
                                    <span class="fw-medium">
                                        <i
                                            class="ti ti-calendar-event me-2"></i>{{ $assistance->start_date->format('d M Y') }}
                                        - {{ $assistance->end_date->format('d M Y') }}
                                    </span>
                                </div>
                                {{-- Tombol --}}
                                <div class="mt-auto">
                                    <a href="{{ route('public.assistance.show', ['assistance' => $assistance]) }}"
                                        class="btn btn-outline-primary w-100">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="mb-5">
        {{-- Pagination --}}
        <div class="container">
            <div class="mt-4 d-flex justify-content-center">
                {{ $assistances->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
