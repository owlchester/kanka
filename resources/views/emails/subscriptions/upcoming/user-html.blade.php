@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'failed-charge'
])

@section('content')
    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>
    <p>
        {{ __('emails/subscriptions/upcoming.primary', [
    'brand' => ucfirst($user->card_brand),
    'last' => $user->card_last_four,
    'date' => $date->isoFormat('MMMM D, Y')
    ]) }}</p>

    <p>{{ __('emails/subscriptions/upcoming.notice') }}</p>

    <p>{{ __('emails/subscriptions/upcoming.valid') }}</p>

    <p>{!! __('emails/subscriptions/upcoming.cancel', ['link' => link_to_route('settings.subscription', __('emails/subscriptions/upcoming.link'))]) !!}</p>

    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team
    </p>
@endsection
