<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>
<body>
    <h2>Password Reset Request</h2>
    <p>We received a request to reset your password. Use the OTP below to continue:</p>

    <p style="font-size: 24px; font-weight: bold; color: #007bff;">{{ $otp }}</p>

    <p>This OTP is valid for <strong>10 minutes</strong>. Do not share it with anyone.</p>

    <p>If you did not request a password reset, you can safely ignore this email.</p>
</body>
</html>
