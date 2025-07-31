@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('internal.report.learning-report.print', request()->query()) }}" target="_blank" class="btn btn-danger btn-sm mb-3 me-2"><i class="ti ti-printer fs-2"></i>
                    Cetak PDF
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Laporan Video Pembelajaran</h5>
                    <form method="GET" class="row mb-4 g-2 d-flex justify-content-center">
                        <div class="col-md-3">
                            <select name="type" class="form-select form-select-sm border-primary"
                                onchange="this.form.submit()">
                                <option value="" @selected(request('type') == '')>-- Semua Tipe --</option>
                                <option value="umum" @selected(request('type') == 'umum')>Umum</option>
                                <option value="pengumuman" @selected(request('type') == 'pengumuman')>Pengumuman</option>
                                <option value="pendampingan" @selected(request('type') == 'pendampingan')>Pendampingan</option>
                                <option value="pelatihan" @selected(request('type') == 'pelatihan')>Pelatihan</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="year" class="form-select form-select-sm border-primary"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Tahun --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="month" class="form-select form-select-sm border-primary"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Bulan --</option>
                                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $bulan)
                                    <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>
                                        {{ $bulan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('internal.report.learning-report.index') }}"
                                class="btn btn-sm btn-primary w-100">Reset</a>
                        </div>
                    </form>

                    @if (sizeof($learnings) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Video Pembelajaran</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Tipe Video</h6>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Link Video</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Diupload Pada</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($learnings as $learning)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $learning->video_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ ucfirst(strtolower($learning->type)) }}
                                                </p>
                                            </td>
                                            <td>
                                                <a href="{{ $learning->video_url }}" target="_blank"
                                                    class="text-decoration-none text-primary">{{ $learning->video_url }}</a>
                                            </td>

                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $learning->uploaded_at->format('d M Y') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada video pembelajaran yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
