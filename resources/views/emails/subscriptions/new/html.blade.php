<?php /** @var \App\Models\User $user */?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        New subscription for user <a href="https://admin.kanka.io/users/{{ $user->id }}">{{ $user->name }}</a> in {{ $user->currencySymbol() }} (#{{ $user->id }}) {{ $user->email }}.
    </p>
    <p>
        Account created {{ $user->created_at->diffForHumans() }} ({{ $user->created_at->format('d.m.Y') }}).
    </p>

    @if ($lastCancel)
        <p>
            Previously cancelled {{ $lastCancel->tier }} subscription {{ $lastCancel->created_at->diffForHumans() }} ({{ $lastCancel->created_at->format('d.m.Y') }}).
        </p>
        <p>
            <strong>Reason provided: </strong><br />
            {{ $lastCancel->reason }}<br />
        </p>
        @if (!empty($lastCancel->custom))
            <p>
                <strong>Custom message: </strong><br />
                {!! nl2br(e($lastCancel->custom)) !!}
            </p>
        @endif
    @endif
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
