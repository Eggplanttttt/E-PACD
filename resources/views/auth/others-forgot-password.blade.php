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
    <title>QSU E-PACD | Others Password Forgot</title>
    <link rel="icon" href="{{ asset('assets/shortcut_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('../assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('../css/forgot-client.css') }}">
</head>
<body>

<header class="header">
    <div class="logo-container">
        <a href="https://www.bagongpilipinastayo.com/" target="_blank" rel="noopener noreferrer" title="Bagong Pilipinas">
            <img src="{{ asset('assets/bagong-pilipinas_logo.png')}}" alt="bagong_pilipinas" class="bagong_pilipinas">
        </a>
        <a href="https://www.gov.ph/" target="_blank" rel="noopener noreferrer" class="gov" title="GOV.PH">GOV.PH</a>
        <a href="https://arta.gov.ph/" target="_blank" rel="noopener noreferrer" title="ARTA">
            <img src="{{ asset('assets/arta_logo.png')}}" alt="Arta" class="arta">
        </a>
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

        <a href="{{ route('client.login', ['clientType' => 'others']) }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>

        <h2>Forgot Password</h2>
        <p class="subtitle">Confirm your account with the same Facebook account you used to register, then you can reset your password.</p>

        @error('facebook')
            <p class="error-text">{{ $message }}</p>
        @enderror

        @error('email')
            <p class="error-text">{{ $message }}</p>
        @enderror

        <a href="{{ route('others.password.facebook.redirect') }}" class="submit-btn" id="verify-facebook-btn" style="display: inline-flex; justify-content: center; align-items: center; text-decoration: none;">
            Continue with Facebook
        </a>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const verifyBtn = document.getElementById('verify-facebook-btn');

    if (!verifyBtn) return;

    verifyBtn.addEventListener('click', function () {
        verifyBtn.style.pointerEvents = 'none';
        verifyBtn.textContent = 'Redirecting...';
    });
});
</script>

</body>
</html>
