<x-mail::message>

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/upcoming.primary', [
    'brand' => ucfirst($user->pm_type),
    'last' => $user->pm_last_four,
    'date' => $date->isoFormat('MMMM D, Y')
]) }}

{{ __('emails/subscriptions/upcoming.notice') }}

{{ __('emails/subscriptions/upcoming.valid') }}

{!! __('emails/subscriptions/upcoming.cancel', ['link' =>  '[' . __('emails/subscriptions/upcoming.link') . '](' . route('settings.subscription') . ')']) !!}

{{ __('emails/subscriptions/upcoming.closing') }}

__Jay & Jon_

</x-mail::message>
