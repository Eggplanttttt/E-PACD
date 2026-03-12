@extends('layouts.client')

@php
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@section('title', 'Visitor Account Settings')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-custom">
  <div class="container-fluid">
    <a class="navbar-brand d-none d-lg-inline" href="">Electronic Public Assistance & Complaint Desk</a>
    <a class="navbar-brand d-inline d-lg-none" href="">E-PACD</a>

    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle me-1"></i> Account
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" id="accountDropdownMenu">
          <li id="faq-mobile-placeholder" class="d-lg-none"></li>
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

<div class="container mt-4" style="max-width: 850px;">
    @php
        $dashboardRoute = route('client.dashboard.others');
        $other = auth('others')->user();
    @endphp

    <a href="{{ $dashboardRoute }}" class="text-decoration-none mb-3 d-inline-block">
        <i class="fas fa-arrow-left me-2"></i> Back
    </a>

    <div id="alert-container"></div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="mb-2 fw-semibold">{{ blank($other?->address) ? 'Complete Your Profile' : 'Update Your Profile' }}</h3>
            <p class="text-muted mb-4">Your account was created from Facebook. You can manage the rest of your profile details here anytime.</p>

            <form id="profile-form" method="POST" action="{{ route('others.profile.update') }}" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-3">
                    <label for="others_first_name" class="form-label">First Name</label>
                    <input type="text" id="others_first_name" name="first_name" class="form-control" value="{{ old('first_name', $other?->first_name) }}" required>
                </div>

                <div class="col-md-3">
                    <label for="others_middle_initial" class="form-label">Middle Name / Initial</label>
                    <input type="text" id="others_middle_initial" name="middle_initial" class="form-control" value="{{ old('middle_initial', $other?->middle_initial) }}">
                </div>

                <div class="col-md-3">
                    <label for="others_last_name" class="form-label">Last Name</label>
                    <input type="text" id="others_last_name" name="last_name" class="form-control" value="{{ old('last_name', $other?->last_name) }}" required>
                </div>

                <div class="col-md-3">
                    <label for="others_suffix" class="form-label">Suffix</label>
                    <input type="text" id="others_suffix" name="suffix" class="form-control" value="{{ old('suffix', $other?->suffix) }}">
                </div>

                <div class="col-12">
                    <label for="others_address" class="form-label">Address</label>
                    <input type="text" id="others_address" name="address" class="form-control" value="{{ old('address', $other?->address) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="others_contact_number" class="form-label">Contact Number</label>
                    <input
                        type="text"
                        id="others_contact_number"
                        name="contact_number"
                        class="form-control"
                        value="{{ old('contact_number', $other?->contact_number) }}"
                        placeholder="09XXXXXXXXX"
                        maxlength="11"
                        inputmode="numeric"
                    >
                </div>

                <div class="col-12">
                    <button type="submit" class="btn text-white" style="background-color: rgb(1, 60, 43);">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4 fw-semibold">Change Password</h3>

            <form id="password-form" method="POST" action="{{ route('others.settings.updatePassword') }}">
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
                        <span id="pw-length" class="text-danger">- At least 8 characters</span><br>
                        <span id="pw-upper" class="text-danger">- Must contain uppercase letter</span><br>
                        <span id="pw-lower" class="text-danger">- Must contain lowercase letter</span><br>
                        <span id="pw-number" class="text-danger">- Must contain a number</span><br>
                        <span id="pw-special" class="text-danger">- Must contain a special character</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Re-enter your new password" required>
                    <span id="pw-match" class="mt-1 d-block text-danger">- Passwords must match</span>
                </div>

                <button type="submit" class="btn w-100 text-white" style="background-color: rgb(1, 60, 43);">
                    Update Password
                </button>
            </form>
        </div>
    </div>
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

    newPassword.addEventListener('input', () => {
        const pw = newPassword.value;
        document.getElementById('pw-length').className = pw.length >= 8 ? 'text-success' : 'text-danger';
        document.getElementById('pw-upper').className = /[A-Z]/.test(pw) ? 'text-success' : 'text-danger';
        document.getElementById('pw-lower').className = /[a-z]/.test(pw) ? 'text-success' : 'text-danger';
        document.getElementById('pw-number').className = /[0-9]/.test(pw) ? 'text-success' : 'text-danger';
        document.getElementById('pw-special').className = /[!@#$%^&*(),.?\":{}|<>_\-]/.test(pw) ? 'text-success' : 'text-danger';
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

    @if(session('success'))
        showAlert("{{ session('success') }}", 'success');
    @endif
    @if(session('error'))
        showAlert("{{ session('error') }}", 'danger');
    @endif

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
        window.location.href = "{{ route('client.dashboard.others') }}";
    });
});

window.addEventListener('pageshow', function(event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        window.location.href = "{{ route('login') }}";
    }
});
</script>
@endsection
