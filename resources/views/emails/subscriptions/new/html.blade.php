<?php /** @var \App\User $user */?>
<!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        New subscription for user {{ $user->name }} (#{{ $user->id }}) <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>.
    </p>
    <p>Account created {{ $user->created_at }}.</p>

    @if ($discord = $user->apps->where('app', 'discord')->first())
        <p>
            Discord: {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }}
        </p>
    @endif
    @if ($user->referral)
        <p>Referral: {{ $user->referrer->code }}</p>
    @endif
</body>
</html>
