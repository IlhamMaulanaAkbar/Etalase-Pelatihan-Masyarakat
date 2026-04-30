@php
    $isRegistered = $training->training_users->where('user_id', $user?->id)->first();
    $kuotaPenuh = $training->training_users->count() >= $training->target_audience;
    $now = now();

    $profilLengkap =
        $user &&
        collect([
            'date_of_birth',
            'place_of_birth',
            'phone',
            'gender',
            'province',
            'city',
            'district',
            'village',
            'job',
            'education',
            'education_institutions',
            'religion',
        ])->every(fn($field) => !empty($user->{$field}));

    $statusClass = match ($training->status) {
        'BUKA' => 'success',
        'SELESAI' => 'primary',
        'TUTUP' => 'danger',
    };
@endphp



@extends('layouts.base-public')

@section('content')
    <section class="bg-white">
        <div class="container py-5">
            @include('layouts.partials.alert')

            {{-- Header --}}
            <div class="bg-primary text-white p-4 rounded mb-4">
                <h2 class="fw-bolder text-white mt-2">{{ $training->training_name }}</h2>
                <p>{{ $training->category->name }}</p>

                <div class="row g-3">
                    <div class="col-md-4 d-flex align-items-center">
                        <div>
                            <div class="fw-semibold">Tgl. Pelatihan</div>
                            <div><i class="ti ti-calendar-event me-2 fs-4"></i>{{ $training->start_date->format('d M Y') }} -
                                {{ $training->end_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div>
                            <div class="fw-semibold">Lokasi</div>
                            <div><i class="ti ti-map-pin me-2 fs-4"></i>{{ $training->location }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div>
                            <div class="fw-semibold">Alur Seleksi</div>
                            <div><i class="ti ti-recycle me-2 fs-4"></i>Administrasi</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Informasi Utama --}}
                <div class="col-lg-8">
                    <ul class="nav nav-tabs mb-3" id="detailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                type="button" role="tab">Informasi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="silabus-tab" data-bs-toggle="tab" data-bs-target="#silabus"
                                type="button" role="tab">Materi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="peserta-tab" data-bs-toggle="tab" data-bs-target="#peserta"
                                type="button" role="tab">Peserta</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="detailTabsContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3 social-user pb-3">
                                        <i class="ti ti-world fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Lokasi</div>
                                            <div>{{ $training->location }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center social-user gap-3">
                                        <i class="ti ti-user fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Kuota Peserta</div>
                                            <div>{{ $training->target_audience }} Orang</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center social-user gap-3">
                                        <i class="ti ti-cloud-download fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Silabus</div>
                                            <a href="#" class="text-decoration-none">Download</a>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center social-user gap-3  pt-3">
                                        <i class="ti ti-circle-check fs-3 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold">Sertifikat</div>
                                            <div>BPPMDDTT Banjarmasin</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="fw-bold">Deskripsi</h5>
                            <p>{!! $training->description !!}</p>
                        </div>

                        <div class="tab-pane fade" id="silabus" role="tabpanel">
                            <div class="container">
                                {{-- @php
                                    $isAllowed = \App\Models\TrainingUser::where('training_id', $training->id)
                                        ->where('user_id', optional($user)->id)
                                        ->where('status', 'LULUS')
                                        ->exists();
                                @endphp --}}

                                {{-- @if ($isAllowed) --}}
                                <p class="fw-semibold text-black mb-4">Jadwal Pelatihan ({{ $totalJp }} JP)</p>

                                <div class="position-relative ms-4">
                                    @if ($schedules->count() > 1)
                                        <!-- Garis vertikal hanya jika ada lebih dari 1 lesson -->
                                        <div class="position-absolute top-0 start-0 border-start border-2 border-light"
                                            style="height: 100%; left: 0.5rem;"></div>
                                    @endif

                                    @foreach ($schedules as $schedule)
                                        @php
                                            $attendance = $attendancesBySchedule->get($schedule->id);
                                            $attendanceWindow = $attendanceWindows->get($schedule->id);
                                            $attendanceBadgeClass = match ($attendance?->status) {
                                                'Hadir' => 'success',
                                                'Sakit' => 'warning',
                                                'Izin' => 'info',
                                                'Tidak Hadir' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <!-- Item Materi -->
                                        <div class="d-flex position-relative mb-3">
                                            <!-- Titik (dot) -->
                                            <div class="bg-primary rounded-circle position-absolute"
                                                style="width: 12px; height: 12px; left: -0.3rem; top: 0.4rem;">
                                            </div>

                                            <!-- Card -->
                                            <div class="card w-100 ms-4">
                                                <div class="card-body">
                                                    <div
                                                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                                        <div>
                                                            <h6 class="fw-bold mb-2">Pertemuan
                                                                {{ $schedule->meeting_number }}:
                                                                {{ $schedule->material_title }}</h6>
                                                            <div class="text-muted small">
                                                                <i class="bi bi-clock"></i>
                                                                {{ $schedule->date->format('d M Y') }},
                                                                {{ substr($schedule->start_time, 0, 5) }} -
                                                                {{ substr($schedule->end_time, 0, 5) }}
                                                                @if ($schedule->duration)
                                                                    | {{ $schedule->duration }} JP
                                                                @endif
                                                            </div>
                                                            @if ($attendance)
                                                                <span
                                                                    class="badge bg-{{ $attendanceBadgeClass }} mt-2">Absensi:
                                                                    {{ $attendance->status }}</span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#scheduleDetailModal{{ $schedule->id }}">
                                                                <i class="bi bi-eye"></i> Detail
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="scheduleDetailModal{{ $schedule->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content rounded-3">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Pertemuan
                                                            {{ $schedule->meeting_number }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-4">Judul Pertemuan</dt>
                                                            <dd class="col-sm-8">{{ $schedule->material_title }}</dd>

                                                            <dt class="col-sm-4">Hari Pertemuan</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $schedule->date->translatedFormat('l, d F Y') }}</dd>

                                                            <dt class="col-sm-4">Waktu Pertemuan</dt>
                                                            <dd class="col-sm-8">{{ substr($schedule->start_time, 0, 5) }}
                                                                - {{ substr($schedule->end_time, 0, 5) }} WITA</dd>

                                                            <dt class="col-sm-4">Jam Pelajaran</dt>
                                                            <dd class="col-sm-8">{{ $schedule->duration ?? '-' }} JP</dd>

                                                            <dt class="col-sm-4">File Materi</dt>
                                                            <dd class="col-sm-8">
                                                                @if ($schedule->file)
                                                                    <a href="{{ asset('storage/' . $schedule->file) }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        <i class="bi bi-file-earmark-text"></i> Lihat File
                                                                        Materi
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">Belum ada file materi.</span>
                                                                @endif
                                                            </dd>
                                                        </dl>
                                                        @if ($schedule->material_description)
                                                            <div class="mt-3">
                                                                <div class="mt-3"> Deskripsi Materi
                                                                </div>
                                                                <p class="mb-0">{{ $schedule->material_description }}</p>
                                                            </div>
                                                        @endif

                                                        <hr>

                                                        <h6 class="fw-bold">Absensi</h6>
                                                        @guest('user')
                                                            <div class="alert alert-warning mb-0">
                                                                Silakan login untuk melakukan absensi.
                                                            </div>
                                                        @elseauth('user')
                                                            @if (!$isAcceptedParticipant)
                                                                <div class="alert alert-warning mb-0">
                                                                    Absensi hanya tersedia untuk peserta yang sudah diterima.
                                                                </div>
                                                            @else
                                                                @if ($attendance)
                                                                    <div class="alert alert-info">
                                                                        Absensi saat ini:
                                                                        <strong>{{ $attendance->status }}</strong>
                                                                        @if ($attendance->attendance_time)
                                                                            pada
                                                                            {{ substr($attendance->attendance_time, 0, 5) }}
                                                                        @endif
                                                                    </div>
                                                                    <p class="text-muted mb-0">Absensi sudah dikirim dan tidak
                                                                        dapat diubah kembali.</p>
                                                                @elseif (!$attendanceWindow['has_started'])
                                                                    <div class="alert alert-warning mb-0">
                                                                        Absensi belum dibuka. Absensi dibuka pada
                                                                        {{ $attendanceWindow['starts_at']->format('d M Y H:i') }}.
                                                                    </div>
                                                                @elseif ($attendanceWindow['has_ended'])
                                                                    <div class="alert alert-danger mb-0">
                                                                        Absensi sudah ditutup pada
                                                                        {{ $attendanceWindow['ends_at']->format('d M Y H:i') }}.
                                                                        Peserta yang belum absen akan dianggap Tidak Hadir.
                                                                    </div>
                                                                @else
                                                                    <form method="POST"
                                                                        action="{{ route('public.training.attendance.store', [$training, $schedule]) }}">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Status Kehadiran</label>
                                                                            <select name="status" class="form-select"
                                                                                required>
                                                                                @foreach (['Hadir', 'Tidak Hadir', 'Izin', 'Sakit'] as $status)
                                                                                    <option value="{{ $status }}"
                                                                                        @selected(old('status', 'Hadir') === $status)>
                                                                                        {{ $status }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('status')
                                                                                <div class="text-danger small mt-1">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Catatan</label>
                                                                            <textarea name="note" class="form-control" rows="3" placeholder="Opsional">{{ old('note') }}</textarea>
                                                                            @error('note')
                                                                                <div class="text-danger small mt-1">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary rounded-pill px-4">
                                                                            Absen
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endif
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- @else
                                    <div class="text-center py-5">
                                        <p class="text-muted fs-5">Anda harus <span class="fw-semibold text-dark">mendaftar
                                                dan lulus pelatihan</span> untuk dapat melihat materi pelatihan.</p>
                                    </div>
                                @endif --}}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="peserta" role="tabpanel">
                            <div id="participants-wrapper">
                                @include('public.training.participants', [
                                    'acceptedParticipants' => $acceptedParticipants,
                                ])
                            </div>
                        </div>
                    </div>
                    {{-- Form Pendaftaran & Komitmen --}}
                    <!-- FORM PEMBUKA -->
                    <div id="form-pendaftaran-wrapper" class="d-none">
                        <!-- Step 1: Upload Surat -->
                        <div id="formPendaftaranSection" class="bg-light p-4 rounded">
                            <div class="alert alert-primary border border-primary" role="alert">
                                <strong>Perhatian</strong><br>
                                Setelah melengkapi form pendaftaran, kamu akan diarahkan untuk mengerjakan <strong>Test
                                    Asesmen</strong>.
                            </div>
                            <h4 class="fw-semibold mb-0">Form Pendaftaran Pelatihan</h4>
                            <p>Mohon lengkapi form berikut dengan benar sebagai persyaratan untuk dapat mengikuti pelatihan.
                            </p>

                            <form id="formPendaftaran" method="POST"
                                action="{{ route('public.training.register', $training) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Surat Rekomendasi Kepala Desa</label>
                                    <input type="file" name="letter_recommendation" class="form-control bg-white"
                                        required accept="application/pdf" value="{{ old('letter_recommendation') }}">
                                    <small class="fst-italic fs-1">*File harus format .PDF | Max 2MB</small>
                                    <div id="errorRecommendation" class="text-danger mt-1 d-none">
                                        Mohon untuk upload surat rekomendasi terlebih dahulu.
                                    </div>
                                    <div id="errorRecommendationFormat" class="text-danger mt-1 d-none">
                                        File harus berupa PDF.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Surat Pernyataan</label>
                                    <input type="file" name="letter_statement" class="form-control bg-white" required
                                        accept="application/pdf" value="{{ old('letter_statement') }}">
                                    <small class="fst-italic fs-1">*File harus format .PDF | Max 2MB</small>
                                    <div id="errorStatement" class="text-danger mt-1 d-none">
                                        Mohon untuk upload surat pernyataan terlebih dahulu.
                                    </div>
                                    <div id="errorStatementFormat" class="text-danger mt-1 d-none">
                                        File harus berupa PDF.
                                    </div>
                                </div>

                                <!-- Hidden field untuk komitmen -->
                                <input type="hidden" name="komitmen_check" id="hiddenKomitmen">

                                <button type="button" class="btn btn-primary w-100 rounded-pill" id="btnLanjutForm">
                                    Selanjutnya
                                </button>
                            </form>
                        </div>

                        <!-- Step 2: Komitmen -->
                        <div id="form-komitmen" class="d-none bg-light p-4 rounded">
                            <h4 class="fw-semibold mb-0">Form Komitmen</h4>
                            <p>Saya akan berkomitmen mengikuti pelatihan ini.</p>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="komitmenCheck">
                                <label class="form-check-label" for="komitmenCheck">
                                    Saya telah bersedia mengikuti persyaratan yang ada pada form komitmen pelatihan ini.
                                </label>
                                <div id="komitmenError" class="text-danger mt-1 d-none">
                                    Anda harus menyetujui komitmen ini untuk dapat melanjutkan.
                                </div>

                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary w-100 rounded-pill"
                                    id="btnSebelumnya">Sebelumnya</button>
                                <button class="btn btn-primary w-100 rounded-pill" id="btnSubmitForm">Submit
                                    Pendaftaran</button>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold d-block">Batas Pendaftaran</div>
                                <h5 class="fw-bolder text-black">{{ $training->deadline_date->format('d M Y') }}</h5>
                            </div>
                            <span class="badge bg-{{ $statusClass }} rounded-pill px-4 py-2 fs-2">
                                {{ ucfirst(strtolower($training->status)) }}
                            </span>
                        </div>
                        <div class="mt-2">
                            {{-- Jika belum login --}}
                            @guest('user')
                                <a href="{{ route('auth.user.login.index') }}"
                                    class="btn btn-danger w-100 rounded-pill fw-bold py-2">
                                    Profil Anda Belum Lengkap
                                </a>
                            @elseauth('user')
                                {{-- Cek status pelatihan --}}
                                @if ($training->status === 'SELESAI')
                                    <button class="btn btn-secondary w-100 rounded-pill fw-bold py-2" disabled>
                                        Pelatihan Telah Selesai
                                    </button>
                                @elseif ($kuotaPenuh || $training->status === 'TUTUP' || $now->gt($training->deadline_date))
                                    <button class="btn btn-danger w-100 rounded-pill fw-bold py-2" disabled>
                                        TUTUP
                                    </button>
                                @elseif (!$user)
                                    <button class="btn btn-danger w-100 rounded-pill fw-bold py-2">
                                        Profil Anda Belum Lengkap
                                    </button>
                                @elseif (!$profilLengkap)
                                    {{-- Jika user login tapi profil belum lengkap --}}
                                    <button id="btnLengkapiProfil" type="button"
                                        class="btn btn-danger w-100 rounded-pill fw-bold py-2">
                                        Profil Anda Belum Lengkap
                                    </button>
                                @elseif (!$isRegistered)
                                    {{-- Jika user bisa daftar --}}
                                    <button type="button" id="btnDaftarAjax"
                                        class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                                        Daftar
                                    </button>
                                @else
                                    {{-- Status setelah daftar --}}
                                    @switch($isRegistered->status)
                                        @case('DAFTAR')
                                            <button class="btn btn-primary w-100 rounded-pill fw-bold py-2" disabled>
                                                Anda Sudah Terdaftar
                                            </button>
                                        @break

                                        @case('LULUS')
                                            <button class="btn btn-success w-100 rounded-pill fw-bold py-2" disabled>
                                                Anda Diterima
                                            </button>
                                        @break

                                        @case('BATAL')
                                            <button class="btn btn-danger w-100 rounded-pill fw-bold py-2" disabled>
                                                Anda Telah Membatalkan Pendaftaran
                                            </button>
                                        @break

                                        @case('TIDAK_LULUS')
                                            <button class="btn btn-danger w-100 rounded-pill fw-bold py-2" disabled>
                                                Anda Tidak Diterima
                                            </button>
                                        @break
                                    @endswitch
                                @endif
                            @endauth
                        </div>

                        <hr>
                        <div class="p-3 mt-3">
                            <ul class="list-unstyled">

                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-recycle me-2"></i> Alur Seleksi <span
                                        class="ms-auto text-muted">Administrasi</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-user me-2"></i> Kuota <span
                                        class="ms-auto text-muted">{{ $training->target_audience }}
                                        orang</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-circle-check me-2"></i>
                                    <div class="d-flex w-100 align-items-center">
                                        <div class="flex-grow-1">Sertifikasi</div>
                                        <div class="text-muted text-end" style="max-width: 55%; word-break: break-word;">
                                            BPPMDDTT Banjarmasin
                                        </div>
                                    </div>

                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-map-pin me-2"></i>
                                    <div class="d-flex w-100 align-items-center">
                                        <div class="flex-grow-1">Lokasi Pelatihan</div>
                                        <div class="text-muted text-end" style="max-width: 55%; word-break: break-word;">
                                            {{ $training->location }}
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-calendar-event me-2"></i> Tgl. Mulai Pelatihan <span
                                        class="ms-auto text-muted">{{ $training->start_date->format('d M Y') }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-calendar-event me-2"></i> Tgl. Selesai Pelatihan <span
                                        class="ms-auto text-muted">{{ $training->end_date->format('d M Y') }}</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-cloud-download me-2"></i> Silabus <a href="#"
                                        class="ms-auto text-primary fw-semibold text-decoration-none">Download</a>
                                </li>
                                <li class="mb-2 d-flex align-items-center border-bottom pb-2">
                                    <i class="ti ti-eye me-2"></i> Dilihat sebanyak <span
                                        class="ms-auto text-muted">{{ $training->views }}</span>
                                </li>
                            </ul>
                            <div class="mt-3 text-center border-bottom pb-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#shareModal"
                                    data-id="{{ $training->id }}">
                                    <i class="ti ti-share me-1"></i> Bagikan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3">
                <div class="modal-header">
                    <h5 class="modal-title">Bagikan pelatihan ini!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="input-group mb-3">
                        <input type="text" id="shareLink" class="form-control" readonly>
                        <button class="btn btn-primary" id="copyBtn">
                            <i class="ti ti-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalKonfirmasiDaftar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 p-4 text-center">
                <h4 class="fw-semibold">Konfirmasi</h4>
                <p class="mb-4 fw-normal">Apakah seluruh isian data pendaftaran telah benar?<br>
                    Data yang telah disubmit tidak dapat diubah kembali
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4 w-100"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnKonfirmasiSubmit"
                        class="btn btn-primary rounded-pill px-4 w-100">Daftar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formSection = document.getElementById('formPendaftaranSection');
            const formWrapper = document.getElementById('form-pendaftaran-wrapper');
            const formKomitmen = document.getElementById('form-komitmen');
            const formElement = document.getElementById('formPendaftaran');
            const btnLanjut = document.getElementById('btnLanjutForm');
            const btnSebelumnya = document.getElementById('btnSebelumnya');
            const btnSubmit = document.getElementById('btnSubmitForm');
            const komitmenCheck = document.getElementById('komitmenCheck');
            const hiddenKomitmen = document.getElementById('hiddenKomitmen');

            // Menampilkan form pendaftaran dari tombol di luar (misal: #btnDaftarAjax)
            document.getElementById('btnDaftarAjax')?.addEventListener('click', function() {
                document.getElementById('detailTabs').classList.add('d-none');
                document.getElementById('detailTabsContent').classList.add('d-none');
                formWrapper.classList.remove('d-none');
                window.scrollTo({
                    top: formWrapper.offsetTop - 100,
                    behavior: 'smooth'
                });
            });

            // Navigasi ke form komitmen
            btnLanjut?.addEventListener('click', function() {
                const statement = formElement.querySelector('input[name="letter_statement"]');
                const recommendation = formElement.querySelector('input[name="letter_recommendation"]');
                const formSection = document.getElementById('formPendaftaranSection');
                const formKomitmen = document.getElementById('form-komitmen');

                // Error messages
                const errorStatement = document.getElementById('errorStatement');
                const errorStatementFormat = document.getElementById('errorStatementFormat');
                const errorRecommendation = document.getElementById('errorRecommendation');
                const errorRecommendationFormat = document.getElementById('errorRecommendationFormat');

                let isValid = true;

                // ===== Validasi Surat Pernyataan =====
                if (!statement.files.length) {
                    errorStatement.classList.remove('d-none');
                    isValid = false;
                } else {
                    errorStatement.classList.add('d-none');

                    const file = statement.files[0];
                    if (file.type !== 'application/pdf') {
                        errorStatementFormat.classList.remove('d-none');
                        isValid = false;
                    } else {
                        errorStatementFormat.classList.add('d-none');
                    }
                }

                // ===== Validasi Surat Rekomendasi =====
                if (!recommendation.files.length) {
                    errorRecommendation.classList.remove('d-none');
                    isValid = false;
                } else {
                    errorRecommendation.classList.add('d-none');

                    const file = recommendation.files[0];
                    if (file.type !== 'application/pdf') {
                        errorRecommendationFormat.classList.remove('d-none');
                        isValid = false;
                    } else {
                        errorRecommendationFormat.classList.add('d-none');
                    }
                }

                // ===== Tampilkan form komitmen jika valid =====
                if (isValid) {
                    formSection.classList.add('d-none');
                    formKomitmen.classList.remove('d-none');
                }
            });
            // Kembali ke form pendaftaran
            btnSebelumnya?.addEventListener('click', function() {
                formKomitmen.classList.add('d-none');
                formSection.classList.remove('d-none');
            });

            // Submit akhir form
            btnSubmit?.addEventListener('click', function() {
                const errorMsg = document.getElementById('komitmenError');

                if (!komitmenCheck.checked) {
                    errorMsg.classList.remove('d-none');
                    komitmenCheck.focus();
                    return;
                }

                errorMsg.classList.add('d-none');

                // Tampilkan modal konfirmasi
                const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasiDaftar'));
                modal.show();
            });

            // Submit form saat user menyetujui dari modal
            document.getElementById('btnKonfirmasiSubmit')?.addEventListener('click', function() {
                hiddenKomitmen.value = "1";
                formElement.submit();
            });


            komitmenCheck?.addEventListener('change', function() {
                const errorMsg = document.getElementById('komitmenError');
                if (this.checked) {
                    errorMsg.classList.add('d-none');
                }
            });
            statement?.addEventListener('change', () => {
                if (statement.files.length && statement.files[0].type === 'application/pdf') {
                    errorStatement.classList.add('d-none');
                    errorStatementFormat.classList.add('d-none');
                }
            });

            recommendation?.addEventListener('change', () => {
                if (recommendation.files.length && recommendation.files[0].type === 'application/pdf') {
                    errorRecommendation.classList.add('d-none');
                    errorRecommendationFormat.classList.add('d-none');
                }
            });

        });
        document.addEventListener("DOMContentLoaded", function() {
            const rowsPerPage = document.getElementById("rowsPerPage");
            rowsPerPage?.addEventListener("change", function() {
                const perPage = this.value;
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', 1); // reset ke page 1
                fetchParticipants(url);
            });

            document.addEventListener("click", function(e) {
                const link = e.target.closest(".pagination-link");
                if (link) {
                    e.preventDefault();
                    fetchParticipants(link.href);
                }
            });

            function fetchParticipants(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(res => res.json())
                    .then(data => {
                        document.querySelector("#participants-wrapper").innerHTML = data.html;
                    });
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.addEventListener("click", function(e) {
                const link = e.target.closest('.pagination a');
                if (link) {
                    e.preventDefault();
                    const url = link.href;
                    fetchParticipants(url);
                }
            });

            function fetchParticipants(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.querySelector("#participants-wrapper").innerHTML = data.html;
                    })
                    .catch(err => console.error("Gagal load data:", err));
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("shareModal");
            const shareInput = document.getElementById("shareLink");
            const fbShare = document.getElementById("fbShare");
            const twitterShare = document.getElementById("twitterShare");
            const emailShare = document.getElementById("emailShare");

            modal.addEventListener('show.bs.modal', function(e) {
                const button = e.relatedTarget;
                const id = button.getAttribute("data-id");
                const baseUrl = "{{ url('/training') }}";
                const shareUrl = `${baseUrl}/${id}`;
                shareInput.value = shareUrl;
                fbShare.href =
                    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`;
                twitterShare.href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}`;
                emailShare.href = `mailto:?body=${encodeURIComponent(shareUrl)}`;
            });

            document.getElementById("copyBtn").addEventListener("click", function() {
                shareInput.select();
                document.execCommand("copy");
                this.innerHTML = '<i class="ti ti-check"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="ti ti-link"></i>';
                }, 1500);
            });
        });
    </script>
@endpush
