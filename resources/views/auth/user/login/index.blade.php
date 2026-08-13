<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100 py-4">
                <div class="card mb-0 w-100 shadow" style="max-width:1000px;">
                    <div class="row g-0 align-items-center">
                        <!-- KIRI: GAMBAR -->
                        <div class="col-md-6 d-none d-md-block">
                            <div class="p-4">
                                <img src="{{ asset('assets/images/illustrations/good-news.png') }}" alt="Ilustrasi"
                                    class="img-fluid rounded">
                            </div>
                        </div>
                        <!-- KANAN: FORM -->
                        <div class="col-md-6 col-lg-5">
                            <div class="card-body">
                                @include('layouts.partials.alert')
                                <a href="{{ route('auth.user.login.index') }}"
                                    class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/logo.png') }}" alt="" width="50"
                                        height="50">
                                </a>
                                <p class="text-center">Etalase Pelatihan Masyarakat</p>
                                <form action="{{ route('auth.user.login.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" name="email" class="form-control" id="email"
                                            aria-describedby="email" autocomplete="off">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            autocomplete="off">
                                    </div>
                                    <div class="mb-3 text-center">
                                        {!! NoCaptcha::renderJs() !!}

                                        <div class="d-flex justify-content-center">
                                            {!! NoCaptcha::display() !!}
                                        </div>

                                        @error('g-recaptcha-response')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center justify-content-end mb-4">
                                        <a class="text-primary fw-bold" href="{{ route('password.request') }}">Lupa
                                            Password ?</a>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-8 fs-4 rounded-2">Login</button>
                                    <div class="position-relative text-center my-4" style="height: 22px;">
                                        <span
                                            class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                                        <span class="bg-body px-3 position-relative z-1 text-dark small">or sign in
                                            with</span>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mb-3">
                                        <div class="w-100 mb-2 mb-sm-0">
                                            <a class="btn text-dark border border-gray-800 fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                                                href="{{ route('auth.user.login.oauth.redirect', ['provider' => 'google']) }}">
                                                <img src="../assets/images/logos/google.png" alt="Google"
                                                    class="img-fluid me-2" width="18" height="18">
                                                <span class="flex-shrink-0">With Google</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-3 mb-0 fw-bold">Belum Punya Akun?</p>
                                        <a class="text-primary fw-bold ms-2"
                                            href="{{ route('auth.user.register.index') }}">Daftar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END KANAN -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
