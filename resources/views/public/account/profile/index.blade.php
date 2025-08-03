@extends('layouts.base-public')

@section('content')
    <section class="bg-light py-lg-5">
        <div class="container">
            <div class="row align-items-start ">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-white shadow-sm border rounded px-3 py-4">
                    <ul class="nav flex-column list-unstyled">
                        <li class="nav-item">
                            <a class="nav-link disabled text-uppercase fw-bolder text-black" href="#" tabindex="-1"
                                aria-disabled="true" style="pointer-events: none;">
                                MENU
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link fw-semibold text-black-50 tab-link" data-target="dashboard">
                                <i class="ti ti-chart-bar me-1"></i>Dashboard
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link " data-target="data-diri">
                                <i class="ti ti-user me-1"></i>Data Diri
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link" data-target="pelatihan">
                                <i class="ti ti-chalkboard me-1"></i>Pelatihan
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link" data-target="pendampingan">
                                <i class="ti ti-chalkboard me-1"></i>Pendampingan
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link " data-target="test-asesmen">
                                <i class="ti ti-book me-1"></i>Tes Asesmen
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link " data-target="evaluasi">
                                <i class="ti ti-pencil-plus me-1"></i>Evaluasi
                            </button>
                        </li>
                        {{-- <li class="nav-item mb-1">
                            <button
                                class="nav-link text-black-50 fw-semibold d-flex align-items-center justify-content-between tab-link"
                                data-target="notifikasi" href="#">
                                <span class="d-flex align-items-center">
                                    <i class="ti ti-bell-ringing me-1"></i>Notifikasi
                                </span>
                                <span class="badge rounded-pill bg-danger ms-2" style="font-size: 0.65rem;">118</span>
                            </button>

                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link" data-target="settings">
                                <i class="ti ti-settings me-1"></i>Settings
                            </button>
                        </li> --}}
                        <li class="nav-item mb-1">
                            <form method="POST" action="{{ route('auth.user.logout.destroy') }}">
                                @csrf
                                <button type="submit" class="nav-link text-black-50 fw-semibold">
                                    <i class="ti ti-logout me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>


                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Foto Profil" width="50"
                            height="50" class="rounded-circle me-3">
                        <div>
                            <p class="mb-0">Selamat Datang,</p>
                            <h4 class="fw-bolder mb-0">{{ $user->name }}</h4>
                        </div>
                        <button class="btn btn-outline-primary ms-auto rounded-pill tab-link"
                            data-target="data-diri-edit"><i class="ti ti-pencil me-1"></i>Edit</button>
                    </div>
                    <hr class="mb-4">


                    <div id="tab-contents">
                        <div id="dashboard" class="tab-content">
                            <div class="row g-3 mb-4 mt-4">
                                <div class="col-md-4">
                                    <div class="card shadow-sm border">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Pelatihan</small>
                                                <p class="text-black mb-0 ">{{ $trainingStats['total'] ?? 0 }} Pelatihan</p>
                                            </div>
                                            <i class="ti ti-chalkboard text-primary fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Lulus</small>
                                                <p class="text-black mb-0 ">{{ $trainingStats['lulus'] ?? 0 }} Pelatihan</p>
                                            </div>
                                            <i class="ti ti-circle-check text-success fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Tidak Lulus</small>
                                                <p class="text-black mb-0 ">{{ $trainingStats['tidak_lulus'] ?? 0 }}
                                                    Pelatihan
                                                </p>
                                            </div>
                                            <i class="ti ti-clipboard-x text-danger fs-2" style="color: red"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-0">
                                    <div class="card shadow-sm border">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Pendampingan</small>
                                                <p class="text-black mb-0 ">{{ $assistanceStats['total'] ?? 0 }}
                                                    Pendampingan</p>
                                            </div>
                                            <i class="ti ti-chalkboard text-primary fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-0">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Lulus</small>
                                                <p class="text-black mb-0 ">{{ $assistanceStats['lulus'] ?? 0 }}
                                                    Pendampingan</p>
                                            </div>
                                            <i class="ti ti-circle-check text-success fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-0">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Tidak Lulus</small>
                                                <p class="text-black mb-0 ">{{ $assistanceStats['tidak_lulus'] ?? 0 }}
                                                    Pendampingan</p>
                                            </div>
                                            <i class="ti ti-clipboard-x text-danger fs-2" style="color: red"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="fw-bold mb-3">Aktivitas</h5>
                            <div class="card text-center shadow-sm p-4">
                                <p class="mb-3">Belum ada aktivitas yang sedang berjalan</p>
                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                    class="img-fluid mx-auto d-block" width="300" height="300">
                            </div>
                        </div>

                        <div id="data-diri" class="tab-content d-none">
                            <div class="card border rounded overflow-hidden">
                                <div class="card-body py-5">
                                    <h6 class="fw-bolder mb-3 text-black-50">Data diri</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Nama Lengkap</div>
                                            <div>{{ $user->name ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Tgl. Lahir</div>
                                            <div>{{ $user->date_of_birth ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Email</div>
                                            <div>{{ $user->email ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Tempat Lahir</div>
                                            <div>{{ $user->place_of_birth ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">No. Handphone
                                                @if ($user->phone_verified_at)
                                                    <i class="text-success ms-1 bi bi-check-circle-fill"></i>
                                                @endif
                                            </div>
                                            <div>{{ $user->phone ?? '-' }}</div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Jenis Kelamin</div>
                                            <div>{{ $user->gender ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Agama</div>
                                            <div>{{ $user->religion ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h6 class="fw-bolder mb-3 text-black-50">Domisili</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Provinsi</div>
                                            <div>{{ $user->province ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Kota/Kab</div>
                                            <div>{{ $user->city ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Kecamatan</div>
                                            <div>{{ $user->district ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Desa/Kelurahan</div>
                                            <div>{{ $user->village ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h6 class="fw-bolder mb-3 text-black-50">Pekerjaan</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3 w-100">
                                            <div class="fw-semibold text-black">Status</div>
                                            <div>{{ $user->job ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Tingkat Pendidikan Terakhir</div>
                                            <div>{{ $user->education ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Instansi Pendidikan</div>
                                            <div>{{ $user->education_institutions ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <hr class="mb-4">

                                    <div class="text-center mt-2">
                                        <button
                                            class="btn btn-outline-primary py-3 w-100 rounded-pill fw-semibold tab-link"
                                            data-target="data-diri-edit">
                                            UBAH DATA DIRI
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="data-diri-edit" class="tab-content d-none">
                            <div class="card border rounded overflow-hidden">
                                <div class="card-body py-5">
                                    <h6 class="fw-bolder mb-4 text-black-50">Data Diri</h6>

                                    <form method="POST" action="{{ route('public.account.profile.update') }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <!-- Nama -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $user->name) }}"
                                                    {{ $user->name ? 'readonly' : '' }}>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email', $user->email) }}"
                                                    {{ $user->email ? 'readonly' : '' }}>
                                            </div>

                                            <!-- No HP -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">No. Handphone</label>
                                                <input type="text" name="phone" class="form-control"
                                                    value="{{ old('phone', $user->phone) }}"
                                                    {{ $user->phone ? 'readonly' : '' }}>
                                            </div>

                                            <!-- Tempat Lahir -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Tempat Lahir</label>
                                                <input type="text" name="place_of_birth" class="form-control"
                                                    value="{{ old('place_of_birth', $user->place_of_birth) }}"
                                                    {{ $user->place_of_birth ? 'readonly' : '' }}>
                                            </div>

                                            <!-- Tanggal Lahir -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Tanggal Lahir</label>
                                                <input type="date" name="date_of_birth" class="form-control"
                                                    value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                                    {{ $user->date_of_birth ? 'readonly' : '' }}>
                                            </div>

                                            <!-- Jenis Kelamin -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Jenis Kelamin</label>
                                                <select name="gender" class="form-select">
                                                    <option value="">Pilih</option>
                                                    <option value="Laki-laki"
                                                        {{ old('gender', $user->gender ?? null) === 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="Perempuan"
                                                        {{ old('gender', $user->gender ?? null) === 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                                @if ($user->gender)
                                                    <input type="hidden" name="gender" value="{{ $user->gender }}">
                                                @endif
                                            </div>

                                            <!-- Agama -->
                                            <div class="col-md-6 mb-3 w-100">
                                                <label class="form-label fw-semibold text-black">Agama</label>
                                                <select name="religion" class="form-select"
                                                    {{ $user->religion ? 'disabled' : '' }}>
                                                    <option value="">Pilih Agama</option>
                                                    <option value="Islam"
                                                        {{ old('religion', $user->religion) === 'Islam' ? 'selected' : '' }}>
                                                        Islam</option>
                                                    <option value="Kristen Protestan"
                                                        {{ old('religion', $user->religion) === 'Kristen Protestan' ? 'selected' : '' }}>
                                                        Kristen Protestan</option>
                                                    <option value="Kristen Katolik"
                                                        {{ old('religion', $user->religion) === 'Kristen Katolik' ? 'selected' : '' }}>
                                                        Kristen Katolik</option>
                                                    <option value="Hindu"
                                                        {{ old('religion', $user->religion) === 'Hindu' ? 'selected' : '' }}>
                                                        Hindu</option>
                                                    <option value="Buddha"
                                                        {{ old('religion', $user->religion) === 'Buddha' ? 'selected' : '' }}>
                                                        Buddha</option>
                                                    <option value="Konghucu"
                                                        {{ old('religion', $user->religion) === 'Konghucu' ? 'selected' : '' }}>
                                                        Konghucu</option>
                                                </select>

                                                @if ($user->religion)
                                                    <input type="hidden" name="religion" value="{{ $user->religion }}">
                                                @endif
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <h6 class="fw-bolder mb-3 text-black-50">Domisili</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Provinsi</label>
                                                <input type="text" name="province" class="form-control"
                                                    value="{{ old('province', $user->province) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Kota/Kabupaten</label>
                                                <input type="text" name="city" class="form-control"
                                                    value="{{ old('city', $user->city) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Kecamatan</label>
                                                <input type="text" name="district" class="form-control"
                                                    value="{{ old('district', $user->district) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Desa/Kelurahan</label>
                                                <input type="text" name="village" class="form-control"
                                                    value="{{ old('village', $user->village) }}">
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <h6 class="fw-bolder mb-3 text-black-50">Pendidikan</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3 w-100">
                                                <label class="form-label fw-semibold text-black">Status</label>
                                                <select name="job" class="form-select">
                                                    <option value="">Pilih Status Pekerjaan</option>
                                                    <option value="Pelajar/Mahasiswa"
                                                        {{ old('job', $user->job) === 'Pelajar/Mahasiswa' ? 'selected' : '' }}>
                                                        Pelajar/Mahasiswa</option>
                                                    <option value="Bekerja"
                                                        {{ old('job', $user->job) === 'Bekerja' ? 'selected' : '' }}>
                                                        Bekerja</option>
                                                    <option value="Tidak Bekerja"
                                                        {{ old('job', $user->job) === 'Tidak Bekerja' ? 'selected' : '' }}>
                                                        Tidak Bekerja</option>
                                                </select>

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Tingkat Pendidikan
                                                    Terakhir</label>
                                                <select name="education" class="form-select">
                                                    <option value="">Pilih Tingkat Pendidikan</option>
                                                    <option value="TK"
                                                        {{ old('education', $user->education) === 'TK' ? 'selected' : '' }}>
                                                        TK</option>
                                                    <option value="SD Sederajat"
                                                        {{ old('education', $user->education) === 'SD Sederajat' ? 'selected' : '' }}>
                                                        SD Sederajat</option>
                                                    <option value="SMP Sederajat"
                                                        {{ old('education', $user->education) === 'SMP Sederajat' ? 'selected' : '' }}>
                                                        SMP Sederajat</option>
                                                    <option value="SMA/SMK/Sederajat"
                                                        {{ old('education', $user->education) === 'SMA/SMK/Sederajat' ? 'selected' : '' }}>
                                                        SMA/SMK/Sederajat</option>
                                                    <option value="D4/S1"
                                                        {{ old('education', $user->education) === 'D4/S1' ? 'selected' : '' }}>
                                                        D4/S1</option>
                                                    <option value="S2"
                                                        {{ old('education', $user->education) === 'S2' ? 'selected' : '' }}>
                                                        S2</option>
                                                    <option value="S3"
                                                        {{ old('education', $user->education) === 'S3' ? 'selected' : '' }}>
                                                        S3</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Institusi
                                                    Pendidikan</label>
                                                <input type="text" name="education_institutions" class="form-control"
                                                    value="{{ old('education_institutions', $user->education_institutions) }}">
                                            </div>
                                        </div>

                                        <div
                                            class="text-center mt-4 d-flex gap-4 justify-content-center flex-column flex-md-row">
                                            <button
                                                class="btn btn-outline-primary py-3 w-100 rounded-pill fw-semibold tab-link"
                                                data-target="data-diri">
                                                Batal
                                            </button>

                                            <button type="submit"
                                                class="btn btn-primary py-3 w-100 rounded-pill fw-semibold">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="pelatihan" class="tab-content d-none">
                            <h6 class="fw-semibold mb-0 text-black-50">Riwayat Pelatihan</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>Ditemukan {{ $trainingUser->count() }} Pelatihan</div>
                                <select class="form-select form-select-sm w-auto">
                                    <option selected>Terbaru</option>
                                    <option>Terlama</option>
                                </select>
                            </div>
                            @if ($trainingUser->isEmpty())
                                <div class="card text-center shadow-sm p-4">
                                    <p class="mb-3">Belum ada pelatihan yang sedang diikuti</p>
                                    <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                        class="img-fluid mx-auto d-block" width="300" height="300">
                                </div>
                            @else
                                @foreach ($trainingUser as $trainingUsers)
                                    <div class="card shadow-sm mb-4 border-0">
                                        <div class="d-flex align-items-start gap-3 px-3 pt-3">
                                            <img src="{{ asset('storage/' . $trainingUsers->training->thumbnail_image) }}"
                                                alt="Logo" width="80" class="rounded">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="text-muted small mb-0">
                                                        {{ $trainingUsers->training->category->name }}
                                                    </div>
                                                    @if ($trainingUsers->status === 'LULUS' && $trainingUsers->training->end_date->isPast())
                                                        <span class="badge rounded-pill bg-primary fs-2">Lulus</span>
                                                    @elseif ($trainingUsers->status === 'LULUS')
                                                        <span class="badge rounded-pill bg-success fs-2">Diterima</span>
                                                    @elseif ($trainingUsers->status === 'DAFTAR')
                                                        <span class="badge rounded-pill bg-warning fs-2">Menunggu</span>
                                                    @elseif ($trainingUsers->status === 'BATAL')
                                                        <span class="badge rounded-pill bg-danger fs-2">Dibatalkan</span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('public.training.show', ['training' => $trainingUsers->training]) }}"
                                                    class="mb-1 fw-semibold text-dark">
                                                    {{ $trainingUsers->training->training_name }}</a>

                                                {{-- Tanggal, Lokasi, Penyelenggara (horizontal) --}}
                                                <div
                                                    class="d-flex flex-wrap align-items-center text-muted small mt-1 gap-2">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-calendar-event"></i>
                                                        <span>
                                                            {{ $trainingUsers->training->start_date->format('d M Y') }} -
                                                            {{ $trainingUsers->training->end_date->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-map-pin"></i>
                                                        <span>{{ $trainingUsers->training->location }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-3 mx-3">

                                        {{-- Tombol aksi --}}
                                        <div
                                            class="d-flex justify-content-end flex-wrap align-items-center gap-2 px-3 pb-3">
                                            @if ($trainingUsers->status == 'DAFTAR' || $trainingUsers->status == 'LULUS')
                                                @if (!$trainingUsers->has_pretest_answered)
                                                    @if ($trainingUsers->questions > 0)
                                                        <a href="{{ route('public.test-assessment.pre-test.start', ['training' => $trainingUsers->training->id]) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-book me-1"></i>Kerjakan Tes Asesmen
                                                        </a>
                                                    @else
                                                        <!-- Tombol untuk modal jika soal belum tersedia -->
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#noQuestionsModal{{ $trainingUsers->id }}">
                                                            <i class="ti ti-book me-1"></i>Kerjakan Tes Asesmen
                                                        </button>
                                                    @endif
                                                @endif

                                                @if ($trainingUsers->status == 'LULUS' && now()->lt($trainingUsers->training->end_date))
                                                    <!-- Tombol Batal hanya jika status LULUS -->
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#batalModal{{ $trainingUsers->id }}">
                                                        <i class="ti ti-info-circle me-1"></i> Batal Pendaftaran
                                                    </button>
                                                @endif
                                                @if ($trainingUsers->status === 'LULUS' && ($trainingUsers->training->end_date)->isPast())
                                                    <a href="{{ route('public.certificates.index', ['id' => $trainingUsers->id]) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="ti ti-certificate me-1"></i>Download Sertifikat
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="modal fade" id="noQuestionsModal{{ $trainingUsers->id }}"
                                            tabindex="-1"
                                            aria-labelledby="noQuestionsModalLabel{{ $trainingUsers->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header justify-content-center bg-danger">
                                                        <h5 class="modal-title text-center w-100 text-white"
                                                            id="noQuestionsModalLabel{{ $trainingUsers->id }}">
                                                            Tes Belum Tersedia
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        Mohon maaf, tes asesmen untuk pelatihan
                                                        <strong>{{ $trainingUsers->training->training_name }}</strong>
                                                        belum tersedia saat ini.
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-outline-danger"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Konfirmasi Batal -->
                                        <div class="modal fade" id="batalModal{{ $trainingUsers->id }}" tabindex="-1"
                                            aria-labelledby="batalModalLabel{{ $trainingUsers->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 bg-danger">
                                                        <h5 class="modal-title text-center w-100 text-white"
                                                            id="batalModalLabel{{ $trainingUsers->id }}">Konfirmasi
                                                            Pembatalan</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin membatalkan pelatihan ini?<br>
                                                        <strong>Membatalkan</strong> ini akan membuat Anda tidak bisa
                                                        mendaftar pelatihan yang telah Anda daftarkan.
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <form method="POST"
                                                            action="{{ route('public.training.destroy', $trainingUsers->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-outline-primary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya,
                                                                Batalkan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div id="pendampingan" class="tab-content d-none">
                            <h6 class="fw-semibold mb-0 text-black-50">Riwayat Pendampingan</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>Ditemukan {{ $assistanceUser->count() }} Pendampingan</div>
                                <select class="form-select form-select-sm w-auto">
                                    <option selected>Terbaru</option>
                                    <option>Terlama</option>
                                </select>
                            </div>
                            @if ($assistanceUser->isEmpty())
                                <div class="card text-center shadow-sm p-4">
                                    <p class="mb-3">Belum ada pendampingan yang sedang diikuti</p>
                                    <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                        class="img-fluid mx-auto d-block" width="300" height="300">
                                </div>
                            @else
                                @foreach ($assistanceUser as $assistanceUsers)
                                    <div class="card shadow-sm mb-4 border-0">
                                        <div class="d-flex align-items-start gap-3 px-3 pt-3">
                                            <img src="{{ asset('storage/' . $assistanceUsers->assistance->thumbnail_image) }}"
                                                alt="Logo" width="80" class="rounded">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="text-muted small mb-0">
                                                        {{ $assistanceUsers->assistance->training->training_name ?? '-' }}
                                                    </div>
                                                    @if ($assistanceUsers->status === 'LULUS' && $assistanceUsers->assistance->end_date->isPast())
                                                        <span class="badge rounded-pill bg-primary fs-2">Lulus</span>
                                                    @elseif ($assistanceUsers->status === 'LULUS')
                                                        <span class="badge rounded-pill bg-success fs-2">Diterima</span>
                                                    @elseif ($assistanceUsers->status === 'DAFTAR')
                                                        <span class="badge rounded-pill bg-warning fs-2">Menunggu</span>
                                                    @elseif ($assistanceUsers->status === 'BATAL')
                                                        <span class="badge rounded-pill bg-danger fs-2">Dibatalkan</span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('public.assistance.show', ['assistance' => $assistanceUsers->assistance->id]) }}"
                                                    class="mb-1 fw-semibold text-dark">
                                                    {{ $assistanceUsers->assistance->assistance_name }}
                                                </a>

                                                <div
                                                    class="d-flex flex-wrap align-items-center text-muted small mt-1 gap-2">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-calendar-event"></i>
                                                        <span>
                                                            {{ $assistanceUsers->assistance->start_date->format('d M Y') }}
                                                            -
                                                            {{ $assistanceUsers->assistance->end_date->format('d M Y') }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-map-pin"></i>
                                                        <span>{{ $assistanceUsers->assistance->location }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-3 mx-3">

                                        <div
                                            class="d-flex justify-content-end flex-wrap align-items-center gap-2 px-3 pb-3">
                                            @if ($assistanceUsers->status == 'LULUS' && now()->lt($assistanceUsers->assistance->end_date))
                                                <!-- Tombol khusus jika status masih daftar -->
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#batalMentoringModal{{ $assistanceUsers->id }}">
                                                    <i class="ti ti-info-circle me-1"></i> Batal Pendampingan
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Modal Konfirmasi Batal Pendampingan -->
                                        <div class="modal fade" id="batalMentoringModal{{ $assistanceUsers->id }}"
                                            tabindex="-1"
                                            aria-labelledby="batalMentoringModalLabel{{ $assistanceUsers->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 bg-danger">
                                                        <h5 class="modal-title text-center w-100 text-white"
                                                            id="batalMentoringModalLabel{{ $assistanceUsers->id }}">
                                                            Konfirmasi
                                                            Pembatalan</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin membatalkan pendampingan ini?
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <form method="POST"
                                                            action="{{ route('public.assistance.destroy', $assistanceUsers->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-outline-primary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya,
                                                                Batalkan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="test-asesmen" class="tab-content d-none">
                            <h6 class="fw-semibold mb-0 text-black-50">Riwayat Tes Asesmen</h6>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>Ditemukan {{ $trainingUser->count() }} Tes Asesmen</div>
                                <select class="form-select form-select-sm w-auto">
                                    <option selected>Terbaru</option>
                                    <option>Terlama</option>
                                </select>
                            </div>

                            @if ($trainingUser->isEmpty())
                                <div class="card text-center shadow-sm p-4">
                                    <p class="mb-3">Belum ada tes asesmen</p>
                                    <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                        class="img-fluid mx-auto d-block" width="300" height="300">
                                </div>
                            @else
                                @foreach ($trainingUser as $trainingUsers)
                                    <div class="card shadow-sm mb-3 border-0">
                                        <div class="d-flex align-items-center gap-3 px-3 pt-3">
                                            <img src="{{ asset('storage/' . $trainingUsers->training->thumbnail_image) }}"
                                                alt="Logo" width="100" class="rounded">

                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">Test Asesmen
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $trainingUsers->training->category->name }}</div>
                                                <div class="fw-bold">{{ $trainingUsers->training->training_name }}</div>

                                                <div class="d-flex flex-wrap gap-3 mt-2 text-muted small">
                                                    <div><i class="ti ti-file-pencil"></i>
                                                        {{ $trainingUsers->questions }}
                                                        Soal</div>
                                                    <div><i class="ti ti-clock"></i> {{ $trainingUsers->duration }} Menit
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol aksi atau status -->
                                        <div class="px-3 pb-3">
                                            @if ($trainingUsers->has_pretest_answered)
                                                <div class="text-success small mt-2">
                                                    <i class="ti ti-check"></i> Pre Test Sudah Dikerjakan :
                                                    <span class="user-time"
                                                        data-time="{{ $trainingUsers->finished_at }}"></span>
                                                </div>
                                            @elseif ($trainingUsers->questions > 0)
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a href="{{ route('public.test-assessment.pre-test.start', ['training' => $trainingUsers->training->id]) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="ti ti-book me-1"></i>Kerjakan Pre Test
                                                    </a>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#noPretestModal{{ $trainingUsers->id }}">
                                                        <i class="ti ti-book me-1"></i>Kerjakan Pre Test
                                                    </button>
                                                </div>
                                            @endif

                                            {{-- === POST-TEST (Jika Syarat Terpenuhi) === --}}
                                            @if ($trainingUsers->show_posttest)
                                                @if ($trainingUsers->has_posttest_answered)
                                                    <div class="text-success small mt-2">
                                                        <i class="ti ti-check"></i> Post Test sudah dikerjakan :
                                                        <span class="user-time"
                                                            data-time="{{ $trainingUsers->posttest_finished_at }}"></span>
                                                    </div>
                                                @elseif ($trainingUsers->posttest_questions > 0)
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <a href="{{ route('public.test-assessment.post-test.start', ['training' => $trainingUsers->training->id]) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-book me-1"></i>Kerjakan Post-Test
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#noPosttestModal{{ $trainingUsers->id }}">
                                                            <i class="ti ti-book me-1"></i>Kerjakan Post-Test
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <!-- MODAL PRE-TEST TIDAK TERSEDIA -->
                                    <div class="modal fade" id="noPretestModal{{ $trainingUsers->id }}" tabindex="-1"
                                        aria-labelledby="noPretestModalLabel{{ $trainingUsers->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white justify-content-center">
                                                    <h5 class="modal-title text-white text-center w-100"
                                                        id="noPretestModalLabel{{ $trainingUsers->id }}">
                                                        Tes Pre-Test Belum Tersedia
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    Mohon maaf, pre-test untuk pelatihan
                                                    <strong>{{ $trainingUsers->training->training_name }}</strong> belum
                                                    tersedia saat ini.
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL POST-TEST TIDAK TERSEDIA -->
                                    <div class="modal fade" id="noPosttestModal{{ $trainingUsers->id }}" tabindex="-1"
                                        aria-labelledby="noPosttestModalLabel{{ $trainingUsers->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white justify-content-center">
                                                    <h5 class="modal-title text-white text-center w-100"
                                                        id="noPosttestModalLabel{{ $trainingUsers->id }}">
                                                        Tes Post-Test Belum Tersedia
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    Mohon maaf, post-test untuk pelatihan
                                                    <strong>{{ $trainingUsers->training->training_name }}</strong> belum
                                                    tersedia saat ini.
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div id="evaluasi" class="d-none">
                            <div class="card py-4 px-4 shadow-sm border-0">
                                <ul class="nav nav-tabs mb-3" id="evaluasiTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pelatihan-tab" data-bs-toggle="tab"
                                            data-bs-target="#evaluasi-pelatihan" type="button" role="tab">
                                            Pelatihan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="instruktur-tab" data-bs-toggle="tab"
                                            data-bs-target="#evaluasi-instruktur" type="button" role="tab">
                                            Instruktur
                                        </button>
                                    </li>
                                </ul>

                                {{-- Konten Evaluasi --}}
                                <div class="tab-content">
                                    {{-- ==== TAB EVALUASI PELATIHAN ==== --}}
                                    <div class="tab-pane fade show active" id="evaluasi-pelatihan" role="tabpanel">
                                        @php
                                            $evaluasiPelatihan = $trainingUser->filter(fn($t) => $t->show_evaluation);
                                        @endphp

                                        @if ($evaluasiPelatihan->isEmpty())
                                            <div class="card text-center shadow-sm p-4">
                                                <p class="mb-3">Belum ada evaluasi pelatihan yang tersedia</p>
                                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}"
                                                    class="img-fluid mx-auto d-block" width="300">
                                            </div>
                                        @else
                                            @foreach ($evaluasiPelatihan as $trainingUsers)
                                                <div class="card shadow-sm mb-3 border-0">
                                                    <div class="d-flex align-items-center gap-3 px-3 pt-3">
                                                        <img src="{{ asset('storage/' . $trainingUsers->training->thumbnail_image) }}"
                                                            width="100" class="rounded">
                                                        <div class="flex-grow-1">
                                                            <div class="fw-semibold">Evaluasi Pelatihan</div>
                                                            <div class="fw-bold">
                                                                {{ $trainingUsers->training->training_name }}</div>
                                                            <div class="text-muted small">
                                                                {{ $trainingUsers->training->category->name }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center px-3 pb-3">
                                                        @if ($trainingUsers->has_filled_evaluation)
                                                            <div class="text-success small mt-2">
                                                                <i class="ti ti-check"></i> Evaluasi sudah diisi pada <span
                                                                    class="user-time"
                                                                    data-time="{{ $trainingUsers->evaluation_finished_at }}"></span>
                                                            </div>
                                                        @elseif ($trainingUsers->evaluation_questions > 0)
                                                            <a href="{{ route('public.evaluations.training.start', ['training' => $trainingUsers->training->id]) }}"
                                                                class="btn btn-outline-primary btn-sm mt-2">
                                                                <i class="ti ti-book"></i> Mengisi Evaluasi
                                                            </a>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-outline-primary btn-sm mt-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#noEvaluasiModal{{ $trainingUsers->id }}">
                                                                <i class="ti ti-book"></i> Mengisi Evaluasi
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Modal Evaluasi Pelatihan --}}
                                                <div class="modal fade" id="noEvaluasiModal{{ $trainingUsers->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow">
                                                            <div
                                                                class="modal-header bg-danger text-white justify-content-center">
                                                                <h5 class="modal-title text-white text-center w-100">
                                                                    Evaluasi Pelatihan Belum Tersedia
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                Evaluasi untuk pelatihan
                                                                <strong>{{ $trainingUsers->training->training_name }}</strong>
                                                                belum tersedia.
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    {{-- ==== TAB EVALUASI INSTRUKTUR ==== --}}
                                    <div class="tab-pane fade" id="evaluasi-instruktur" role="tabpanel">
                                        @php
                                            $evaluasiInstruktur = $trainingUser->filter(
                                                fn($t) => $t->show_instructor_evaluation,
                                            );
                                        @endphp

                                        @if ($evaluasiInstruktur->isEmpty())
                                            <div class="card text-center shadow-sm p-4">
                                                <p class="mb-3">Belum ada evaluasi instruktur yang tersedia</p>
                                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}"
                                                    class="img-fluid mx-auto d-block" width="300">
                                            </div>
                                        @else
                                            @foreach ($evaluasiInstruktur as $trainingUsers)
                                                <div class="card shadow-sm mb-3 border-0">
                                                    <div class="d-flex align-items-center gap-3 px-3 pt-3">
                                                        <img src="{{ asset('storage/' . $trainingUsers->training->thumbnail_image) }}"
                                                            width="100" class="rounded">
                                                        <div class="flex-grow-1">
                                                            <div class="fw-semibold">Evaluasi Instruktur</div>
                                                            <div class="fw-bold">
                                                                {{ $trainingUsers->training->training_name }}</div>
                                                            <div class="text-muted small">
                                                                {{ $trainingUsers->training->category->name }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-center px-3 pb-3">
                                                        @if ($trainingUsers->has_filled_instructor_evaluation)
                                                            <div class="text-success small mt-2">
                                                                <i class="ti ti-check"></i> Evaluasi instruktur sudah diisi
                                                                pada <span class="user-time"
                                                                    data-time="{{ $trainingUsers->instructor_evaluation_finished_at }}"></span>
                                                            </div>
                                                        @elseif ($trainingUsers->instructor_evaluation_questions > 0)
                                                            <a href="{{ route('public.evaluations.instructor.start', ['training' => $trainingUsers->training->id]) }}"
                                                                class="btn btn-outline-primary btn-sm mt-2">
                                                                <i class="ti ti-book"></i> Isi Evaluasi Instruktur
                                                            </a>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-outline-primary btn-sm mt-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#noInstrukturModal{{ $trainingUsers->id }}">
                                                                <i class="ti ti-book"></i> Isi Evaluasi Instruktur
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Modal Evaluasi Instruktur --}}
                                                <div class="modal fade" id="noInstrukturModal{{ $trainingUsers->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow">
                                                            <div
                                                                class="modal-header bg-danger text-white justify-content-center">
                                                                <h5 class="modal-title text-white text-center w-100">
                                                                    Evaluasi Instruktur Belum Tersedia
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                Evaluasi instruktur untuk
                                                                <strong>{{ $trainingUsers->training->training_name }}</strong>
                                                                belum tersedia.
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                            {{-- Navigasi Tab Evaluasi --}}
                        </div>

                        <div id="notifikasi" class="tab-content d-none">
                            <h5 class="fw-bold">Notifikasi</h5>
                            <!-- isi notifikasi -->
                        </div>
                        <div id="settings" class="tab-content d-none">
                            <h5 class="fw-bold">Pengaturan</h5>
                            <!-- isi pengaturan -->
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('#tab-contents > div');

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Hapus semua active dan warna
                    // links.forEach(l => l.classList.remove('active', 'text-primary'));
                    // this.classList.add('active', 'text-black');

                    const target = this.dataset.target;

                    // Sembunyikan semua konten
                    contents.forEach(content => content.classList.add('d-none'));

                    // Tampilkan konten sesuai target
                    const targetContent = document.getElementById(target);
                    if (targetContent) {
                        targetContent.classList.remove('d-none');
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.user-time').forEach(function(el) {
                const time = el.dataset.time;
                const date = new Date(time);
                const formatted = date.toLocaleString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                el.textContent = formatted;
            });
        });

        function bukaEvaluasi() {
            document.getElementById('evaluasi').classList.remove('d-none');
        }
    </script>
@endpush
