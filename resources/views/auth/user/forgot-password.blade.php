<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="card mb-0 shadow" style="max-width:520px; width:100%;">
                <div class="card-body p-4">
                    @include('layouts.partials.alert')
                    <a href="{{ route('auth.user.login.index') }}"
                        class="text-nowrap logo-img text-center d-block py-3 w-100">
                        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="" width="50"
                            height="50">
                    </a>
                    <h4 class="fw-bold text-center mb-2">Lupa Password</h4>
                    <p class="text-muted text-center mb-4">
                        Masukkan email akun Anda. Kami akan mengirimkan link untuk membuat password baru.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('auth.user.login.index') }}" class="fw-semibold">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
