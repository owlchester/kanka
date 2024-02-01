@extends('emails.base', [
    'utmSource' => 'validation',
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
    <p>To validate the email for your Kanka account click <a href="{{ $url }}">here</a>. This link will expire in 24 hours.</p>
    <p>If the above link doesnt work, open the following URL in your web browser {{ $url }}</p>
    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team
    </p>

@endsection
