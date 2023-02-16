@extends('emails.base', [
    'utmSource' => 'newsletter',
    'utmCampaign' => 'onboarding'
])

@section('content')
    <div style="display: none">{{ __('emails/welcome.2023.preview', ['name' => $user->name]) }}</div>

    <p><b>{{ __('emails/welcome.2023.intro.header', [
        'name' => $user->name
    ]) }}</b></p>

    <p>{{ __('emails/welcome.2023.intro.text_1', ['name' => $user->name]) }}</p>
    <p>{{ __('emails/welcome.2023.intro.text_2') }}</p>

    <p style="text-align: center;">
        {!! link_to_route('home', __('emails/welcome.2023.intro.link'), ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding'], ['class' => 'mail-btn']) !!}
    </p>

    <p><b>{{ __('emails/welcome.2023.basics.title') }}</b></p>
    <p>{!! __('emails/welcome.2023.basics.text_1', [
        'kb' => link_to_route('front.faqs.index', __('front.menu.kb')),
        'doc' => link_to('https://docs.kanka.io/en/latest/index.html', __('front.menu.documentation')),
    ]) !!}</p>

    <p><b>{{ __('emails/welcome.2023.chat.title') }}</b></p>
    <p>{!! __('emails/welcome.2023.chat.text_1', [
        'discord' => link_to('https:' . config('social.discord'), 'Discord'),
        'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>'
    ]) !!}</p>

    <i>Jay & Jon</i>
@endsection
