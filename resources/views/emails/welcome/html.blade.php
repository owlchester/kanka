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
        <a href="{{ route('home', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding']) }}" class="mail-btn">{{ __('emails/welcome.2023.intro.link') }}</a>
    </p>

    <p><b>{{ __('emails/welcome.2023.basics.title') }}</b></p>
    <p>{!! __('emails/welcome.2023.basics.text_1', [
        'kb' => '<a target="_blank" href="https://kanka.io/kb">' . __('footer.kb') . '</a>',
        'doc' => '<a target="_blank" href="https://docs.kanka.io/en/latest/index.html"> ' . __('footer.documentation') . '</a>',
    ]) !!}</p>

    <p><b>{{ __('emails/welcome.2023.chat.title') }}</b></p>
    <p>{!! __('emails/welcome.2023.chat.text_1', [
        'discord' => '<a href="https://kanka.io/go/discord">Discord</a>',
        'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>'
    ]) !!}</p>

    <i>Jay & Jon</i>
@endsection
