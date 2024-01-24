@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'failed-charge'
])

@section('content')
    <p>
        <strong>Email Validation</strong>
    </p>
    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>

    <p>This is an automatic notification.</p>
    <p>To validate the email for your Kanka account click <a href="{{ 'https://app.kanka.io/users/' . $user->id . '/validation?token=' . $token }}">here</a>. This link will expire in 24 hours.</p>
    <p>If the above link doesnt work, open the following URL in your web browser {{ 'https://app.kanka.io/users/' . $user->id . '/validation?token=' . $token }}</p>
    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team
    </p>

@endsection
