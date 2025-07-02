@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Pelatihan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.training.create') }}" class="btn btn-primary">Tambah Pelatihan</a>
                    </div>
                    @if (sizeof($trainings) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Pelatihan</h6>
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
                                    @foreach ($trainings as $training)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->training_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->start_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->end_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->deadline_date->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <a href="{{ route('internal.training.show', ['training' => $training]) }}"
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
                            Belum ada pelatihan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
