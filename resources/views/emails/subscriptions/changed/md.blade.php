<x-mail::message>
# Subscription change

Changed subscription for {{ $user->pledge }} [{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }}) (#{{ $user->id }}) [{{ $user->email }}](mailto:{{ $user->email }})

@if (!empty($custom))
**Reason provided:**

{!! nl2br(e($custom)) !!}

@elseif (!empty($reason))
**Reason provided:**

{{ __('settings.subscription.cancel.options.' . $reason) }}

@endif
</x-mail::message>