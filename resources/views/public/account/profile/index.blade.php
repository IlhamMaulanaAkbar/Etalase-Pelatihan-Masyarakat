@extends('layouts.base-public')

@php
    $profilePhotoUrl = $user->photo ? asset('storage/' . $user->photo) : asset('assets/images/profile/user-1.jpg');
    $selectedProvinceCode = old('province_code', $user->province_code);
    $selectedRegencyCode = old('regency_code', $user->regency_code);
    $selectedDistrictCode = old('district_code', $user->district_code);
    $selectedVillageCode = old('village_code', $user->village_code);
@endphp

@push('styles')
    <style>
        .profile-crop-container {
            width: 100%;
            height: 320px;
            background-color: #f7f7f7;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-crop-container img {
            max-width: 100%;
            max-height: 100%;
        }

        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>
@endpush

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
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold tab-link" data-target="settings">
                                <i class="ti ti-settings me-1"></i>Pengaturan
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
                         --}}
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
                        <img src="{{ $profilePhotoUrl }}" alt="Foto Profil" width="50" height="50"
                            class="rounded-circle me-3" style="object-fit: cover;">
                        <div>
                            <p class="mb-0">Selamat Datang,</p>
                            <h4 class="fw-bolder mb-0">{{ $user->name }}</h4>
                        </div>
                        <div class="ms-auto d-flex gap-2">
                            <button class="btn btn-outline-primary rounded-pill tab-link" data-target="data-diri-edit">
                                <i class="ti ti-pencil me-1"></i>Edit
                            </button>
                        </div>
                    </div>
                    <hr class="mb-4">
                    @include('layouts.partials.alert')


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
                            {{-- <h5 class="fw-bold mb-3">Aktivitas</h5>
                            <div class="card text-center shadow-sm p-4">
                                <p class="mb-3">Belum ada aktivitas yang sedang berjalan</p>
                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                    class="img-fluid mx-auto d-block" width="300" height="300">
                            </div> --}}
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
                                            @if ($user->email_verified_at)
                                                <div class="small text-success mt-1">
                                                    <i class="ti ti-circle-check me-1"></i>Email sudah terverifikasi
                                                </div>
                                            @else
                                                <div class="small text-muted mt-1">
                                                    Email belum terverifikasi.
                                                    <a href="{{ route('verification.notice') }}" class="fw-semibold">
                                                        Verifikasi email sekarang
                                                    </a>
                                                </div>
                                            @endif
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
                                            <div>{{ $user->nusaProvince?->name ?? $user->nusaRegency?->province?->name ?? $user->nusaDistrict?->province?->name ?? $user->nusaVillage?->province?->name ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Kota/Kab</div>
                                            <div>{{ $user->nusaRegency?->name ?? $user->nusaDistrict?->regency?->name ?? $user->nusaVillage?->regency?->name ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Kecamatan</div>
                                            <div>{{ $user->nusaDistrict?->name ?? $user->nusaVillage?->district?->name ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="fw-semibold text-black">Desa/Kelurahan</div>
                                            <div>{{ $user->nusaVillage?->name ?? '-' }}</div>
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
                                            <div class="fw-semibold text-black">Instansi Pendidikan Terakhir</div>
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
                                    <div class="mb-4 text-center">
                                        <img src="{{ $profilePhotoUrl }}" id="avatarPreview" alt="Foto Profil"
                                            class="rounded-circle mb-3"
                                            style="width:120px; height:120px; object-fit:cover;">
                                        <br>
                                        <button type="button" class="btn btn-primary rounded-pill fs-2"
                                            data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                                            Ubah Foto Profil
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('public.account.profile.update') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cropped_avatar" id="croppedAvatar">

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
                                                <select name="gender" class="form-select"
                                                    {{ $user->gender ? 'disabled' : '' }}>
                                                    <option value="">Pilih</option>
                                                    <option value="Laki-laki"
                                                        {{ old('gender', $user->gender) === 'Laki-laki' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="Perempuan"
                                                        {{ old('gender', $user->gender) === 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>

                                                @if ($user->gender)
                                                    <!-- input hidden ini hanya berguna jika select-nya disabled -->
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
                                                <select name="province_code" id="provinceCode" class="form-select">
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach ($provinceOptions as $province)
                                                        <option value="{{ $province->code }}"
                                                            @selected((string) $selectedProvinceCode === (string) $province->code)>
                                                            {{ $province->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Kota/Kabupaten</label>
                                                <select name="regency_code" id="regencyCode" class="form-select"
                                                    data-selected="{{ $selectedRegencyCode }}"
                                                    {{ $selectedProvinceCode ? '' : 'disabled' }}>
                                                    <option value="">Pilih Kota/Kabupaten</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Kecamatan</label>
                                                <select name="district_code" id="districtCode" class="form-select"
                                                    data-selected="{{ $selectedDistrictCode }}"
                                                    {{ $selectedRegencyCode ? '' : 'disabled' }}>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-semibold text-black">Desa/Kelurahan</label>
                                                <select name="village_code" id="villageCode" class="form-select"
                                                    data-selected="{{ $selectedVillageCode }}"
                                                    {{ $selectedDistrictCode ? '' : 'disabled' }}>
                                                    <option value="">Pilih Desa/Kelurahan</option>
                                                </select>
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
                                                    Pendidikan Terakhir</label>
                                                <input type="text" name="education_institutions" class="form-control"
                                                    value="{{ old('education_institutions', $user->education_institutions) }}">
                                            </div>
                                        </div>

                                        <div
                                            class="text-center mt-4 d-flex gap-4 justify-content-center flex-column flex-md-row">
                                            <button type="button"
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
                            <div class="modal fade" id="uploadFotoModal" tabindex="-1"
                                aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="uploadFotoModalLabel">Upload Foto Profil</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="profile-crop-container mb-3">
                                                <img id="previewImage" src="" alt="Foto yang akan dipotong">
                                            </div>

                                            <div class="d-flex justify-content-center gap-2 mb-3">
                                                <button type="button" class="btn btn-outline-secondary" id="zoomIn">
                                                    <i class="ti ti-zoom-in"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="zoomOut">
                                                    <i class="ti ti-zoom-out"></i>
                                                </button>
                                            </div>

                                            <label for="inputImage" class="form-label fw-semibold">Foto Profil</label>
                                            <input type="file" id="inputImage"
                                                accept="image/jpeg,image/png,image/webp" class="form-control">
                                            <div class="form-text">Format JPG, PNG, atau WEBP. Maksimal 2MB.</div>
                                            <div id="avatarError" class="text-danger small mt-2 d-none"></div>
                                            <div class="alert alert-info mt-3 mb-0">
                                                Setelah foto dipotong, klik Simpan di form profil untuk menyimpan perubahan.
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" id="cropButton" class="btn btn-primary">Crop &
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="pelatihan" class="tab-content d-none">
                            <h6 class="fw-semibold mb-0 text-black-50">Riwayat Pelatihan</h6>
                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                                <div>Ditemukan {{ $trainingHistory->total() }} Pelatihan</div>
                                <form method="GET" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="tab" value="pelatihan">
                                    <select name="training_sort" class="form-select form-select-sm w-auto"
                                        onchange="this.form.submit()">
                                        <option value="latest" @selected($trainingSort === 'latest')>Terbaru</option>
                                        <option value="oldest" @selected($trainingSort === 'oldest')>Terlama</option>
                                    </select>
                                </form>
                            </div>
                            @if ($trainingHistory->count() === 0)
                                <div class="card text-center shadow-sm p-4">
                                    <p class="mb-3">Belum ada pelatihan yang sedang diikuti</p>
                                    <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                        class="img-fluid mx-auto d-block" width="300" height="300">
                                </div>
                            @else
                                @foreach ($trainingHistory as $trainingUsers)
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
                                                    @elseif (strtoupper($trainingUsers->status) === 'TIDAK_LULUS')
                                                        <span class="badge rounded-pill bg-danger fs-2">Tidak
                                                            Diterima</span>
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
                                                            {{ $trainingUsers->training->start_date->format('d M Y') }}
                                                            -
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
                                                @if ($trainingUsers->status === 'LULUS' && $trainingUsers->training->end_date->isPast())
                                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#scoreDetailModal{{ $trainingUsers->id }}">
                                                        <i class="ti ti-chart-bar me-1"></i>Detail Nilai
                                                    </button>
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
                                        <div class="modal fade" id="scoreDetailModal{{ $trainingUsers->id }}"
                                            tabindex="-1"
                                            aria-labelledby="scoreDetailModalLabel{{ $trainingUsers->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header border-0 bg-primary">
                                                        <h5 class="modal-title text-center w-100 text-white"
                                                            id="scoreDetailModalLabel{{ $trainingUsers->id }}">
                                                            Detail Nilai
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="fw-semibold mb-3">
                                                            {{ $trainingUsers->training->training_name }}</h6>
                                                        @php
                                                            $scoreBadgeClass = function ($score) {
                                                                if ($score === null) {
                                                                    return 'bg-light text-dark';
                                                                }

                                                                $score = (float) $score;

                                                                if ($score >= 100) {
                                                                    return 'bg-primary';
                                                                }

                                                                if ($score >= 80) {
                                                                    return 'bg-success';
                                                                }

                                                                if ($score >= 70) {
                                                                    return 'bg-warning text-dark';
                                                                }

                                                                return 'bg-danger';
                                                            };
                                                        @endphp
                                                        <div class="table-responsive">
                                                            <table class="table table-sm align-middle mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Nilai Pre-Test</td>
                                                                        <td class="text-end fw-semibold">
                                                                            <span class="badge rounded-pill {{ $scoreBadgeClass($trainingUsers->pretest_score) }}">
                                                                                {{ $trainingUsers->pretest_score !== null ? $trainingUsers->pretest_score . '/100' : 'N/A' }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Nilai Post-Test</td>
                                                                        <td class="text-end fw-semibold">
                                                                            <span class="badge rounded-pill {{ $scoreBadgeClass($trainingUsers->posttest_score) }}">
                                                                                {{ $trainingUsers->posttest_score !== null ? $trainingUsers->posttest_score . '/100' : 'N/A' }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    {{-- <tr>
                                                                        <td>Total Nilai</td>
                                                                        <td class="text-end fw-semibold">
                                                                            {{ $trainingUsers->assessment_total_score ?? 'N/A' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="table-light">
                                                                        <td class="fw-semibold">Nilai Akhir</td>
                                                                        <td class="text-end fw-bold">
                                                                            {{ $trainingUsers->final_assessment_score ?? 'N/A' }}
                                                                        </td>
                                                                    </tr> --}}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-outline-primary"
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
                                @include('public.account.profile.partials.simple-pagination', [
                                    'paginator' => $trainingHistory,
                                    'appends' => ['tab' => 'pelatihan', 'training_sort' => $trainingSort],
                                ])
                            @endif
                        </div>

                        <div id="pendampingan" class="tab-content d-none">
                            <h6 class="fw-semibold mb-0 text-black-50">Riwayat Pendampingan</h6>
                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                                <div>Ditemukan {{ $assistanceHistory->total() }} Pendampingan</div>
                                <form method="GET" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="tab" value="pendampingan">
                                    <select name="assistance_sort" class="form-select form-select-sm w-auto"
                                        onchange="this.form.submit()">
                                        <option value="latest" @selected($assistanceSort === 'latest')>Terbaru</option>
                                        <option value="oldest" @selected($assistanceSort === 'oldest')>Terlama</option>
                                    </select>
                                </form>
                            </div>
                            @if ($assistanceHistory->count() === 0)
                                <div class="card text-center shadow-sm p-4">
                                    <p class="mb-3">Belum ada pendampingan yang sedang diikuti</p>
                                    <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                        class="img-fluid mx-auto d-block" width="300" height="300">
                                </div>
                            @else
                                @foreach ($assistanceHistory as $assistanceUsers)
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
                                @include('public.account.profile.partials.simple-pagination', [
                                    'paginator' => $assistanceHistory,
                                    'appends' => ['tab' => 'pendampingan', 'assistance_sort' => $assistanceSort],
                                ])
                            @endif
                        </div>
                        <div id="test-asesmen" class="tab-content d-none">
                            <h6 class="fw-semibold mb-0 text-black-50">Riwayat Tes Asesmen</h6>
                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                                <div>Ditemukan {{ $assessmentHistory->total() }} Tes Asesmen</div>
                                <form method="GET" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="tab" value="test-asesmen">
                                    <select name="assessment_sort" class="form-select form-select-sm w-auto"
                                        onchange="this.form.submit()">
                                        <option value="latest" @selected($assessmentSort === 'latest')>Terbaru</option>
                                        <option value="oldest" @selected($assessmentSort === 'oldest')>Terlama</option>
                                    </select>
                                </form>
                            </div>

                            @if ($assessmentHistory->count() === 0)
                                <div class="card text-center shadow-sm p-4">
                                    <p class="mb-3">Belum ada tes asesmen</p>
                                    <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                        class="img-fluid mx-auto d-block" width="300" height="300">
                                </div>
                            @else
                                @foreach ($assessmentHistory as $trainingUsers)
                                    <div class="card shadow-sm mb-3 border-0">
                                        <div class="d-flex align-items-center gap-3 px-3 pt-3">
                                            <img src="{{ asset('storage/' . $trainingUsers->training->thumbnail_image) }}"
                                                alt="Logo" width="100" class="rounded">

                                            <div class="flex-grow-1">
                                                <div class="fw-semibold">Test Asesmen
                                                </div>
                                                <div class="text-muted small">
                                                    {{ $trainingUsers->training->category->name }}</div>
                                                <div class="fw-bold">{{ $trainingUsers->training->training_name }}
                                                </div>

                                                <div class="d-flex flex-wrap gap-3 mt-2 text-muted small">
                                                    <div><i class="ti ti-file-pencil"></i>
                                                        {{ $trainingUsers->questions }}
                                                        Soal</div>
                                                    <div><i class="ti ti-clock"></i> {{ $trainingUsers->duration }}
                                                        Menit
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol aksi atau status -->
                                        <div class="px-3 pb-3">
                                            @if ($trainingUsers->has_pretest_answered)
                                                <div>
                                                    <span class="btn btn-success btn-sm mt-2">
                                                        <i class="ti ti-check"></i> Pre Test Sudah Dikerjakan :
                                                        <span class="user-time"
                                                            data-time="{{ $trainingUsers->finished_at }}"></span> WITA
                                                    </span>
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
                                                    <div>
                                                        <span class="btn btn-success btn-sm mt-2">
                                                            <i class="ti ti-check"></i> Post Test sudah dikerjakan :
                                                            <span class="user-time"
                                                                data-time="{{ $trainingUsers->posttest_finished_at }}"></span> WITA
                                                        </span>
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
                                                    <strong>{{ $trainingUsers->training->training_name }}</strong>
                                                    belum
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
                                                    <strong>{{ $trainingUsers->training->training_name }}</strong>
                                                    belum
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
                                @include('public.account.profile.partials.simple-pagination', [
                                    'paginator' => $assessmentHistory,
                                    'appends' => ['tab' => 'test-asesmen', 'assessment_sort' => $assessmentSort],
                                ])
                            @endif
                        </div>

                        <div id="evaluasi" class="d-none">
                            <div class="card py-4 px-4 shadow-sm border-0">
                                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                                    <div>Ditemukan {{ $evaluationTraining->total() + $evaluationInstructor->total() }}
                                        Evaluasi</div>
                                    <form method="GET" class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="tab" value="evaluasi">
                                        <input type="hidden" name="evaluation_tab" id="evaluationTabInput"
                                            value="{{ request('evaluation_tab', 'pelatihan') }}">
                                        <select name="evaluation_sort" class="form-select form-select-sm w-auto"
                                            onchange="this.form.submit()">
                                            <option value="latest" @selected($evaluationSort === 'latest')>Terbaru</option>
                                            <option value="oldest" @selected($evaluationSort === 'oldest')>Terlama</option>
                                        </select>
                                    </form>
                                </div>

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
                                        @if ($evaluationTraining->count() === 0)
                                            <div class="card text-center shadow-sm p-4">
                                                <p class="mb-3">Belum ada evaluasi pelatihan yang tersedia</p>
                                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}"
                                                    class="img-fluid mx-auto d-block" width="300">
                                            </div>
                                        @else
                                            @foreach ($evaluationTraining as $trainingUsers)
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
                                                            <span class="btn btn-success btn-sm mt-2 d-inline-block">
                                                                <i class="ti ti-check"></i> Evaluasi sudah diisi pada
                                                                <span class="user-time"
                                                                    data-time="{{ $trainingUsers->evaluation_finished_at }}"></span> WITA
                                                            </span>
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
                                            @include('public.account.profile.partials.simple-pagination', [
                                                'paginator' => $evaluationTraining,
                                                'appends' => [
                                                    'tab' => 'evaluasi',
                                                    'evaluation_tab' => 'pelatihan',
                                                    'evaluation_sort' => $evaluationSort,
                                                ],
                                            ])
                                        @endif
                                    </div>

                                    {{-- ==== TAB EVALUASI INSTRUKTUR ==== --}}
                                    <div class="tab-pane fade" id="evaluasi-instruktur" role="tabpanel">
                                        @if ($evaluationInstructor->count() === 0)
                                            <div class="card text-center shadow-sm p-4">
                                                <p class="mb-3">Belum ada evaluasi instruktur yang tersedia</p>
                                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}"
                                                    class="img-fluid mx-auto d-block" width="300">
                                            </div>
                                        @else
                                            @foreach ($evaluationInstructor as $trainingUsers)
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
                                                            <span class="btn btn-success btn-sm mt-2 d-inline-block">
                                                                <i class="ti ti-check"></i> Evaluasi instruktur sudah diisi
                                                                pada
                                                                <span class="user-time"
                                                                    data-time="{{ $trainingUsers->instructor_evaluation_finished_at }}"></span> WITA
                                                            </span>
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
                                            @include('public.account.profile.partials.simple-pagination', [
                                                'paginator' => $evaluationInstructor,
                                                'appends' => [
                                                    'tab' => 'evaluasi',
                                                    'evaluation_tab' => 'instruktur',
                                                    'evaluation_sort' => $evaluationSort,
                                                ],
                                            ])
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
                            <h6 class="fw-semibold mb-3 text-black-50">Pengaturan</h6>

                            <div class="card border shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <h5 class="fw-semibold mb-3">Ubah Password</h5>
                                    <hr>
                                    <div class="alert alert-warning py-3">
                                        Isi jika Anda ingin mengubah password.
                                    </div>

                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="current_password" class="form-label fw-semibold">
                                                Password Saat Ini <span class="text-danger">*</span>
                                            </label>
                                            <input type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                id="current_password" name="current_password"
                                                placeholder="Masukkan password saat ini" autocomplete="current-password">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-semibold">
                                                Password Baru <span class="text-danger">*</span>
                                            </label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Masukkan password baru"
                                                autocomplete="new-password">
                                            <div class="form-text">Gunakan minimal 8 karakter.</div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="password_confirmation" class="form-label fw-semibold">
                                                Konfirmasi Password Baru <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Konfirmasi password"
                                                autocomplete="new-password">
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            Simpan Password
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="card border shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="fw-semibold mb-3">Hubungkan Akun</h5>
                                    <hr>

                                    @if ($user->oauth_provider === 'google')
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                            <button type="button"
                                                class="btn btn-light border d-inline-flex align-items-center gap-2"
                                                disabled>
                                                <img src="{{ asset('assets/images/logos/google.png') }}" alt="Google"
                                                    width="18" height="18">
                                                Google
                                                <i class="ti ti-circle-check text-success"></i>
                                            </button>
                                            <form method="POST"
                                                action="{{ route('auth.user.oauth.disconnect', ['provider' => 'google']) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    Putuskan
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-muted small mb-0">
                                            Akun Google sudah terhubung dan dapat digunakan untuk login.
                                        </p>
                                    @else
                                        <a href="{{ route('auth.user.oauth.connect.redirect', ['provider' => 'google']) }}"
                                            class="btn btn-light border d-inline-flex align-items-center gap-2 mb-3">
                                            <img src="{{ asset('assets/images/logos/google.png') }}" alt="Google"
                                                width="18" height="18">
                                            Google
                                            <i class="ti ti-plus"></i>
                                        </a>
                                        <p class="text-muted small mb-0">
                                            Hubungkan akun Anda untuk dapat login dengan layanan di atas.
                                        </p>
                                    @endif
                                </div>
                            </div>
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
            const sidebarLinks = document.querySelectorAll('nav .tab-link');

            function updateActiveLink(activeLink) {
                // Mengatur ulang semua tautan bilah sisi ke status defaultnya
                sidebarLinks.forEach(l => {
                    l.classList.remove('text-primary');
                    l.classList.add('text-black-50');
                });

                // Atur tautan aktif yang baru
                if (activeLink && activeLink.closest('nav')) {
                    activeLink.classList.remove('text-black-50');
                    activeLink.classList.add('text-primary');
                }
            }

            function showTab(target) {
                contents.forEach(content => content.classList.add('d-none'));
                const targetContent = document.getElementById(target);
                if (targetContent) {
                    targetContent.classList.remove('d-none');
                }
            }

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    updateActiveLink(this);
                    showTab(this.dataset.target);
                });
            });

            // Atur tautan aktif awal saat halaman dimuat
            const params = new URLSearchParams(window.location.search);
            const initialTab = params.get('tab') ||
                @json(session('active_tab')) ||
                @json($errors->has('current_password') || $errors->has('password') ? 'settings' : 'dashboard');
            const initialActiveLink = document.querySelector(`nav .tab-link[data-target="${initialTab}"]`);
            if (initialActiveLink) {
                updateActiveLink(initialActiveLink);
                showTab(initialTab);
            }

            const evaluationTab = params.get('evaluation_tab');
            const evaluationTabInput = document.getElementById('evaluationTabInput');
            if (evaluationTab === 'instruktur') {
                const instructorTabTrigger = document.getElementById('instruktur-tab');
                if (instructorTabTrigger && window.bootstrap) {
                    bootstrap.Tab.getOrCreateInstance(instructorTabTrigger).show();
                }
            }

            document.querySelectorAll('#evaluasiTabs [data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(event) {
                    if (!evaluationTabInput) {
                        return;
                    }

                    evaluationTabInput.value = event.target.id === 'instruktur-tab' ? 'instruktur' : 'pelatihan';
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('provinceCode');
            const regencySelect = document.getElementById('regencyCode');
            const districtSelect = document.getElementById('districtCode');
            const villageSelect = document.getElementById('villageCode');

            if (!provinceSelect || !regencySelect || !districtSelect || !villageSelect) {
                return;
            }

            const nusaBaseUrl = @json(url('/nusa'));
            const selectedRegencyCode = regencySelect.dataset.selected;
            const selectedDistrictCode = districtSelect.dataset.selected;
            const selectedVillageCode = villageSelect.dataset.selected;

            function resetSelect(select, placeholder) {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                select.disabled = true;
            }

            function fillSelect(select, placeholder, items, selectedValue = '') {
                select.innerHTML = `<option value="">${placeholder}</option>`;

                items.forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item.code;
                    option.textContent = item.name;
                    option.selected = item.code === selectedValue;
                    select.appendChild(option);
                });

                select.disabled = false;
            }

            async function loadNusaOptions(url, select, placeholder, selectedValue = '') {
                resetSelect(select, 'Memuat...');

                try {
                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error('Gagal memuat data wilayah.');
                    }

                    const payload = await response.json();
                    fillSelect(select, placeholder, payload.data || [], selectedValue);
                } catch (error) {
                    resetSelect(select, placeholder);
                }
            }

            async function loadRegencies(selectedValue = '') {
                if (!provinceSelect.value) {
                    resetSelect(regencySelect, 'Pilih Kota/Kabupaten');
                    return;
                }

                await loadNusaOptions(
                    `${nusaBaseUrl}/provinces/${encodeURIComponent(provinceSelect.value)}/regencies?per-page=1000`,
                    regencySelect,
                    'Pilih Kota/Kabupaten',
                    selectedValue
                );
            }

            async function loadDistricts(selectedValue = '') {
                if (!regencySelect.value) {
                    resetSelect(districtSelect, 'Pilih Kecamatan');
                    return;
                }

                await loadNusaOptions(
                    `${nusaBaseUrl}/regencies/${encodeURIComponent(regencySelect.value)}/districts?per-page=1000`,
                    districtSelect,
                    'Pilih Kecamatan',
                    selectedValue
                );
            }

            async function loadVillages(selectedValue = '') {
                if (!districtSelect.value) {
                    resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
                    return;
                }

                await loadNusaOptions(
                    `${nusaBaseUrl}/districts/${encodeURIComponent(districtSelect.value)}/villages?per-page=1000`,
                    villageSelect,
                    'Pilih Desa/Kelurahan',
                    selectedValue
                );
            }

            provinceSelect.addEventListener('change', async function() {
                resetSelect(regencySelect, 'Pilih Kota/Kabupaten');
                resetSelect(districtSelect, 'Pilih Kecamatan');
                resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
                await loadRegencies();
            });

            regencySelect.addEventListener('change', async function() {
                resetSelect(districtSelect, 'Pilih Kecamatan');
                resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
                await loadDistricts();
            });

            districtSelect.addEventListener('change', async function() {
                resetSelect(villageSelect, 'Pilih Desa/Kelurahan');
                await loadVillages();
            });

            (async function initializeNusaSelects() {
                if (!provinceSelect.value) {
                    return;
                }

                await loadRegencies(selectedRegencyCode);

                if (selectedRegencyCode) {
                    await loadDistricts(selectedDistrictCode);
                }

                if (selectedDistrictCode) {
                    await loadVillages(selectedVillageCode);
                }
            })();
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

        document.addEventListener('DOMContentLoaded', function() {
            const uploadModalEl = document.getElementById('uploadFotoModal');
            const image = document.getElementById('previewImage');
            const inputImage = document.getElementById('inputImage');
            const cropButton = document.getElementById('cropButton');
            const zoomInBtn = document.getElementById('zoomIn');
            const zoomOutBtn = document.getElementById('zoomOut');
            const avatarPreview = document.getElementById('avatarPreview');
            const croppedAvatar = document.getElementById('croppedAvatar');
            const avatarError = document.getElementById('avatarError');

            if (!uploadModalEl || !image || !inputImage || !cropButton || !window.Cropper) {
                return;
            }

            const uploadModal = new bootstrap.Modal(uploadModalEl);
            let cropper;

            function showAvatarError(message) {
                avatarError.textContent = message;
                avatarError.classList.remove('d-none');
            }

            function clearAvatarError() {
                avatarError.textContent = '';
                avatarError.classList.add('d-none');
            }

            function destroyCropper() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            }

            inputImage.addEventListener('change', function(e) {
                const file = e.target.files[0];
                clearAvatarError();
                destroyCropper();

                if (!file) {
                    image.removeAttribute('src');
                    return;
                }

                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    showAvatarError('Format foto harus JPG, PNG, atau WEBP.');
                    inputImage.value = '';
                    return;
                }

                const maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    showAvatarError('Ukuran foto maksimal 2MB.');
                    inputImage.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    image.src = event.target.result;

                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        responsive: true,
                        autoCropArea: 0.85,
                        background: false,
                        guides: false,
                    });
                };
                reader.readAsDataURL(file);
            });

            zoomInBtn?.addEventListener('click', function() {
                cropper?.zoom(0.1);
            });

            zoomOutBtn?.addEventListener('click', function() {
                cropper?.zoom(-0.1);
            });

            cropButton.addEventListener('click', function() {
                if (!cropper) {
                    showAvatarError('Pilih foto terlebih dahulu.');
                    return;
                }

                const canvas = cropper.getCroppedCanvas({
                    width: 250,
                    height: 250,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                if (!canvas) {
                    showAvatarError('Foto gagal dipotong.');
                    return;
                }

                const croppedDataUrl = canvas.toDataURL('image/jpeg', 0.9);
                croppedAvatar.value = croppedDataUrl;
                avatarPreview.src = croppedDataUrl;
                uploadModal.hide();
            });

            uploadModalEl.addEventListener('hidden.bs.modal', function() {
                destroyCropper();
                image.removeAttribute('src');
                inputImage.value = '';
                clearAvatarError();
            });
        });
    </script>
@endpush
