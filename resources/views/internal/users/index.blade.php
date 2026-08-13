@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-4">Data Pengguna</h4>
                    @if ($users->count() > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">No</th>
                                        <th class="fs-2 fw-semibold mb-0">Nama Lengkap</th>
                                        <th class="fs-2 fw-semibold mb-0">Email</th>
                                        <th class="fs-2 fw-semibold mb-0">No. Handphone</th>
                                        <th class="fs-2 fw-semibold mb-0">Tempat Lahir</th>
                                        <th class="fs-2 fw-semibold mb-0">Tanggal Lahir</th>
                                        <th class="fs-2 fw-semibold mb-0">Jenis Kelamin</th>
                                        <th class="fs-2 fw-semibold mb-0">Agama</th>
                                        <th class="fs-2 fw-semibold mb-0">Provinsi</th>
                                        <th class="fs-2 fw-semibold mb-0">Kota/Kab</th>
                                        <th class="fs-2 fw-semibold mb-0">Kecamatan</th>
                                        <th class="fs-2 fw-semibold mb-0">Desa/Kelurahan</th>
                                        <th class="fs-2 fw-semibold mb-0">Pekerjaan</th>
                                        <th class="fs-2 fw-semibold mb-0">Tingkat Pendidikan Terakhir</th>
                                        <th class="fs-2 fw-semibold mb-0">Institusi Pendidikan</th>
                                        <th class="fs-2 fw-semibold mb-0">Pelatihan yang Diikuti</th>
                                        <th class="fs-2 fw-semibold mb-0">Pendampingan yang Diikuti</th>
                                        {{-- <th class="fs-2 fw-semibold mb-0">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->email }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->phone }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->place_of_birth }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->date_of_birth }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->gender }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->religion }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->nusaProvince?->name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->nusaRegency?->name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->nusaDistrict?->name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->nusaVillage?->name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->job }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->education }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $item->education_institutions }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $item->training_users->count() }} Pelatihan
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fs-2 fw-normal">
                                                    {{ $item->assistance_users->count() }} Pendampingan
                                                </p>
                                            </td>
                                            {{-- <td class="text-center">
                                                <a href="#" class="btn btn-outline-danger btn-sm"><i class="ti ti-trash"></i></a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada pengguna yang terdaftar.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
