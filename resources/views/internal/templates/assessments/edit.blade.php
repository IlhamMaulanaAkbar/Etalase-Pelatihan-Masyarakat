@extends('layouts.base')

@section('content')
    <main>
        <section>
            <div class="container">
                @include('layouts.partials.alert')
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit {{ $meta['title'] }}</h5>
                    <div class="mb-3 text-end">
                        <a href="{{ route('internal.templates.assessments.index', ['templateType' => $templateType, 'category_id' => $question->category_id]) }}"
                            class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form
                                action="{{ route('internal.templates.assessments.update', ['templateType' => $templateType, 'question' => $question->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                @include('internal.templates.assessments.form', [
                                    'selectedCategoryId' => $question->category_id,
                                ])
                                <button type="submit" class="btn btn-primary w-100 mt-4">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
