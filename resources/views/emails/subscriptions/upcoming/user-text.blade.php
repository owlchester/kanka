{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/upcoming.primary', [
    'brand' => ucfirst($user->card_brand),
    'last' => $user->card_last_four,
    'date' => $date->isoFormat('MMMM D, Y')
]) }}

{{ __('emails/subscriptions/upcoming.notice') }}

{{ __('emails/subscriptions/upcoming.valid') }}

{{ __('emails/subscriptions/upcoming.cancel', ['link' => __('emails/subscriptions/upcoming.link')]) }}


{{ __('emails/subscriptions/upcoming.closing') }}
The Kanka Team
https://kanka.io
