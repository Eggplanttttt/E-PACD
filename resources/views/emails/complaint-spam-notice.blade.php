<!DOCTYPE html>
<html>
<body style="font-family: Arial;">

<h2>Hello {{ $complaint->name }},</h2>

<p>We have reviewed your recent complaint submitted to Quirino State University (E-PACD).</p>

<p><strong>Status:</strong> Reviewed</p>

<p><strong>Reason:</strong> {{ $reason }}</p>

@if(!empty($adminMessage))
  <p><strong>Message from Admin:</strong><br>
    {!! nl2br(e($adminMessage)) !!}
  </p>
@endif

@if(!empty($banText))
  <p style="color:#b00020;"><strong>Account Notice:</strong><br>
    {!! nl2br(e($banText)) !!}
  </p>
@endif

<p>If you believe this was a mistake, you may contact the E-PACD Administrator for further review.</p>

<br>

<p>Thank you,</p>
<p><strong>QSU E-PACD System</strong></p>

</body>
</html>