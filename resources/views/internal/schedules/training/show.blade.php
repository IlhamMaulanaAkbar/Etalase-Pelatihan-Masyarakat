@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>

            <div class="mb-3 text-end">
                <a href="{{ route('internal.schedules.training.index', ['training' => $training->id]) }}"
                    class="btn btn-primary">Kembali</a>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Detail Jadwal Pertemuan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Pelatihan</p>
                            <p class="fw-semibold mb-0">{{ $training->training_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Pertemuan</p>
                            <p class="fw-semibold mb-0">Pertemuan {{ $schedule->meeting_number }}:
                                {{ $schedule->material_title }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="text-muted mb-1">Tanggal</p>
                            <p class="fw-semibold mb-0">{{ $schedule->date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="text-muted mb-1">Waktu</p>
                            <p class="fw-semibold mb-0">{{ substr($schedule->start_time, 0, 5) }} -
                                {{ substr($schedule->end_time, 0, 5) }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="text-muted mb-1">Jam Pelajaran</p>
                            <p class="fw-semibold mb-0">{{ $schedule->duration ?? '-' }} JP</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title fw-semibold mb-0">Sudah Melakukan Absensi</h5>
                        <span class="badge bg-success rounded-pill px-4 py-2 fs-2">
                            {{ $attendedParticipants->count() }} Peserta
                        </span>
                    </div>

                    @if ($attendedParticipants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th><h6 class="fs-2 fw-semibold mb-0">No</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Nama Peserta</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Status</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Waktu Absen</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Catatan</h6></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendedParticipants as $participant)
                                        @php
                                            $attendance = $attendances->get($participant->user?->name);
                                            $badgeClass = match ($attendance?->status) {
                                                'Hadir' => 'success',
                                                'Sakit' => 'warning',
                                                'Izin' => 'info',
                                                'Tidak Hadir' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <tr>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p></td>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $participant->user?->name }}</p></td>
                                            <td>
                                                <span class="badge bg-{{ $badgeClass }} rounded-pill px-4 py-2 fs-2">
                                                    {{ $attendance?->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $attendance?->attendance_time ? substr($attendance->attendance_time, 0, 5) : '-' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $attendance?->note ?? '-' }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada peserta yang melakukan absensi pada pertemuan ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title fw-semibold mb-0">Belum Melakukan Absensi</h5>
                        <span class="badge bg-danger rounded-pill px-4 py-2 fs-2">
                            {{ $notAttendedParticipants->count() }} Peserta
                        </span>
                    </div>

                    @if ($notAttendedParticipants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th><h6 class="fs-2 fw-semibold mb-0">No</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Nama Peserta</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">Email</h6></th>
                                        <th><h6 class="fs-2 fw-semibold mb-0">No. Handphone</h6></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notAttendedParticipants as $participant)
                                        <tr>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p></td>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $participant->user?->name }}</p></td>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $participant->user?->email ?? '-' }}</p></td>
                                            <td><p class="mb-0 fs-2 fw-normal">{{ $participant->user?->phone ?? '-' }}</p></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-success mb-0">
                            Semua peserta diterima sudah melakukan absensi pada pertemuan ini.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
