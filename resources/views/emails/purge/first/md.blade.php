<x-mail::message layout="user">
{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

@if (!empty($campaigns))
{{ __('emails/purge/first.intro_campaigns', [
'amount' => config('purge.users.first.limit'),
'duration' => config('purge.users.first.inactivity'),
]) }} {{ __('emails/purge/first.warning.campaigns', [
'email' => $user->email
]) }}

@foreach ($campaigns as $campaign)
- [{{ $campaign->name }}]({{ route('dashboard', $campaign) }})
@endforeach
@else
{{ __('emails/purge/first.intro_account', [
'amount' => config('purge.users.first.limit'),
'duration' => config('purge.users.first.inactivity')
]) }} {{ __('emails/purge/first.warning.account', [
'email' => $user->email
]) }}

@endif

{{ __('emails/purge/first.keep', ['amount' => config('purge.users.first.limit')]) }}

{{ __('emails/purge/first.assure') }}

{!! __('emails/purge/first.help', [
'discord' => '[Discord](' . config('social.discord') . ')',
'email' => '[' . config('app.email') . '](mailto:' . config('app.email') . ')',
]) !!}

_Jay & Jon_

</x-mail::message>
