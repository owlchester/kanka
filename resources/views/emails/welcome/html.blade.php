<head>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #eee;
            padding: 0;
            margin: 0;
        }
        .header {
            background-image: url(https://kanka-app-assets.s3.amazonaws.com/emails/email-banner.jpg);
            background-position: top center;
            background-size: cover;
            width: 100%;
            height: 420px;
            position: relative;
            text-align: center;
        }
        .header img {
            margin: 50px;
            width: 120px;
            height: 120px;
        }
        .content {
            border-radius: 15px;
            max-width: 700px;
            background-color: #fff;
            padding: 20px;
            position: absolute;
            top: 220px;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            margin-bottom: 30px;
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
    <div class="header">
        <a href="{{ route('home', ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => 'onboarding']) }}">
        <img src="https://kanka-app-assets.s3.amazonaws.com/emails/kanka_transparent.png" alt="Kanka logo" title="Kanka logo">
        </a>
    </div>

    <div class="content">
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
</body>


