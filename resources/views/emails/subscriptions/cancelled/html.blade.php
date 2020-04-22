<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        Cancelled subscription for user {{ $user->name }} (#{{ $user->id }}) <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>.
    </p>

    @if ($reason)
        <p>
            <strong>Reason provided: </strong><br />
            {!! nl2br(e($reason)) !!}
        </p>
    @endif
</body>
</html>
