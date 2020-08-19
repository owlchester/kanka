<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>

    <p>
        Dear {{ $user->name }},
    </p>
    <p>
        Your subscription to Kanka has been cancelled. We're sorry to see you go, and hope to see you back soon!
    </p>

    @if ($reason)
        <p>
            <strong>Reason provided: </strong><br />
            {!! nl2br(e($reason)) !!}
        </p>
    @endif
    <p>The Kanka Team</p>
</body>
</html>
