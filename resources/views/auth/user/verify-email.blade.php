@extends('layouts.base-public')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    @include('layouts.partials.alert')

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="fw-bold mb-3">Verify Your Email Address</h4>
                            <p class="text-muted">
                                Thanks for signing up! Before getting started, please verify your email address by
                                clicking on the link we just emailed to you. If you didn't receive the email, we will
                                gladly send you another.
                            </p>

                            <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Kirim Ulang Link Verifikasi
                                </button>
                            </form>

                            <form method="POST" action="{{ route('auth.user.logout.destroy') }}" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-link px-0">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
