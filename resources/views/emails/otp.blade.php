<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSU Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .otp-code {
            font-size: 1.5em;
            color: #2E86C1;
        }
    </style>
</head>
<body>
    <h2>QSU Email Verification</h2>
    <p>Your OTP code is: <strong class="otp-code">{{ $otp }}</strong></p>
    <p>This code will expire in 5 minutes.</p>
</body>
</html>
