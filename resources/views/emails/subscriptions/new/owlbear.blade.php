@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'owlbear'
])

@section('content')
    <div style="display: none">You’re now an Owlbear in Kanka</div>

    <p>Hi {{ $user->name }},</p>

    <p>Thank you for becoming a Owlbear! We just wanted to write a few words to let you know that we appreciate your support, and that we’re here if you need anything. You can contact us via email, or you can also link your Kanka account to <a href="{{ config('discord.url') }}" target="_blank">Discord</a> in your <a href="{{ route('settings.apps') }}">account settings</a>, and get access to the exclusive Owlbear channel there.
    </p>

    <p>You can now enjoy Kanka with bigger upload sizes, participate in <a href="{{ route('community-votes.index') }}">community votes</a>, and <a href="{{ route('settings.boost') }}">account boost</a> your campaigns.</p>

    <p style="text-align: center">
        <a href="{{ route('settings.boost', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'owlbear']) }}" class="mail-btn">Boost my campaigns</a>
    </p>

    <p>Good to have you among us {{ $user->name }},</p>

    <p>
        Jay & Jon
    </p>

@endsection
