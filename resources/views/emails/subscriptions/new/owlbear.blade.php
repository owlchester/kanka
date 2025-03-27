
<x-mail::message>

Hi {{ $user->name }},<br><br>

Thank you for becoming a {{ $tier->name }}! We just wanted to write a few words to let you know that we appreciate your support, and that we’re here if you need anything. You can contact us via email, or you can also link your Kanka account to [Discord]({{ config('discord.url') }}) in your [account settings]({{ route('settings.apps') }}), and get access to the exclusive {{ $tier->name }} channel there.<br><br>

You can now enjoy Kanka with bigger upload sizes, vote on the [roadmap]({{ route('roadmap') }}), and [premium campaigns]({{ route('settings.premium') }}).<br>

<x-mail::button url="{{ route('settings.premium', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => $tier->code]) }}" color="blue">
Unlock premium features
</x-mail::button>

Good to have you among us {{ $user->name }},<br><br>

Jay & Jon

</x-mail::message>

