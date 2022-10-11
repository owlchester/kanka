@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'failed-charge'
])

@section('content')

    <p>
        <strong>Subscription issue</strong>
    </p>
    <p>
        Dear {{ $user->name }},
    </p>

    <p>It appears that we were unable to charge your card for your Kanka subscription. We will try again in a few days.</p>

    <p>In the meantime, please verify your card details in your <a href="https://kanka.io/en-US/settings/billing-information?s=charge-failed">billing information</a>. If we are unable to charge your card, we'll unfortunately have to cancel your subscription to Kanka.</p>

    <p>Jay & Jon</p>

@endsection
