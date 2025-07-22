@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Evaluasi Pelatihan</h5>
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
                                            <h6 class="fs-2 fw-semibold mb-0" style="text-align: center"> Nilai Rata - Rata Pre Test <br> Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0" style="text-align: center"> Nilai Rata - Rata Post Test <br> Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0" style="text-align: center"> Nilai Rata - Rata Evaluasi</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Total Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trainings as $index => $training)
                                        <tr>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}
                                            </p></td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->training_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->category->name ?? '-' }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ number_format($training->average_pretest) }} / 100</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ number_format($training->average_posttest) }} / 100</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ number_format($training->average_evaluation, 1) }} / 5</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $training->participants_count }}</p>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('internal.page.training-evaluation.show', ['training' => $training->id]) }}"
                                                    class="btn btn-outline-primary btn-sm">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada data evaluasi pelatihan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
