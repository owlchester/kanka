<x-mail::message layout="admin">
# Subscription cancellation

[{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }}) cancelled.

@if (!empty($custom))
**Reason:**

{!! nl2br(e($custom)) !!}
@elseif (!empty($reason))
**Reason:**

{{ __('settings.subscription.cancel.options.' . $reason) }}
@endif

**Subscribed since:**
{{ $user->subscription('kanka')?->created_at->isoFormat('MMMM D, Y') }}

</x-mail::message>