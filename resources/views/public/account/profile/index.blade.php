@extends('layouts.base-public')

@section('content')
    <section class="bg-light py-5">
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
                        </li>
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
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center social-user">
                                            <div>
                                                <small class="text-muted">Pelatihan</small>
                                                <p class="text-black mb-0 ">0 Pelatihan</p>
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
                                                <p class="text-black mb-0 ">0 Pelatihan</p>
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
                                                <p class="text-black mb-0 ">0 Pelatihan</p>
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
                            <div class="card text-center shadow-sm p-4">
                                <p class="mb-3">Belum ada pelatihan yang sedang diikuti</p>
                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                    class="img-fluid mx-auto d-block" width="300" height="300">
                            </div>
                        </div>
                        <div id="pendampingan" class="tab-content d-none">
                            <div class="card text-center shadow-sm p-4">
                                <p class="mb-3">Belum ada pendampingan yang sedang diikuti</p>
                                <img src="{{ asset('assets/images/illustrations/chill-sofa.png') }}" alt="Ilustrasi"
                                    class="img-fluid mx-auto d-block" width="300" height="300">
                            </div>
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
            const contents = document.querySelectorAll('.tab-content');

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
    </script>
@endpush
