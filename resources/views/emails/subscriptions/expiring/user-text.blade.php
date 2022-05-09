{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/expiring.primary', [
    'brand' => ucfirst($user->card_brand),
    'last' => $user->card_last_four,
]) }}

{{ __('emails/subscriptions/expiring.valid', ['action' => __('emails/subscriptions/expiring.action')]) }}

{{ __('emails/subscriptions/upcoming.closing') }}
The Kanka Team
https://kanka.io
