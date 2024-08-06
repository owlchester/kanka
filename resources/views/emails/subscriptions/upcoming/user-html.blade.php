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
    'brand' => ucfirst($user->pm_type),
    'last' => $user->pm_last_four,
    'date' => $date->isoFormat('MMMM D, Y')
    ]) }}</p>

    <p>{{ __('emails/subscriptions/upcoming.notice') }}</p>

    <p>{{ __('emails/subscriptions/upcoming.valid') }}</p>

    <p>{!! __('emails/subscriptions/upcoming.cancel', ['link' =>  '<a href="' . route('settings.subscription') . '">' . __('emails/subscriptions/upcoming.link') . '</a>']) !!}</p>

    <p>
        {{ __('emails/subscriptions/upcoming.closing') }}<br />
        The Kanka Team
    </p>
@endsection
