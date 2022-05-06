<!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>
    <p>
        {{ __('emails/subscriptions/expiring.primary', [
    'brand' => ucfirst($user->card_brand),
    'last' => $user->card_last_four,
    ]) }}</p>

    <p>{!! __('emails/subscriptions/expiring.valid', ['action' => link_to_route('settings.billing', __('emails/subscriptions/expiring.action'))]) !!}</p>

    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team<br />
        <a href="https://kanka.io/{{ $user->locale }}">https://kanka.io/{{ $user->locale }}</a>
    </p>

</body>
</html>
