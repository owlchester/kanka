<?php /** @var \App\Models\Tier $tier */ ?>
@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => $tier->code
])

@section('content')
    <div style="display: none">You’re now a {{ $tier->name }} in Kanka</div>

    <p>Hi {{ $user->name }},</p>

    <p>Thank you for becoming a {{ $tier->name }}! We just wanted to write a few words to let you know that we appreciate your support, and that we’re here if you need anything. You can contact us via email, or you can also link your Kanka account to <a href="{{ config('discord.url') }}" target="_blank">Discord</a> in your <a href="{{ route('settings.apps') }}">account settings</a>, and get access to the exclusive {{ $tier->name }} channel there.
    </p>

    <p>You can now enjoy Kanka with bigger upload sizes, vote on the <a href="{{ route('roadmap') }}">roadmap</a>, and <a href="{{ route('settings.premium') }}">premium campaigns</a>.</p>

    <p style="text-align: center">
        <a href="{{ route('settings.premium', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => $tier->code]) }}" class="mail-btn">Unlock premium features</a>
    </p>

    <p>Good to have you among us {{ $user->name }},</p>

    <p>
        Jay & Jon
    </p>

@endsection
