<x-mail::message>

{{ __('emails/subscriptions/yearly-nudge.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/yearly-nudge.body', ['tier' => $tierName, 'savings' => $savingsFormatted]) }}

{{ __('emails/subscriptions/yearly-nudge.proration') }}

<x-mail::button :url="route('settings.subscription')">
{{ __('emails/subscriptions/yearly-nudge.cta') }}
</x-mail::button>

{{ __('emails/subscriptions/yearly-nudge.closing') }}

__Jay & Jon__

</x-mail::message>
