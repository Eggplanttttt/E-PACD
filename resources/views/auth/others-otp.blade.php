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
    <title>QSU E-PACD | Others Email OTP</title>
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

        <a href="{{ route('others.password.forgot') }}" class="back-btn">
            ← Change email
        </a>

        <h2>Verify OTP</h2>
        <p class="subtitle">Enter the OTP sent to your email</p>

        <form method="POST" action="{{ route('others.password.otp.verify') }}" id="verify-otp-form">
            @csrf

            <div class="input-group">
                <input type="text" name="otp" placeholder="Enter OTP" required>
            </div>

            @error('otp')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="submit-btn" id="verify-otp-btn">
                Verify OTP
            </button>
        </form>

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const verifyOtpForm = document.getElementById('verify-otp-form');
    const verifyOtpBtn = document.getElementById('verify-otp-btn');

    if (!verifyOtpForm || !verifyOtpBtn) return;

    verifyOtpForm.addEventListener('submit', function () {
        verifyOtpBtn.disabled = true;
        verifyOtpBtn.textContent = 'Verifying...';
    });
});
</script>
</body>
</html>
