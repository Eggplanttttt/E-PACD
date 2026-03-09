<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- IO PROFILE CSS -->
    <link rel="stylesheet" href="{{ asset('css/io-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/audit-profile.css') }}">

    <!-- Existing Admin CSS (load last so it wins) -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard-complaint.css') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
    <script src="{{ asset('js/datatables/jQuery.dataTables.js') }}"></script>
    <script src="{{ asset('js/bootstrap@5.3.2/bootstrap.bundle.min.js') }}"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/line-awesome/css/line-awesome.min.css') }}">
     @yield('styles')
</head>

<body>
    <main class="container fluid">
        @yield('content')
    </main>

    <footer class="text-center p-3 mt-4 bg-light">
        <p>&copy; {{ date('Y') }} QSU E-PACD</p>
    </footer>
</body>
</html>
