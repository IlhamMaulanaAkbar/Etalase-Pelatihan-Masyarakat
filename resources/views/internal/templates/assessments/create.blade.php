@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Tambah {{ $meta['title'] }}</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.templates.assessments.index', ['templateType' => $templateType, 'category_id' => $selectedCategoryId]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('internal.templates.assessments.store', ['templateType' => $templateType]) }}"
                                method="POST">
                                @csrf
                                @include('internal.templates.assessments.form', [
                                    'question' => null,
                                    'selectedCategoryId' => $selectedCategoryId,
                                ])
                                <button type="submit" class="btn btn-primary w-100 mt-4">Simpan Template</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
