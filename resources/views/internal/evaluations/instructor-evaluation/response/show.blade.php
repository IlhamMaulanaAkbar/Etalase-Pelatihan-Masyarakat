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
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.page.instructor-evaluation.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    @if ($training->count())
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0 text-center">No</th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0" style="text-align: center"> Nilai Evaluasi
                                            </h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($participantsWithScores as $index => $participant)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal text-center">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->evaluation }} / 5</p>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada peserta atau data nilai.</td>
                                        </tr>
                                    @endforelse
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
