<!DOCTYPE html>
<html lang="en">
<head>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        .content {
            border-radius: 15px;
            max-width: 700px;
            background-color: #fff;
            padding: 20px;
            margin: -200px auto 60px auto;
            left: 0;
            right: 0;
        }
        .header {
            height: 420px !important;
        }
        @media(max-width: 992px) {
            .content {
                width: auto;
                margin: 0 10%;
            }
        }
        @media(max-width: 768px) {
            .content {
                width: auto;
                margin: 0 5%
            }
        }
    </style>
    <div style="font-family: 'Open Sans', sans-serif; background-color: #eee; margin: 0 0 20px 0;">

        <div class="header" style="background-image: url(https://kanka-app-assets.s3.amazonaws.com/emails/email-banner.jpg); background-position: top center; background-size: cover; width: 100%; height: 220px; text-align: center;">
            <a href="{{ route('home', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding']) }}">
            <img src="https://kanka-app-assets.s3.amazonaws.com/images/logos/logo-blue-white.png" alt="Kanka logo" title="Kanka logo" style="margin: 50px;" width="120px" height="120px">
            </a>
        </div>

        <div class="content" style="background-color: #fff; padding: 20px;">
            <p><b>{{ __('auth.register.welcome_email.header', [
                'name' => $user->name
            ]) }}</b></p>
            <p>{!! __('auth.register.welcome_email.header_sub', [
                'kanka' => link_to_route('home', 'Kanka', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding'])
            ]) !!}</p>

            <p><b>{{ __('auth.register.welcome_email.section_1') }}</b></p>
            <p>{!! __('auth.register.welcome_email.section_2', [
                'discord' => link_to(config('social.discord'), 'Discord'),
            ]) !!}</p>
            <p>{!! __('auth.register.welcome_email.section_3', [
                'faq' => link_to_route('faq.index', __('front.faq.title'))
            ]) !!}</p>
            <p>{!! __('auth.register.welcome_email.section_4', [
                'youtube' => link_to(config('social.youtube'), __('auth.register.welcome_email.section_5'))
            ]) !!}</p>

            <p><b>{{ __('auth.register.welcome_email.section_6') }}</b></p>
            <p>{!! __('auth.register.welcome_email.section_7', [
                'facebook' => link_to(config('social.facebook'), 'Facebook'),
                'email' => '<a href="mailto:hello@kanka.io">hello@kanka.io</a>'
            ]) !!}</p>

            <p><b>{{ __('auth.register.welcome_email.section_8') }}</b></p>
            <p>{!! __('auth.register.welcome_email.section_9', [
                'patrons' => link_to(config('patreon.url'), __('auth.register.welcome_email.section_10')),
            ]) !!}</p>

            <p><b>{!! link_to_route('home', __('auth.register.welcome_email.section_11'), ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding']) !!}</b></p>

            <i>Jay & Jon</i>
        </div>
    </div>
</body>
</html>
