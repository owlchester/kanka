<x-mail::message>

{{ __('emails/subscriptions/paused.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/paused.body', ['date' => $resumeDate]) }}

{{ __('emails/subscriptions/paused.manage') }}

<x-mail::button :url="route('settings.subscription')">
{{ __('emails/subscriptions/paused.cta') }}
</x-mail::button>

{{ __('emails/subscriptions/paused.closing') }}

__Jay & Jon__

</x-mail::message>
