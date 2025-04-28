<x-mail::message layout="user">

Hi {{ $user->name }},

Thank you for becoming an {{ $tier->name }}! We just wanted to write a few words to let you know that we appreciate your support, and that we’re here if you need anything. You can contact us via email, or you can also link your Kanka account to [Discord]({{ config('discord.url') }}) in your [account settings]({{ route('settings.apps') }}), and get access to the exclusive {{ $tier->name }} channel there.

You can now enjoy Kanka with bigger upload sizes, vote on the [roadmap]({{ route('roadmap') }}), and [premium campaigns]({{ route('settings.premium') }}).

<x-mail::button url="{{ route('settings.premium', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => $tier->code]) }}" color="blue">
Unlock premium features
</x-mail::button>

Part of being an Elemental means that you get more say in how we shape community votes. If you have any priorities that you would like to see added, feel free to share them with us, and we will see how we can fit them into the votes, or if they overlap with requests made by other Elementals.

Good to have you among us {{ $user->name }},

_Jay & Jon_

</x-mail::message>
