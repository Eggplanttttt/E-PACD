<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Feedback Management')</title>
    <link rel="shortcut icon" href="{{ asset('assets/shortcut_logo.png') }}" type="image/x-icon">

        <!-- Add Bootstrap (if needed) -->
        {{-- <link rel="stylesheet" href="{{ asset('css/admin-dashboard-complaint.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/admin-dashboard-feedback.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap@5.3.2/bootstrap.min.css') }}">
        <script src="{{ asset('js/datatable/jQuery.dataTables.js') }}"></script>
        <script src="{{ asset('js/bootstrap@5.3.2/bootstrap.bundle.min.js') }}"></script>

        @yield('styles')
        <!-- Font Awesome (for icons) -->
        <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    </head>
    <body>
        <main class="container fluid">
            @yield('content') <!-- The content specific to Feedback -->
        </main>

        <footer class="text-center p-3 mt-4 bg-light">
            <p>&copy; {{ date('Y') }} QSU E-PACD</p>
        </footer>
    </body>
    </html>