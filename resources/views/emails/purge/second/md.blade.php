<x-mail::message>
{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},<br><br>

{{ __('emails/purge/second.intro', [
'amount' => config('purge.users.second.limit'),
'duration' => config('purge.users.first.inactivity'),
'email' => $user->email
]) }}<br><br>
@if (!empty($campaigns))
{{ __('emails/purge/first.warning.campaigns', [
'email' => $user->email
]) }}<br>
@foreach ($campaigns as $campaign)
- [{{ $campaign->name }}]({{ route('dashboard', $campaign) }})
@endforeach
@else
{{ __('emails/purge/first.warning.account', [
'email' => $user->email
]) }}<br><br>
@endif

{{ __('emails/purge/first.keep', ['amount' => config('purge.users.second.limit')]) }}<br><br>

{{ __('emails/purge/first.assure') }}<br><br>

{!! __('emails/purge/first.help', [
'discord' => '[Discord](' . config('social.discord') . ')',
'email' => '[' . config('app.email') . '](mailto:' . config('app.email') . ')',
]) !!}<br><br>

_Jay & Jon_
</x-mail::message>