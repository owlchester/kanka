<x-mail::message>
# Updated Email

{{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},

{{ __('emails/activity/email.first', [
    'email' => '[' . $user->email . '](mailto:' . $user->email . ')'
]) }}

{!! __('emails/activity/password.help', [
    'email' => '[' . config('app.email') . '](mailto:' . config('app.email') . ')'
]) !!}

_Jay & Jon_

</x-mail::message>
