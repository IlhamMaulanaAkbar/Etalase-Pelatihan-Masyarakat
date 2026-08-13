@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="mb-3 text-end">
                <a href="{{ route('internal.assistance.show', ['assistance' => $assistance->id]) }}"
                    class="btn btn-primary">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Jadwal Pendampingan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.schedules.assistance.create', ['assistance' => $assistance->id]) }}"
                            class="btn btn-primary">Tambah Jadwal Pendampingan</a>
                    </div>
                    @if (sizeof($schedules) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">No</th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Pertemuan</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Tanggal</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Waktu</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Judul Materi</h6></th>
                                        <th class="text-center"><h6 class="fs-2 fw-semibold mb-0">Narasumber</h6></th>
                                        <th class="text-center"><h6 class="fs-2 fw-semibold mb-0">File</h6></th>
                                        <th class="text-center"><h6 class="fs-2 fw-semibold mb-0">Aksi</h6></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p></td>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $schedule->meeting_number }}</p></td>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $schedule->date->format('d M Y') }}</p></td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ substr($schedule->start_time, 0, 5) }} -
                                                    {{ substr($schedule->end_time, 0, 5) }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $schedule->material_title }}</p>
                                                @if ($schedule->duration)
                                                    <small class="text-muted">{{ $schedule->duration }} JP</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $schedule->speaker_name }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($schedule->file)
                                                    <a href="{{ asset('storage/' . $schedule->file) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">Lihat File</a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('internal.schedules.assistance.show', ['assistance' => $assistance->id, 'schedule' => $schedule->id]) }}"
                                                    class="btn btn-secondary btn-sm"><i class="ti ti-eye"></i></a>
                                                <a href="{{ route('internal.schedules.assistance.edit', ['assistance' => $assistance->id, 'schedule' => $schedule->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="ti ti-edit"></i></a>

                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $schedule->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>

                                                <div class="modal fade" id="deleteModal{{ $schedule->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $schedule->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h5 class="modal-title text-white text-center w-100"
                                                                    id="deleteModalLabel{{ $schedule->id }}">Konfirmasi
                                                                    Hapus</h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus jadwal pendampingan ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('internal.schedules.assistance.destroy', ['assistance' => $assistance->id, 'schedule' => $schedule->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada jadwal pendampingan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
