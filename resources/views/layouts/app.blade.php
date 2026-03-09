<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">
    <title>@yield('title', 'Dashboard')</title>

    <!-- GLOBAL DASHBOARD CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap@5.3.2/bootstrap.bundle.min.js') }}"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <!-- PAGE SPECIFIC CSS WILL LOAD HERE -->
    @yield('styles')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container-fluid">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>