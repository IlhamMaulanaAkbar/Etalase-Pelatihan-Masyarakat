<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etalase Pelatihan Masyarakat</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />

    <!-- Summernote for Bootstrap 5 -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
</head>

<body>
    <!-- Start Page Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('layouts.partials.sidebar-internal')
        <div class="body-wrapper">
            @include('layouts.partials.header-internal')
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div> <!-- .body-wrapper -->
    </div> <!-- .page-wrapper -->
    @include('layouts.partials.footer-internal')
    @stack('scripts')
</body>

</html>
