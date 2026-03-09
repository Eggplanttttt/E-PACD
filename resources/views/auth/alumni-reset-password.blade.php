@php
    // Prevent caching
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSU E-PACD | Alumni Password Reset</title>
    <link rel="icon" href="{{ asset('assets/shortcut_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('../assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/forgot-client.css') }}">
</head>
<body>

<header class="header">
    <div class="logo-container">
        <a href="https://www.bagongpilipinastayo.com/" target="_blank" rel="noopener noreferrer" title="Bagong Pilipinas"><img src="{{ asset('assets/bagong-pilipinas_logo.png')}}" alt="bagong_pilipinas" class="bagong_pilipinas"></a>
        <a href="https://www.gov.ph/" target="_blank" rel="noopener noreferrer" class="gov" title="GOV.PH">GOV.PH</a>
        <a href="https://arta.gov.ph/" target="_blank" rel="noopener noreferrer" title="ARTA"><img src="{{ asset('assets/arta_logo.png')}}" alt="Arta" class="arta"></a>
    </div>

    <nav class="navbar" id="navbar">
        <a href="{{ url('/') }}#home">Home</a>
        <a href="{{ url('/') }}#about">About</a>
        <div class="dropdown">
            <a href="#">Assistance</a>
            <div class="dropdown-content">
                <a href="{{ route('inquiries.page') }}">Inquiries</a>
                <a href="{{ route('complaint.store') }}">Complaints</a>
            </div>
        </div>
        <a href="{{ route('citizen.charter') }}">Citizen's Charter</a>
        <a href="{{ url('/feedback') }}">Feedback</a>
    </nav>

    <div class="icon">
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>
</header>
    <div class="forgot-wrapper">
    <div class="forgot-card">

        <a href="{{ route('alumni.password.forgot') }}" class="back-btn">
            ← Change email
        </a>

        <h2>Reset Password</h2>
        <p class="subtitle">Enter your new password to reset your account</p>

        <form method="POST" action="{{ route('alumni.password.reset') }}">
            @csrf

            <div class="input-group password-group">
                <i class="fa-solid fa-lock"></i>
                <input
                    id="password-input"
                    type="password"
                    name="password"
                    placeholder="New Password"
                    required>
                <button type="button" class="toggle-password" data-target="password-input" aria-label="Show or hide new password">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <div class="input-group password-group">
                <i class="fa-solid fa-lock"></i>
                <input
                    id="confirm-password-input"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required>
                <button type="button" class="toggle-password" data-target="confirm-password-input" aria-label="Show or hide confirm password">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <p class="password-requirements">
                Password must be at least <span class="req-item" id="req-length">8 characters</span>, include <span class="req-item" id="req-uppercase">one uppercase letter</span>, 
                <span class="req-item" id="req-number">one number</span>, and <span class="req-item" id="req-special">one special character</span>.
            </p>

            @error('password')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="submit-btn">
                Reset Password
            </button>

        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password-input');
    const requirementChecks = {
        length: document.getElementById('req-length'),
        uppercase: document.getElementById('req-uppercase'),
        number: document.getElementById('req-number'),
        special: document.getElementById('req-special')
    };

    if (passwordInput) {
        const updateRequirements = function () {
            const value = passwordInput.value;
            const checks = {
                length: value.length >= 8,
                uppercase: /[A-Z]/.test(value),
                number: /\d/.test(value),
                special: /[^A-Za-z0-9]/.test(value)
            };

            Object.keys(requirementChecks).forEach(function (key) {
                if (!requirementChecks[key]) return;
                requirementChecks[key].classList.toggle('met', checks[key]);
            });
        };

        passwordInput.addEventListener('input', updateRequirements);
        updateRequirements();
    }

    document.querySelectorAll('.toggle-password').forEach(function (button) {
        button.addEventListener('click', function () {
            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = button.querySelector('i');
            if (!input || !icon) return;

            const showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !showPassword);
            icon.classList.toggle('fa-eye-slash', showPassword);
        });
    });
});
</script>

</body>
</html>
