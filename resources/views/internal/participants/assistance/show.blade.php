@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Peserta pendampingan: <br>{{ $assistance->assistance_name }}</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.assistance.participants.index') }}" class="btn btn-primary">Kembali</a>
                    </div>
                    @if (sizeof($participants) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Peserta</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Status</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Aksi</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Waktu Verifikasi</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Profil Peserta</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $participant->user->name }}</p>
                                            </td>
                                            <td>
                                                @if ($participant->status == 'LULUS')
                                                    <span
                                                        class="badge bg-success rounded-pill px-4 py-2 fs-2">Diterima</span>
                                                @elseif ($participant->status == 'TIDAK_LULUS')
                                                    <span class="badge bg-danger rounded-pill px-4 py-2 fs-2">Ditolak</span>
                                                @elseif ($participant->status == 'BATAL')
                                                    <span
                                                        class="badge bg-danger rounded-pill px-4 py-2 fs-2">Dibatalkan oleh Peserta</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning rounded-pill px-4 py-2 fs-2">Menunggu</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($participant->status === 'DAFTAR')
                                                    <form method="POST"
                                                        action="{{ route('internal.training.participants.status', ['training_user' => $participant->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="d-flex align-items-center gap-2">
                                                            <select name="status"
                                                                class="form-select form-select-sm w-auto">
                                                                <option value="" disabled selected>Pilih Status
                                                                </option>
                                                                <option value="LULUS">TERIMA</option>
                                                                <option value="TIDAK_LULUS">TOLAK</option>
                                                            </select>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-success">Update</button>
                                                        </div>
                                                    </form>
                                                @else
                                                    <span class="text-muted small">Status telah diproses</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($participant->verified_at)
                                                    <p class="mb-0 fs-2 fw-normal">
                                                        {{ $participant->verified_at->format('d M Y H:i') }}
                                                    </p>
                                                @else
                                                    <p class="text-muted mb-0 fs-2 fw-normal">Belum diverifikasi</p>
                                                @endif
                                            </td>

                                            <!-- Tombol Detail -->
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $participant->id }}">
                                                    Detail
                                                </button>

                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailModal{{ $participant->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                                            <div class="modal-header border-0 pb-0">
                                                                <h5 class="modal-title fw-semibold mb-2">Data Diri Peserta
                                                                </h5>
                                                                <button class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Nama Lengkap</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->name }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Tgl. Lahir</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->date_of_birth }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Email</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->email }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Tempat Lahir</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->place_of_birth }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">No. Handphone</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->phone }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Jenis Kelamin</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->gender }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Agama</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->religion }}</p>
                                                                        </div>
                                                                    </div>

                                                                    <hr>

                                                                    <div class="row mb-4">
                                                                        <h6 class="fw-semibold mb-3">Domisili</h6>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Provinsi</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->province }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Kota/Kab</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->city }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Kecamatan</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->district }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Desa/Kelurahan</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->village }}</p>
                                                                        </div>
                                                                    </div>

                                                                    <hr>

                                                                    <div class="row">
                                                                        <h6 class="fw-semibold mb-3">Pekerjaan</h6>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Status</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->job }}</p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-1 text-muted">Tingkat Pendidikan
                                                                                Terakhir</p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->education }}</p>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <p class="mb-1 text-muted">Instansi Pendidikan
                                                                            </p>
                                                                            <p class="fw-semibold">
                                                                                {{ $participant->user->education_institutions }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
                            Belum ada peserta pendampingan yang mendaftar.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.status-select');

            selects.forEach(function(select) {
                const initialValue = select.dataset.initial;
                const button = select.closest('form').querySelector('.update-btn');

                // Tampilkan tombol jika terjadi perubahan
                select.addEventListener('change', function() {
                    if (select.value !== initialValue) {
                        button.classList.remove('d-none');
                    } else {
                        button.classList.add('d-none');
                    }
                });
            });
        });
    </script>
@endpush
