<x-mail::message layout="admin">
# New subscription trial accepted

New subscription trial for user [{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }}) (#{{ $user->id }}) {{ $user->email }}.

Account created {{ $user->created_at->diffForHumans() }} ({{ $user->created_at->format('d.m.Y') }}).

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

</x-mail::message>
