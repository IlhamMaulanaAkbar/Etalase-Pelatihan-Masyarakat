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
                    <h5 class="card-title fw-semibold mb-4">Materi Pendampingan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.schedules.assistance.create', ['assistance' => $assistance->id]) }}"
                            class="btn btn-primary">Tambah Materi Pendampingan</a>
                    </div>
                    @if (sizeof($lessons) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Materi Pendampingan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">File Materi Pendampingan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Durasi Materi Pendampingan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lessons as $lesson)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $lesson->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($lesson->file)
                                                    <a href="{{ asset('storage/' . $lesson->file) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Lihat File
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $lesson->duration }} Jam</p>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('internal.schedules.assistance.edit', ['assistance' => $assistance->id, 'lesson' => $lesson->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="ti ti-edit"></i></a>

                                                <!-- Tombol hapus trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $lesson->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>

                                                <!-- Modal Konfirmasi -->
                                                <div class="modal fade" id="deleteModal{{ $lesson->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $lesson->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h5 class="modal-title text-white text-center w-100"
                                                                    id="deleteModalLabel{{ $lesson->id }}">Konfirmasi
                                                                    Hapus</h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus materi pendampingan ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('internal.schedules.assistance.destroy', ['assistance' => $assistance->id, 'lesson' => $lesson->id]) }}"
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
                            Belum ada materi pendampingan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
