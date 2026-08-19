@extends('layouts.base-public')

@section('content')
    <section class="py-5 bg-light-primary">
        <div class="container py-3">
            <h1 class="fw-bolder mb-7">Rencanakan dan pilih jadwal pelatihan yang tepat untuk kebutuhan Anda.</h1>

            {{-- Filter Section --}}
            <form action="{{ route('public.training.index') }}" method="GET">
                <div class="row g-2 align-items-end mb-4">
                    {{-- Pilih Pelatihan --}}
                    <div class="col-md-3">
                        <label class="form-label">Pilih Pelatihan</label>
                        <select name="category_id" class="form-select border-2" onchange="this.form.submit()">
                            <option value="" @selected(request('category_id') == '')>Semua Pelatihan</option>
                            <option value="1" @selected(request('category_id') == '1')>Pengelolaan BUMDesa</option>
                            <option value="2" @selected(request('category_id') == '2')>Kader Pemberdayaan Masyarakat Desa</option>
                            <option value="3" @selected(request('category_id') == '3')>Pemberdayaan Masyarakat Hukum Adat</option>
                            <option value="4" @selected(request('category_id') == '4')>Pembangunan Desa Wisata</option>
                            <option value="5" @selected(request('category_id') == '5')>Keterampilan Catrans (Transmigrasi)</option>
                            <option value="6" @selected(request('category_id') == '6')>Perencanaan Pembangunan Partisipatif
                            </option>
                            <option value="7" @selected(request('category_id') == '7')>Produk Unggulan Kawasan Pedesaan</option>
                            <option value="8" @selected(request('category_id') == '8')>Produk Unggulan Desa</option>
                            <option value="9" @selected(request('category_id') == '9')>E-commerce</option>
                            <option value="10" @selected(request('category_id') == '10')>Ternak Unggas</option>
                            <option value="11" @selected(request('category_id') == '11')>Lahan Gambut Berkelanjutan</option>
                            <option value="12" @selected(request('category_id') == '12')>Mandiri</option>
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
                        <label class="form-label">Telusuri Pelatihan</label>
                        <input type="text" name="keyword" class="form-control border-2" placeholder="Cari Pelatihan..."
                            value="{{ request('keyword') }}">
                    </div>

                    {{-- Tombol Cari --}}
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    {{-- <section class="bg-primary">
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm rounded-4 border-0 overflow-hidden" style="height: 520px;">
                        <!-- Gambar header -->
                        <div class="position-relative">
                            <img src="assets/images/logos/testing.jpg" class="img-fluid w-100" alt="AI Engineer">
                        </div>

                        <!-- Konten Card -->
                        <div class="card-body">
                            <p class="text-muted small mb-1">Pelatihan</p>
                            <h6 class="fw-bold mb-4">Penguatan BUM Desa Tematik Penyusunan Laporan Keuangan Gelombang 1</h6>

                            <div class="d-flex align-items-center text-muted small mb-1">
                                <span class="fw-medium"><i class="ti ti-location me-2"></i>3918 Peserta (Total
                                    Peserta)</span>
                            </div>
                            <div class="d-flex align-items-center text-muted small">
                                <span class="fw-medium"><i class="ti ti-calendar-event me-2"></i>21-24 Juli 2025</span>
                            </div>
                            <a href="#" class="btn btn-outline-primary w-100 mt-3">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="bg-light py-4">
        <div class="container py-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($trainings as $training)
                    <div class="col">
                        <div class="card d-flex flex-column shadow-sm h-100">
                            <img src="{{ asset('storage/' . $training->thumbnail_image) }}" class="card-img-top"
                                alt="{{ $training->training_name }}">

                            {{-- Card Body --}}
                            <div class="card-body flex-grow-1 d-flex flex-column">
                                <h6 class="fw-semibold mb-1 text-muted">{{ $training->category->name ?? '-' }}</h6>
                                <a href="{{ route('public.training.show', ['training' => $training]) }}"
                                    class="mb-3 fs-3 text-dark fw-semibold">
                                    {{ str($training->training_name)->limit(50) }}
                                </a>
                                <div class="d-flex align-items-center text-muted small mb-1">
                                    <span class="fw-medium">
                                        <i class="ti ti-map-pin me-2"></i>{{ $training->location }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-0">
                                    <span class="fw-medium">
                                        <i
                                            class="ti ti-calendar-event me-2"></i>{{ $training->start_date->format('d M Y') }}
                                        - {{ $training->end_date->format('d M Y') }}
                                    </span>
                                </div>
                                {{-- Tombol --}}
                                <div class="mt-auto">
                                    <a href="{{ route('public.training.show', ['training' => $training]) }}"
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
                {{ $trainings->onEachSide(1)->links() }}
            </div>
        </div>
    </section>
@endsection
