<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap@5.3.2/bootstrap.bundle.min.js') }}"></script>

    <!-- Global CSS (shared) -->
    <link rel="stylesheet" href="{{ asset('css/admin-inquiries.css') }}">

    <!-- Page-specific CSS (e.g., IO CSS) -->
    @stack('styles')

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/line-awesome/css/line-awesome.min.css') }}"> --}}

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