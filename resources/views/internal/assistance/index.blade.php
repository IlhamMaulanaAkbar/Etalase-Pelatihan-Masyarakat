@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Pendampingan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.assistance.create') }}" class="btn btn-primary">Tambah Pendampingan</a>
                    </div>
                    @if (sizeof($assistances) > 0)
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
                                            <h6 class="fs-2 fw-semibold mb-0">Tanggal Mulai</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Tanggal Selesai</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Tanggal Berakhir Pendaftaran</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assistances as $assistance)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistance->assistance_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistance->start_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistance->end_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $assistance->deadline_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <a href="{{ route('internal.assistance.show', ['assistance' => $assistance]) }}"
                                                    class="btn btn-outline-primary">Detail
                                                </a>
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
