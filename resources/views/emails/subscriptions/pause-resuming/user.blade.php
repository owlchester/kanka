<x-mail::message>

{{ __('emails/subscriptions/pause-resuming.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/pause-resuming.body', ['date' => $resumeDate]) }}

{{ __('emails/subscriptions/pause-resuming.manage') }}

<x-mail::button :url="route('settings.subscription')">
{{ __('emails/subscriptions/pause-resuming.cta') }}
</x-mail::button>

{{ __('emails/subscriptions/pause-resuming.closing') }}

__Jay & Jon__

</x-mail::message>
