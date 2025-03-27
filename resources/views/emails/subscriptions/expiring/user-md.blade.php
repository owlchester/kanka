<x-mail::message>

**Subscription issue**<br><br>

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},<br><br>

{{ __('emails/subscriptions/expiring.primary', [
'brand' => ucfirst($user->pm_type),
'last' => $user->pm_last_four,
]) }}<br><br>

{!! __('emails/subscriptions/expiring.valid', ['action' => '[' . __('emails/subscriptions/expiring.action') . '](' . route('billing.payment-method') . ')']) !!}<br><br>

{{ __('emails/subscriptions/upcoming.closing') }}<br><br>

The Kanka Team

</x-mail::message>
