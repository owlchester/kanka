<x-mail::message layout="admin">
@if ($trial)
# Free trial conversion
@else
# New subscription
@endif

User [{{ $user->email }}](mailto:{{ $user->email }}) [{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }})
Currency: {{ $user->currencySymbol() }}

Account created {{ $user->created_at->diffForHumans() }} ({{ $user->created_at->format('d.m.Y') }}).

@if ($trial)
Trial started on {{ $trial->created_at->format('d.m.Y') }}.
@endif

@if ($lastCancel)
Previously cancelled {{ $lastCancel->tier }} subscription {{ $lastCancel->created_at->diffForHumans() }} ({{ $lastCancel->created_at->format('d.m.Y') }}).

**Reason provided:**

{{ $lastCancel->reason }}

@if (!empty($lastCancel->custom))
**Custom message:**

{!! nl2br(e($lastCancel->custom)) !!}

@endif
@endif
@if ($discord = $user->apps->where('app', 'discord')->first())
Discord: {{ $discord->settings['username'] }}

@endif
@if ($user->referral)
Referral: {{ $user->referrer->code }}

@endif
@if (!empty($user->settings['tracking']))
Ad campaign
{{ is_array($user->settings['tracking']) ? collect($user->settings['tracking'])->implode(' ') : $user->settings['tracking'] }}

@endif

</x-mail::message>
