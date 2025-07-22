@extends('layouts.base-public')

@section('content')
    <main>
        <section class="min-vh-100 d-flex justify-content-center align-items-center bg-white py-5">
            <div class="border border-1 rounded p-4" style="max-width: 500px; width: 100%;">
                <div class="text-center">
                    <div class="mb-4">
                        <img src="{{ asset('assets/images/illustrations/good-news.png') }}" alt="ilustrasi" class="img-fluid"
                            style="max-height: 250px;">
                    </div>
                    <h5 class="text-success fw-bold">Evaluasi Instruktur selesai</h5>
                    <p class="mb-4">Terima kasih kamu telah menyelesaikan<br>
                        Evaluasi Instruktur – {{ $training->id }}
                    </p>
                    <a href="{{ route('public.account.profile.index') }}" class="btn btn-dark px-4 rounded-pill">TUTUP</a>
                </div>
            </div>
        </section>
    </main>
@endsection
