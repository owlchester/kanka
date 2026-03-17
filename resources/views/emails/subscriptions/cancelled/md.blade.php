<x-mail::message layout="admin">
# Subscription cancellation

[{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }}) cancelled.

**Reason:**

{{ __('settings.subscription.cancel.options.' . ($cancellation->reason === 'custom' ? 'other' : $cancellation->reason)) }}

@if (!empty($cancellation->secondary))
**Secondary:**

{{ __('subscriptions/cancellation.secondary.' . $cancellation->reason . '.' . $cancellation->secondary) }}
@endif

@if (!empty($cancellation->custom))
**Custom:**

> {!! nl2br(e($cancellation->custom)) !!}
@endif

**Subscribed since:**

{{ $user->subscription('kanka')?->created_at->isoFormat('MMMM D, Y') }}

</x-mail::message>
