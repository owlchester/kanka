<?php /** @var \App\Models\User $user */?>
    <!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
<p>
    Changed subscription for {{ $user->pledge }} <a href="https://admin.kanka.io/users/{{ $user->id }}">{{ $user->name }}</a> (#{{ $user->id }}) <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>.
</p>
@if (!empty($custom))
    <p>
        <strong>Reason provided: </strong><br />
        {!! nl2br(e($custom)) !!}
    </p>
@elseif (!empty($reason))
    <p>
        <strong>Reason provided: </strong><br />
        {{ __('settings.subscription.cancel.options.' . $reason) }}<br />
    </p>
@endif
</body>
</html>
