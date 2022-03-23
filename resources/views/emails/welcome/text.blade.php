{{ __('emails/welcome.header', [
    'name' => $user->name
]) }}

{!! __('emails/welcome.header_sub', [
    'kanka' => 'Kanka (' . route('home') . ')',
]) !!}

{{ __('emails/welcome.section_1') }}

{!! __('emails/welcome.section_2', [
    'discord' => 'Discord (https:' . config('social.discord') . ')',
]) !!}

{!! __('emails/welcome.section_3', [
    'faq' => __('front.faq.title') . ' (' . route('faq.index') . ')',
]) !!}

{!! __('emails/welcome.section_4', [
    'youtube' => __('emails/welcome.section_5') . ' (https:' . config('social.youtube') . ')',
]) !!}

{{ __('emails/welcome.section_6') }}

{!! __('emails/welcome.section_7', [
    'facebook' => 'Facebook (https:' . config('social.facebook') . ')',
    'email' => config('app.email')
]) !!}

@if (!empty($user->provider))
    {{ __('emails/welcome.social_account', [
    'provider' => strtoupper($user->provider)
]) }}
@endif

{{ __('emails/welcome.section_8') }}

{!! __('emails/welcome.section_9_v2', [
    'pricing' => __('emails/welcome.pricing') . ' (' . route('front.pricing') . ')',
]) !!}

{!!  __('emails/welcome.section_11') !!}

Jay & Jon


