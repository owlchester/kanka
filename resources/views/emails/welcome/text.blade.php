
{!! __('emails/welcome.2023.intro.text_1', [
    'name' => $user->name,
]) !!}

{!! __('emails/welcome.2023.intro.text_2') !!}

{{ __('emails/welcome.2023.basics.title') }}

{!! __('emails/welcome.2023.basics.text_1', [
    'kb' => __('front.menu.kb') . ' (' . route('front.faqs.index') . ')',
    'doc' => __('front.menu.documentation') . ' (https://docs.kanka.io/en/latest/index.html)',
]) !!}

{{ __('emails/welcome.2023.chat.title') }}

{!! __('emails/welcome.2023.chat.text_1', [
    'email' => config('app.email'),
    'discord' => 'Discord (https:' . config('social.discord') . ')',
]) !!}


Jay & Jon


