<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You - QSU E-PACD</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { background: #fff; max-width: 600px; margin: 40px auto; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { text-align: center; }
        .header img { height: 80px; margin-bottom: 10px; }
        h1 { color: #2c3e50; }
        p { color: #34495e; font-size: 16px; line-height: 1.5; }
        .button { display: inline-block; padding: 12px 20px; background: #2980b9; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/shortcut_logo.png') }}" alt="QSU Logo">
            <h1>Quirino State University</h1>
            <h2>E-Public Assistance & Complaint Desk (E-PACD)</h2>
        </div>

        <p>Dear {{ $name }},</p>

        <p>Thank you for submitting your complaint to Quirino State University's Electronic Public Assistance and Complaint Desk (E-PACD). Your concern has been received and is currently under review by our team.</p>

        <p>We appreciate your patience and assure you that your issue will be addressed promptly. You may receive a follow-up email once your complaint is resolved.</p>

        <p>Thank you for helping us improve our services.</p>

        <a href="{{ url('assets/shortcut_logo.png') }}" class="button">Visit QSU E-PACD</a>

        <div class="footer">
            &copy; {{ date('Y') }} Quirino State University. All rights reserved.
        </div>
    </div>
</body>
</html>
