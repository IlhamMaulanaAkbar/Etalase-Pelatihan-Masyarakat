@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Peserta Pelatihan</h5>
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
                                            <h6 class="fs-2 fw-semibold mb-0">Total Pendaftar</h6>
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
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }} </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->training_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal"><strong class="me-2">{{ $training->training_users_count }}</strong> Pendaftar</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('internal.training.participants.show', ['training' => $training]) }}"
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
                            Belum ada Peserta Pelatihan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
