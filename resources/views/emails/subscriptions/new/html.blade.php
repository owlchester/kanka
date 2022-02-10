<?php /** @var \App\User $user */?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        New subscription for user <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a> in {{ $user->currencySymbol() }} (#{{ $user->id }}) <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>.
    </p>
    <p>
        Account created {{ $user->created_at->diffForHumans() }} ({{ $user->created_at->format('d.m.Y') }}).
    </p>

    @if ($discord = $user->apps->where('app', 'discord')->first())
        <p>
            Discord: {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }}
        </p>
    @endif
    @if ($user->referral)
        <p>Referral: {{ $user->referrer->code }}</p>
    @endif
    @if (!empty($user->settings['tracking']))
        <dt>Ad campaign</dt>
        <dd>{{ $user->settings['tracking'] }}</dd>
    @endif
</body>
</html>
