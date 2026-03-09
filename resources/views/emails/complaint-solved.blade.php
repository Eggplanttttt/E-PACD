<!DOCTYPE html>
<html>
<head>
    <title>Complaint Solved</title>
</head>
<body>
    <p>Dear {{ $complaint->name ?? 'Complainant' }},</p>

    <p>
        We would like to inform you that your complaint has been successfully addressed and marked as
        <strong>solved</strong>.
    </p>

    <p><strong>Resolution Details:</strong></p>
    <ul>
        <li><strong>Sent to:</strong> {{ $complaint->sent_to }}</li>
        <li><strong>Date sent:</strong> {{ \Carbon\Carbon::parse($complaint->sent_date)->format('F d, Y') }}</li>
        <li><strong>Action taken:</strong> {{ $complaint->action_taken }}</li>
        <li><strong>Date action completed:</strong> {{ \Carbon\Carbon::parse($complaint->action_date)->format('F d, Y') }}</li>
        <li><strong>Status:</strong> {{ $complaint->status }}</li>
    </ul>

    <p><strong>Your Original Complaint:</strong></p>
    <p style="white-space: pre-line;">
        {{ $originalMessage ?? 'N/A' }}
    </p>

    <p>
        Our team has taken appropriate action to resolve your concern. We assure you that we take all complaints seriously
        and will continue to provide assistance if needed.
    </p>

    <p>Thank you for using QSU E-PACD.</p>

    <p>Best regards,<br>QSU E-PACD Team</p>
</body>
</html>