<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Complaints Management')</title>
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">

    <!-- Bootstrap first -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/font/bootstrap-icons.css') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/line-awesome/css/line-awesome.min.css') }}">

    <!-- Base styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-complaint.css') }}">

    <!-- Page-specific styles (Audit, etc.) -->
    @yield('styles')
</head>
<body>

    <main class="container-fluid">
        @yield('content')
    </main>

    <footer class="text-center p-3 mt-4 bg-light">
        <p>&copy; {{ date('Y') }} QSU E-PACD</p>
    </footer>

    <!-- JS (bottom) -->
    <script src="{{ asset('js/datatables/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap@5.3.2/bootstrap.bundle.min.js') }}"></script>

    @yield('scripts')
</body>
</html>