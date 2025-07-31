@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Tambah Sertifikat Pelatihan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.certificates.index', ['training' => $training->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.certificates.store', ['training' => $training->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="training_id" value="{{ $training->id }}">
                                <div class="mb-3">
                                    <label for="certificate_number" class="form-label">Nomor Sertifikat Pelatihan</label>
                                    <input type="text" class="form-control" id="certificate_number" name="certificate_number" required
                                        value="{{ old('certificate_number') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="name_of_leader" class="form-label">Nama Pimpinan</label>
                                    <input type="text" class="form-control" id="name_of_leader" name="name_of_leader" required
                                        value="{{ old('name_of_leader') }}" placeholder="Masukkan nama pimpinan">
                                </div>
                                <div class="mb-3">
                                    <label for="leadership_position" class="form-label">Jabatan Pimpinan</label>
                                    <input type="text" class="form-control" id="leadership_position" name="leadership_position" required
                                        value="{{ old('leadership_position') }}" placeholder="Masukkan jabatan pimpinan">
                                </div>
                                <div class="mb-3">
                                    <label for="identity_number" class="form-label">Nomor Induk Pegawai</label>
                                    <input type="text" class="form-control" id="identity_number" name="identity_number" required
                                        value="{{ old('identity_number') }}" placeholder="Masukkan nomor induk pegawai pimpinan">
                                </div>
                                <div class="mb-3">
                                    <label for="issue_date" class="form-label">Tanggal Penerbitan Sertifikat</label>
                                    <input type="date" class="form-control" id="issue_date" name="issue_date" required
                                        value="{{ old('issue_date') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="signature_file" class="form-label">File Tanda Tangan Pimpinan</label>
                                    <input type="file" class="form-control" id="signature_file" name="signature_file" required
                                        value="{{ old('signature_file') }}" accept='.png,.jpg,.jpeg'>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
