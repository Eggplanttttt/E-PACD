@extends('layouts.client')

@php
    // Prevent browser caching to protect page after logout
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Faculty Account Settings')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-custom">
  <div class="container-fluid">
    {{-- Brand --}}
    <a class="navbar-brand d-none d-lg-inline" href="">Electronic Public Assistance & Complaint Desk</a>
    <a class="navbar-brand d-inline d-lg-none" href="">E-PACD</a>

    {{-- Account Dropdown --}}
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle me-1"></i> Account
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="accountDropdownMenu">
          {{-- FAQ button will appear here dynamically on mobile --}}
          <li id="faq-mobile-placeholder" class="d-lg-none"></li>

          {{-- Logout --}}
          <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4" style="max-width: 500px;">
    @php
        $dashboardRoute = route('client.dashboard.faculty'); // student-only dashboard
    @endphp

    <a href="{{ $dashboardRoute }}" class="text-decoration-none mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-2"></i> Back
    </a>

    <h3 class="mb-4 fw-semibold">Change Password</h3>

    {{-- Alert Container --}}
    <div id="alert-container"></div>

    {{-- Password Update Form --}}
    <form id="password-form" method="POST" action="{{ route('faculty.settings.updatePassword') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter your current password" required>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter your new password" required>

            <div class="password-rules mt-2" style="font-size: 14px;">
                <span id="pw-length" class="text-danger">• At least 8 characters</span><br>
                <span id="pw-upper" class="text-danger">• Must contain uppercase letter</span><br>
                <span id="pw-lower" class="text-danger">• Must contain lowercase letter</span><br>
                <span id="pw-number" class="text-danger">• Must contain a number</span><br>
                <span id="pw-special" class="text-danger">• Must contain a special character</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Re-enter your new password" required>
            <span id="pw-match" class="mt-1 d-block text-danger">• Passwords must match</span>
        </div>

        <button type="submit" class="btn w-100 text-white" style="background-color: rgb(1, 60, 43);">
            Update Password
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const alertContainer = document.getElementById('alert-container');
    const passwordForm = document.getElementById('password-form');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');

    const MIN_PASSWORD_LENGTH = 8;
    const MAX_PASSWORD_LENGTH = 20;

    // Password rules live check
    newPassword.addEventListener('input', () => {
        const pw = newPassword.value;
        document.getElementById('pw-length').className = pw.length >= 8 ? 'text-success' : 'text-danger';
        document.getElementById('pw-upper').className = /[A-Z]/.test(pw) ? 'text-success' : 'text-danger';
        document.getElementById('pw-lower').className = /[a-z]/.test(pw) ? 'text-success' : 'text-danger';
        document.getElementById('pw-number').className = /[0-9]/.test(pw) ? 'text-success' : 'text-danger';
        document.getElementById('pw-special').className = /[!@#$%^&*(),.?":{}|<>_\-]/.test(pw) ? 'text-success' : 'text-danger';
    });

    confirmPassword.addEventListener('input', () => {
        document.getElementById('pw-match').className = confirmPassword.value === newPassword.value ? 'text-success' : 'text-danger';
    });

    function showAlert(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.role = 'alert';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        alertContainer.appendChild(alert);
        setTimeout(() => {
            bootstrap.Alert.getOrCreateInstance(alert).close();
        }, 3000);
    }

    // Session messages
    @if(session('success'))
        showAlert("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showAlert("{{ session('error') }}", 'danger');
    @endif

    // Form validation
    passwordForm.addEventListener('submit', (e) => {
        const password = newPassword.value.trim();
        const confirm = confirmPassword.value.trim();

        if (password.length < MIN_PASSWORD_LENGTH) {
            e.preventDefault();
            showAlert(`Password must be at least ${MIN_PASSWORD_LENGTH} characters.`, 'danger');
            newPassword.focus();
            return;
        }
        if (password.length > MAX_PASSWORD_LENGTH) {
            e.preventDefault();
            showAlert(`Password cannot exceed ${MAX_PASSWORD_LENGTH} characters.`, 'danger');
            newPassword.focus();
            return;
        }
        if (password !== confirm) {
            e.preventDefault();
            showAlert("Passwords do not match.", 'danger');
            confirmPassword.focus();
            return;
        }
    });

    window.history.replaceState(null, null, window.location.href);
    window.addEventListener('popstate', () => {
        window.location.href = "{{ route('client.dashboard.faculty') }}";
    });
});

window.addEventListener('pageshow', function(event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        window.location.href = "{{ route('login') }}";
    }
});
</script>
@endsection
