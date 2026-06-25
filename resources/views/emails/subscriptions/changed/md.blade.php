<x-mail::message layout="admin">
# Subscription change

Downgraded [{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }}) (#{{ $user->id }}) [{{ $user->email }}](mailto:{{ $user->email }}) from **{{ $oldPledge ?? $user->pledge }}**@if (!empty($newTier)) → **{{ $newTier->name }}**@endif

@if (!empty($custom))
**Reason provided:**

{!! nl2br(e($custom)) !!}

@elseif (!empty($reason))
**Reason provided:**

{{ __('settings.subscription.cancel.options.' . $reason) }}

@endif
</x-mail::message>