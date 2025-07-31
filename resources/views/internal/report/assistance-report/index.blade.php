@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('internal.report.assistance-report.print', request()->query()) }}" target="_blank" class="btn btn-danger btn-sm mb-3 me-2"><i class="ti ti-printer fs-2"></i>
                    Cetak PDF
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Laporan Pendampingan</h5>
                    <form method="GET" class="row mb-4 g-2 d-flex justify-content-center">
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm border-primary" onchange="this.form.submit()">
                                <option value="" @selected(request('status') == '')>-- Semua Status --</option>
                                <option value="BUKA" @selected(request('status') == 'BUKA')>BUKA</option>
                                <option value="TUTUP" @selected(request('status') == 'TUTUP')>TUTUP</option>
                                <option value="SELESAI" @selected(request('status') == 'SELESAI')>SELESAI</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="year" class="form-select form-select-sm border-primary" onchange="this.form.submit()">
                                <option value="">-- Semua Tahun --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="month" class="form-select form-select-sm border-primary" onchange="this.form.submit()">
                                <option value="">-- Semua Bulan --</option>
                                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $bulan)
                                    <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>
                                        {{ $bulan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('internal.report.assistance-report.index') }}"
                                class="btn btn-sm btn-primary w-100">Reset</a>
                        </div>
                    </form>

                    @if (sizeof($assistance) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Pendampingan</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Dari Pelatihan</h6>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Tgl. Mulai</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Tgl. Selesai</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Tgl. Berakhir Pendaftaran</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Status Pendampingan</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Lokasi Pendampingan</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Target Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Total Peserta Terdaftar</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assistance as $assistances)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->assistance_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->training->training_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->start_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->end_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $assistances->deadline_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->status }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->location }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->target_audience }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistances->assistance_users_count }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada pendampingan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
