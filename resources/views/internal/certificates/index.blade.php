@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Sertifikat Pelatihan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.certificates.create', ['training' => $training->id]) }}"
                            class="btn btn-primary">Tambah Sertifikat Pelatihan</a>
                    </div>
                    @if (sizeof($certificates) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nomor Sertifikat Pelatihan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Pimpinan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Jabatan pimpinan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Nomor Induk Pegawai Pimpinan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Tanggal Sertifikat Diterbitkan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">File Tanda Tangan Pimpinan</h6>
                                        </th>
                                        <th class="text-center">
                                            <h6 class="fs-2 fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificates as $certificate)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $certificate->certificate_number }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $certificate->name_of_leader }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $certificate->leadership_position }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $certificate->identity_number }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">{{ $certificate->issue_date->format('d-m-Y') }}</p>
                                            </td>
                                            <td class="text-center">
                                                @if ($certificate->signature_file)
                                                    <a href="{{ asset('storage/' . $certificate->signature_file) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Lihat File
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('internal.certificates.edit', ['training' => $training->id, 'certificate' => $certificate->id]) }}"
                                                    class="btn btn-primary btn-sm"><i class="ti ti-edit"></i></a>

                                                <!-- Tombol hapus trigger modal -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $certificate->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>

                                                <!-- Modal Konfirmasi -->
                                                <div class="modal fade" id="deleteModal{{ $certificate->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $certificate->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h5 class="modal-title text-white text-center w-100"
                                                                    id="deleteModalLabel{{ $certificate->id }}">Konfirmasi
                                                                    Hapus</h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus sertifikat pelatihan ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('internal.certificates.destroy', ['training' => $training->id, 'certificate' => $certificate->id]) }}"
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
                            Belum ada sertifikat pelatihan yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
