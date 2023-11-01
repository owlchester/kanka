@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'failed-charge'
])

@section('content')
    <p>
        <strong>Subscription issue</strong>
    </p>
    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>

    <p>This is an automatic notification. We were unable to charge your card for your Kanka subscription. Our system will try again in a few days.</p>

    <p>In the meantime, please verify your card details in your <a href="https://app.kanka.io/settings/billing/payment-method?s=charge-failed">billing information</a>. If we are unable to charge your card, we'll unfortunately have to cancel your subscription to Kanka.</p>

    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team
    </p>

@endsection
