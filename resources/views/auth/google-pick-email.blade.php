<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Google Email Selected</title>
</head>
<body>
<script>
    // Send the email back to opener window
    if(window.opener) {
        window.opener.postMessage({ google_email: "{{ $email }}" }, window.location.origin);
        window.close(); // close popup
    }
</script>
</body>
</html>
