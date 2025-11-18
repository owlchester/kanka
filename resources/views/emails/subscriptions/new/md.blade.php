<x-mail::message layout="admin">
@if ($trial)
# Free trial conversion
@else
# New subscription
@endif

- **User ID:** {{ $user->id }}
- **Username:** [{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }})
- **Email:** {{ $user->email }}
- **Account age:** {{ $user->created_at->diffForHumans() }} ({{ $user->created_at->format('d.m.Y') }})
- **Subscription tier:** {{ $user->tier ?? 'N/A' }}
- **Subscription currency:** {{ $user->currencySymbol() }}
- **User country:** {{ $user->country ?? 'N/A' }}

@if ($trial)
- **Trial started:** {{ $trial->created_at->format('d.m.Y') }}
@endif

@if ($lastCancel)
---

### Previous subscription info

- **Previously cancelled:** {{ $lastCancel->tier }}  
  {{ $lastCancel->created_at->diffForHumans() }} ({{ $lastCancel->created_at->format('d.m.Y') }})

- **Reason provided:**  
  {{ $lastCancel->reason }}

@if (!empty($lastCancel->custom))
- **Custom message:**  
  {!! nl2br(e($lastCancel->custom)) !!}
@endif
@endif

@if ($discord = $user->apps->where('app', 'discord')->first())
- **Discord:** {{ $discord->settings['username'] }}
@endif

@if ($user->referral)
- **Referral:** {{ $user->referrer->code }}
@endif

@if (!empty($user->settings['tracking']))
- **Ad campaign:**  
  {{ is_array($user->settings['tracking']) ? collect($user->settings['tracking'])->implode(' ') : $user->settings['tracking'] }}
@endif

</x-mail::message>
