@extends('layouts.base-public')

@section('content')
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-start ">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-white shadow-sm border rounded px-3 py-4" style="height: auto;">
                    <ul class="nav flex-column list-unstyled">
                        <li class="nav-item">
                            <a class="nav-link disabled text-uppercase fw-bolder text-black" href="#" tabindex="-1"
                                aria-disabled="true" style="pointer-events: none;">
                                MENU
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link active text-black-50 fw-semibold" href="#">
                                <i class="ti ti-chart-bar me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link text-black-50 fw-semibold" href="#">
                                <i class="ti ti-user me-1"></i>Data Diri
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link text-black-50 fw-semibold" href="#">
                                <i class="ti ti-chalkboard me-1"></i>Pelatihan
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link text-black-50 fw-semibold d-flex align-items-center justify-content-between"
                                href="#">
                                <span><i class="ti ti-bell-ringing me-1"></i>Notifikasi</span>
                                <span class="badge rounded-pill bg-danger fs-1" style="font-size: 0.65rem;">118</span>
                            </a>
                        </li>
                        <li class="nav-item mb-1">
                            <a class="nav-link text-black-50 fw-semibold" href="#">
                                <i class="ti ti-settings me-1"></i>Settings
                            </a>
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

                    <!-- Ringkasan -->
                    <div class="row g-3 mb-4 mt-4">
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
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
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
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
                                <div class="card-body d-flex justify-content-between align-items-center social-user">
                                    <div>
                                        <small class="text-muted">Tidak Lulus</small>
                                        <p class="text-black mb-0 ">0 Pelatihan</p>
                                    </div>
                                    <i class="ti ti-clipboard-x text-danger fs-2" style="color: red"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas -->
                    <h5 class="fw-bold mb-3">Aktivitas</h5>
                    <div class="card border rounded shadow-sm">
                        <div class="card-body">

                            <h5 class="mb-4 fw-bold">Data Diri</h5>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <div><strong>Nama Lengkap</strong></div>
                                    <div>ILHAM MAULANA AKBAR</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>NIK</strong> <i class="text-success ms-1 bi bi-check-circle-fill"></i>
                                    </div>
                                    <div>637104***********</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Email</strong></div>
                                    <div>maulana2001***@gmail.com</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>No. Handphone</strong> <i
                                            class="text-success ms-1 bi bi-check-circle-fill"></i>
                                    </div>
                                    <div>08**********</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Tgl. Lahir</strong></div>
                                    <div>22/01/2005</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Jenis Kelamin</strong></div>
                                    <div>Pria</div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Domisili</h6>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <div><strong>Provinsi</strong></div>
                                    <div>KALIMANTAN SELATAN</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Kota/Kab</strong></div>
                                    <div>KOTA BANJARMASIN</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Kecamatan</strong></div>
                                    <div>BANJARMASIN UTARA</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Desa/Kelurahan</strong></div>
                                    <div>SUNGAI JINGAH</div>
                                </div>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Pekerjaan</h6>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <div><strong>Status</strong></div>
                                    <div>Pelajar/Mahasiswa</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Instansi Pendidikan</strong></div>
                                    <div>SMAN 5 BANJARMASIN</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div><strong>Tingkat Pendidikan Terakhir</strong></div>
                                    <div>SMA/SMK/Sederajat</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="#" class="btn btn-outline-primary px-4">UBAH DATA DIRI</a>
                            </div>

                        </div>
                    </div>

                </main>
            </div>
        </div>
    </section>
    {{-- <section>
        <div class="container my-5">
            <div class="card border rounded shadow-sm">
                <div class="card-body">

                    <h5 class="mb-4 fw-bold">Data Diri</h5>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div><strong>Nama Lengkap</strong></div>
                            <div>ILHAM MAULANA AKBAR</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>NIK</strong> <i class="text-success ms-1 bi bi-check-circle-fill"></i></div>
                            <div>637104***********</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Email</strong></div>
                            <div>maulana2001***@gmail.com</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>No. Handphone</strong> <i class="text-success ms-1 bi bi-check-circle-fill"></i>
                            </div>
                            <div>08**********</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Tgl. Lahir</strong></div>
                            <div>22/01/2005</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Jenis Kelamin</strong></div>
                            <div>Pria</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">Domisili</h6>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div><strong>Provinsi</strong></div>
                            <div>KALIMANTAN SELATAN</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Kota/Kab</strong></div>
                            <div>KOTA BANJARMASIN</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Kecamatan</strong></div>
                            <div>BANJARMASIN UTARA</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Desa/Kelurahan</strong></div>
                            <div>SUNGAI JINGAH</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">Pekerjaan</h6>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div><strong>Status</strong></div>
                            <div>Pelajar/Mahasiswa</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Instansi Pendidikan</strong></div>
                            <div>SMAN 5 BANJARMASIN</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div><strong>Tingkat Pendidikan Terakhir</strong></div>
                            <div>SMA/SMK/Sederajat</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="#" class="btn btn-outline-primary px-4">UBAH DATA DIRI</a>
                    </div>

                </div>
            </div>
        </div>
    </section> --}}
@endsection
