@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('internal.report.users-report.print', request()->query()) }}" target="_blank" class="btn btn-danger btn-sm mb-3 me-2"><i class="ti ti-printer fs-2"></i>
                    Cetak PDF
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-4">Laporan Total Pengguna</h4>
                    <form method="GET" class="row mb-4 g-2 d-flex justify-content-center">
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
                            <a href="{{ route('internal.report.users-report.index') }}"
                                class="btn btn-sm btn-primary w-100">Reset</a>
                        </div>
                    </form>
                    @if ($users->count() > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">No</th>
                                        <th class="fs-2 fw-semibold mb-0">Nama Lengkap</th>
                                        <th class="fs-2 fw-semibold mb-0">Email</th>
                                        <th class="fs-2 fw-semibold mb-0">No. Handphone</th>
                                        <th class="fs-2 fw-semibold mb-0">Tempat Lahir</th>
                                        <th class="fs-2 fw-semibold mb-0">Tanggal Lahir</th>
                                        <th class="fs-2 fw-semibold mb-0">Jenis Kelamin</th>
                                        <th class="fs-2 fw-semibold mb-0">Agama</th>
                                        <th class="fs-2 fw-semibold mb-0">Provinsi</th>
                                        <th class="fs-2 fw-semibold mb-0">Kota/Kab</th>
                                        <th class="fs-2 fw-semibold mb-0">Kecamatan</th>
                                        <th class="fs-2 fw-semibold mb-0">Desa/Kelurahan</th>
                                        <th class="fs-2 fw-semibold mb-0">Pekerjaan</th>
                                        <th class="fs-2 fw-semibold mb-0">Tingkat Pendidikan Terakhir</th>
                                        <th class="fs-2 fw-semibold mb-0">Institusi Pendidikan</th>
                                        <th class="fs-2 fw-semibold mb-0">Pelatihan yang Diikuti</th>
                                        <th class="fs-2 fw-semibold mb-0">Pendampingan yang Diikuti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->email }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->phone }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->place_of_birth }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->date_of_birth }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->gender }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->religion }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->province }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->city }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->district }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->village }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->job }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->education }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->education_institutions }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $item->training_users->count() }} Pelatihan
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $item->assistance_users->count() }} Pendampingan
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada pengguna yang terdaftar.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
