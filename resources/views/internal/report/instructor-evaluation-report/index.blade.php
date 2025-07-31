@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('internal.report.instructor-evaluations-report.print', request()->query()) }}" target="_blank"
                    class="btn btn-danger btn-sm mb-3 me-2"><i class="ti ti-printer fs-2"></i>
                    Cetak PDF
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Laporan Evaluasi Instruktur</h5>
                    <form method="GET" class="row g-2 mb-4 d-flex justify-content-center">
                        <div class="col-md-3">
                            <select name="year" class="form-select form-select-sm border-primary"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Tahun --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" @selected(request('year') == $year)>{{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="month" class="form-select form-select-sm border-primary"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Bulan --</option>
                                @foreach ($months as $num => $bulan)
                                    <option value="{{ $num }}" @selected(request('month') == $num)>{{ $bulan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('internal.report.instructor-evaluations-report.index') }}"
                                class="btn btn-primary btn-sm w-100">Reset</a>
                        </div>
                    </form>
                    @if ($trainings->count())
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">No</th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Pelatihan</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Kategori</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0" style="text-align: center"> Nilai Rata - Rata
                                                Evaluasi Instruktur</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Total Peserta</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainings as $index => $training)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->training_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->category->name ?? '-' }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ number_format($training->average_evaluation, 1) }} / 5</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->participants_count }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada data evaluasi instruktur yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
