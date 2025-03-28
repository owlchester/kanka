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
        This is an automatic notification. We tried and failed to charge your card three times, and subsequently your subscription has been automatically cancelled. We hope to see you back soon!
    </p>

    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<
        The Kanka Team
    </p>
@endsection
