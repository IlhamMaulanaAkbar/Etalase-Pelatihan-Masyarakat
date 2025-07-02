@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Video Pembelajaran</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.learning.create') }}" class="btn btn-primary">Tambah Video</a>
                    </div>
                    @if (sizeof($learnings) > 0)
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped nowrap">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="fs-2 fw-semibold mb-0">
                                            No</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Gambar</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Nama Video</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Link Video</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Diupload Pada</h6>
                                        </th>
                                        <th>
                                            <h6 class="fs-2 fw-semibold mb-0">Aksi</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($learnings as $learning)
                                        <tr>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <div class="position-relative overflow-hidden rounded-top"
                                                    style="aspect-ratio: 16 / 9;">
                                                    <img src="{{ $learning->thumbnail }}" alt="Thumbnail Video"
                                                        class="img-fluid w-100 h-100 object-fit-cover rounded">
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $learning->video_name }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ $learning->video_url }}" target="_blank"
                                                    class="text-decoration-none text-primary">{{ $learning->video_url }}</a>
                                            </td>
                                            <td>
                                                <p class="mb-0 fs-2 fw-normal">{{ $learning->uploaded_at->format('d M Y') }}
                                                </p>
                                            </td>
                                            <td>
                                                <a href="{{ route('internal.learning.show', ['learning' => $learning]) }}"
                                                    class="btn btn-outline-primary">Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada video pembelajaran yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
