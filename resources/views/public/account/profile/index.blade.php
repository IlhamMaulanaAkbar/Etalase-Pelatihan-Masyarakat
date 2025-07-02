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
                            <a class="nav-link text-black-50 fw-semibold d-flex align-items-center justify-content-between"
                                data-target="notifikasi" href="#">
                                <span><i class="ti ti-bell-ringing me-1"></i>Notifikasi</span>
                                <span class="badge rounded-pill bg-danger fs-1" style="font-size: 0.75rem;">118</span>
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link text-black-50 fw-semibold" data-target="settings">
                                <i class="ti ti-settings me-1"></i>Settings
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link text-black-50 fw-semibold" href="#">
                                <i class="ti ti-logout me-1"></i>Logout
                            </a>
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
                            <h4 class="fw-bolder mb-0">ILHAM MAULANA AKBAR</h4>
                        </div>
                        <button class="btn btn-outline-primary ms-auto rounded-pill"><i
                                class="ti ti-pencil me-1"></i>Edit</button>
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
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Nama Lengkap</div>
                                            <div>ILHAM MAULANA AKBAR</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">NIK <i
                                                    class="text-success ms-1 ti ti-check-circle-fill"></i></div>
                                            <div>637104***********</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Email</div>
                                            <div>maulana2001***@gmail.com</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">No. Handphone <i
                                                    class="text-success ms-1 bi bi-check-circle-fill"></i></div>
                                            <div>08**********</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Tgl. Lahir</div>
                                            <div>22/01/2005</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Jenis Kelamin</div>
                                            <div>Pria</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="fw-bolder mb-3 text-black-50">Domisili</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Provinsi</div>
                                            <div>KALIMANTAN SELATAN</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Kota/Kab</div>
                                            <div>KOTA BANJARMASIN</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Kecamatan</div>
                                            <div>BANJARMASIN UTARA</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Desa/Kelurahan</div>
                                            <div>SUNGAI JINGAH</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="fw-bolder mb-3 text-black-50">Pekerjaan</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Status</div>
                                            <div>Pelajar/Mahasiswa</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Instansi Pendidikan</div>
                                            <div>SMAN 5 BANJARMASIN</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="fw-semibold text-black">Tingkat Pendidikan Terakhir</div>
                                            <div>SMA/SMK/Sederajat</div>
                                        </div>
                                    </div>
                                    <hr class="mb-4">

                                    <div class="text-center mt-2">
                                        <a href="#"
                                            class="btn btn-outline-primary py-3 w-100 rounded-pill fw-semibold">UBAH DATA
                                            DIRI</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="pelatihan" class="tab-content d-none">
                            <h5 class="fw-bold">Pelatihan</h5>
                            <!-- isi pelatihan -->
                        </div>
                        <div id="pendampingan" class="tab-content d-none">
                            <h5 class="fw-bold">Pendampingan</h5>
                            <!-- isi pendampingan -->
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
                    links.forEach(l => l.classList.remove('active', 'text-primary'));
                    this.classList.add('active', 'text-primary');

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
