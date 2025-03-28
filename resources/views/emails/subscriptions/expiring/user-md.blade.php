<x-mail::message>

# {{ __('emails/subscriptions/expiring.title') }}

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/expiring.primary', [
'brand' => ucfirst($user->pm_type),
'last' => $user->pm_last_four,
]) }}

{!! __('emails/subscriptions/expiring.valid', ['action' => '[' . __('emails/subscriptions/expiring.action') . '](' . route('billing.payment-method') . ')']) !!}

{{ __('emails/subscriptions/upcoming.closing') }}

_Jay & Jon_

</x-mail::message>
