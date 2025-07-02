<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etalase Pelatihan Masyarakat</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

</head>

<body>
        @include('layouts.partials.header-public')
    <div>
        @yield('content')
    </div>
        @include('layouts.partials.footer-public')
</body>

</html>
