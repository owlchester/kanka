@extends('emails.base', [
    'utmSource' => 'newsletter',
    'utmCampaign' => 'onboarding'
])

@section('content')
    <p><b>{{ __('emails/welcome.header', [
        'name' => $user->name
    ]) }}</b></p>
    <p>{!! __('emails/welcome.header_sub', [
        'kanka' => link_to_route('home', 'Kanka', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding'])
    ]) !!}</p>

    <p><b>{{ __('emails/welcome.section_1') }}</b></p>
    <p>{!! __('emails/welcome.section_2', [
        'discord' => link_to('https:' . config('social.discord'), 'Discord'),
    ]) !!}</p>
    <p>{!! __('emails/welcome.section_4_v2', [
        'knowledge-base' => link_to_route('front.faqs.index', __('front.menu.kb')),
        'documentation' => link_to('https://docs.kanka.io/en/latest/index.html', __('front.menu.documentation')),
        'youtube' => link_to('https:' . config('social.youtube'), 'Youtube')
    ]) !!}</p>

    <p><b>{{ __('emails/welcome.section_6') }}</b></p>
    <p>{!! __('emails/welcome.section_7', [
        'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>'
    ]) !!}</p>

    @if (!empty($user->provider))
        <p>{{ __('emails/welcome.social_account', ['provider' => strtoupper($user->provider)]) }}</p>
    @endif

    <p><b>{{ __('emails/welcome.section_8') }}</b></p>

    <p>{!! __('emails/welcome.section_9_v2', [
        'pricing' => link_to_route('front.pricing', __('emails/welcome.pricing')),
    ]) !!}</p>

    <p><b>{!! link_to_route('home', __('emails/welcome.section_11'), ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding']) !!}</b></p>

    <i>Jay & Jon</i>
@endsection
