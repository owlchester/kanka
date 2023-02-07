@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'elemental'
])

@section('content')
    <div style="display: none">You’re now an Elemental in Kanka</div>

    <p>Hi {{ $user->name }},</p>

    <p>Thank you for becoming an Elemental! We just wanted to write a few words to let you know that we appreciate your support, and that we’re here if you need anything. You can contact us via email, or you can also link your Kanka account to <a href="{{ config('discord.url') }}" target="_blank">Discord</a> in your <a href="{{ route('settings.apps') }}">account settings</a>, and get access to the exclusive Elemental channel there.
    </p>

    <p>You can now enjoy Kanka with bigger upload sizes, participate in <a href="{{ route('community-votes.index') }}">community votes</a>, and <a href="{{ route('settings.boost') }}">account boost</a> your campaigns.</p>

    <p style="text-align: center">
        <a href="{{ route('settings.boost', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'elemental']) }}" class="mail-btn">Boost my campaigns</a>
    </p>

    <p>Part of being an Elemental means that you get more say in how we shape community votes. If you have any priorities that you would like to see added, feel free to share them with us, and we will see how we can fit them into the votes, or if they overlap with requests made by other Elementals.
    </p>

    <p>Good to have you among us {{ $user->name }},</p>

    <p>
        Jay & Jon
    </p>

@endsection
