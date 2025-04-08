<!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        Dear {{ $user->name }},
    </p>
    <p>We're having trouble charging your payment method. Please verify your details in your Kanka account and update them if necessary. We'll try again in a few days. If the charge fails 3 times, your subscription will be automatically cancelled.
    </p>
    <p>The Kanka Team</p>
</body>
</html>
