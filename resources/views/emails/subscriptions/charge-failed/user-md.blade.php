<x-mail::message>

**Subscription issue**<br><br>

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},<br><br>

This is an automatic notification. We were unable to charge your card for your Kanka subscription. Our system will try again in a few days.<br><br>

In the meantime, please verify your card details in your [billing information](https://app.kanka.io/settings/billing/payment-method?s=charge-failed"). If we are unable to charge your card, we'll unfortunately have to cancel your subscription to Kanka.<br><br>

{{ __('emails/subscriptions/upcoming.closing') }}<br><br>

The Kanka Team.

</x-mail::message>
