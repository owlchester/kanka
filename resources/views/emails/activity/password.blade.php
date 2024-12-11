<?php /** @var \App\Models\User $user */?>
@extends('emails.base', [
    'utmSource' => 'activity',
    'utmCampaign' => 'password'
])

@section('content')

    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>

    <p>{{ __('emails/activity/password.first') }}</p>

    <p>{!! __('emails/activity/password.help', [
        'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>'
    ]) !!}</p>

    <i>Jay & Jon</i>
@endsection
