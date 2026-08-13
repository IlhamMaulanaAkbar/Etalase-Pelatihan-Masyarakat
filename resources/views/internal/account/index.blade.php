@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
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
                            <div>{{ $user->nusaProvince?->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="fw-semibold text-black">Kota/Kab</div>
                            <div>{{ $user->nusaRegency?->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="fw-semibold text-black">Kecamatan</div>
                            <div>{{ $user->nusaDistrict?->name ?? '-' }}</div>
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
                        <button class="btn btn-outline-primary py-3 w-100 rounded-pill fw-semibold tab-link"
                            data-target="data-diri-edit">
                            UBAH DATA DIRI
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
