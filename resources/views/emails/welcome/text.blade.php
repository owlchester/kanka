{{ __('auth.register.welcome_email.header', [
    'name' => $user->name
]) }}

{!! __('auth.register.welcome_email.header_sub', [
    'kanka' => 'Kanka (' . route('home') . ')',
]) !!}

{{ __('auth.register.welcome_email.section_1') }}

{!! __('auth.register.welcome_email.section_2', [
    'discord' => 'Discord (https://' . config('social.discord') . ')',
]) !!}

{!! __('auth.register.welcome_email.section_3', [
    'faq' => __('front.faq.title') . '(' . route('faq.index') . ')',
]) !!}

{!! __('auth.register.welcome_email.section_4', [
    'youtube' => __('auth.register.welcome_email.section_5') . '(https://' . config('social.youtube') . ')',
]) !!}

{{ __('auth.register.welcome_email.section_6') }}

{!! __('auth.register.welcome_email.section_7', [
    'facebook' => 'Facebook (https://' . config('social.facebook') . ')',
    'email' => 'hello@kanka.io'
]) !!}

{{ __('auth.register.welcome_email.section_8') }}

{!! __('auth.register.welcome_email.section_9', [
    'patrons' => __('auth.register.welcome_email.section_10') . '(https://' . config('patreon.url') . ')',
]) !!}

{!!  __('auth.register.welcome_email.section_11') !!}

Jay & Jon


