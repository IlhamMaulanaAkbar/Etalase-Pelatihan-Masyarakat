@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Sertifikat Pelatihan</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.certificates.index', ['training' => $training->id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('internal.certificates.update', ['training' => $training->id, 'certificate' => $certificate->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="training_id" value="{{ $training->id }}">

                                <div class="mb-3">
                                    <label for="certificate_number" class="form-label">Nomor Sertifikat Pelatihan</label>
                                    <input type="text" class="form-control" id="certificate_number"
                                        name="certificate_number" required
                                        value="{{ old('certificate_number', $certificate->certificate_number) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="name_of_leader" class="form-label">Nama Pimpinan</label>
                                    <input type="text" class="form-control" id="name_of_leader" name="name_of_leader"
                                        required value="{{ old('name_of_leader', $certificate->name_of_leader) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="leadership_position" class="form-label">Jabatan Pimpinan</label>
                                    <input type="text" class="form-control" id="leadership_position"
                                        name="leadership_position" required
                                        value="{{ old('leadership_position', $certificate->leadership_position) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="identity_number" class="form-label">Nomor Induk Pegawai</label>
                                    <input type="text" class="form-control" id="identity_number" name="identity_number"
                                        required value="{{ old('identity_number', $certificate->identity_number) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="issue_date" class="form-label">Tanggal Penerbitan Sertifikat</label>
                                    <input type="date" class="form-control" id="issue_date" name="issue_date" required
                                        value="{{ old('issue_date', $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : '') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="signature_file" class="form-label">File Tanda Tangan Pimpinan</label>
                                    <input type="file" class="form-control" id="signature_file" name="signature_file"
                                        accept='.png,.jpg,.jpeg'>
                                    @if ($certificate->signature_file)
                                        <small class="text-muted d-block mt-1">
                                            File saat ini:
                                            <a href="{{ asset('storage/' . $certificate->signature_file) }}"
                                                target="_blank">Lihat File</a>
                                        </small>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
