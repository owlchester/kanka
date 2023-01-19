@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'expiring-card'
])

@section('content')
    <p>
        <strong>Subscription issue</strong>
    </p>
    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>
    <p>
        {{ __('emails/subscriptions/expiring.primary', [
    'brand' => ucfirst($user->card_brand),
    'last' => $user->card_last_four,
    ]) }}</p>

    <p>{!! __('emails/subscriptions/expiring.valid', ['action' => link_to_route('billing.payment-method', __('emails/subscriptions/expiring.action'))]) !!}</p>

    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team
    </p>

@endsection
