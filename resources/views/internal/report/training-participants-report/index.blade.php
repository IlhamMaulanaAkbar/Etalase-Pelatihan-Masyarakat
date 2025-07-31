@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('internal.report.training-participants-report.print', request()->query()) }}" target="_blank"
                    class="btn btn-danger btn-sm mb-3 me-2"><i class="ti ti-printer fs-2"></i>
                    Cetak PDF
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Laporan Pelatihan</h5>
                    <form method="GET" class="row g-2 mb-4 d-flex justify-content-center">
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm border-primary"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Status --</option>
                                <option value="DAFTAR" @selected(request('status') == 'DAFTAR')>Menunggu</option>
                                <option value="LULUS" @selected(request('status') == 'LULUS')>Diterima</option>
                                <option value="TIDAK_LULUS" @selected(request('status') == 'TIDAK_LULUS')>Tidak Diterima</option>
                                <option value="BATAL" @selected(request('status') == 'BATAL')>Dibatalkan</option>
                            </select>
                        </div>

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
                            <a href="{{ route('internal.report.training-participants-report.index') }}"
                                class="btn btn-primary btn-sm w-100">Reset</a>
                        </div>
                    </form>


                    @if (sizeof($participants) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Pelatihan</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Kategori Pelatihan</h6>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nilai Pre Test</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nilai Post Test</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Status Pendaftaran</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->user->name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->training->training_name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->training->category->name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->pre_test_score }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->post_test_score }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->status }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada peserta pelatihan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
