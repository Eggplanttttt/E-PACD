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
    <title>QSU E-PACD | Faculty Password Forgot</title>
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

        <a href="{{ route('client.login', ['clientType' => 'faculty']) }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>


        <h2>Forgot Password</h2>

        @if(session('reset_otp_sent'))
            <p class="subtitle">Enter the OTP sent to your email to continue</p>

            <form method="POST" action="{{ route('faculty.password.otp.verify') }}">
                @csrf

                <div class="input-group">
                    <i class="fa-solid fa-key"></i>
                    <input
                        type="text"
                        name="otp"
                        placeholder="Enter OTP"
                        required>
                </div>

                @error('otp')
                    <p class="error-text">{{ $message }}</p>
                @enderror

                <button type="submit" class="submit-btn">
                    Verify OTP
                </button>
            </form>

        @else
            <p class="subtitle">Enter your Libris email to verify your account</p>

            <form method="POST" action="{{ route('faculty.password.verify') }}" id="verify-email-form">
                @csrf

                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your Libris email"
                        required>
                </div>

                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror

                <button type="submit" class="submit-btn" id="verify-email-btn">
                    Verify Email
                </button>
            </form>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const verifyForm = document.getElementById('verify-email-form');
    const verifyBtn = document.getElementById('verify-email-btn');

    if (!verifyForm || !verifyBtn) return;

    verifyForm.addEventListener('submit', function () {
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Sending...';
    });
});
</script>

</body>
</html>
