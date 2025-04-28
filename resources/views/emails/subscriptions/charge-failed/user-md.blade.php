<x-mail::message layout="user">

# Subscription issue

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

This is an automatic notification. We were unable to charge your card for your Kanka subscription. Our system will try again in a few days.

In the meantime, please verify your card details in your [billing information](https://app.kanka.io/settings/billing/payment-method?s=charge-failed"). If we are unable to charge your card, we'll unfortunately have to cancel your subscription to Kanka.

{{ __('emails/subscriptions/upcoming.closing') }}

_Jay & Jon_

</x-mail::message>
