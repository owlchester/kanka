<x-mail::message>
# New password

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

{{ __('emails/activity/password.first') }}

{!! __('emails/activity/password.help', [
    'email' => '[' . config('app.email') . '](mailto:' . config('app.email') . ')'
]) !!}

_Jay & Jon_

</x-mail::message>

