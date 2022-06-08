<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content='width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no'>
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="description" content="{{ $metaDescription ?? __('front.home.seo.meta-description', ['kanka' =>  config('app.name')]) }}">
    <meta name="keywords" content="{{  $metaKeywords ?? __('front.seo.keywords') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title', ['kanka' =>  config('app.name')]) }}@if (!isset($skipEnding)) - {{ config('app.name') }} @endif">
    <meta property="og:site_name" content="{{ config('app.site_name') }}">
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image" content="https://kanka-app-assets.s3.amazonaws.com/images/front/preview-background.png" />
    <meta name="twitter:image:alt" content="{{ config('app.name') }} showcase of a character view" />
@if(config('services.facebook.client_id'))  <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />@endif

    @yield('og')
@if(config('app.admin'))
    <meta property="og:image" content="https://kanka-app-assets.s3.amazonaws.com/images/front/preview-background.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="1024" />
    <meta property="og:image:alt" content="{{ config('app.name') }} showcase of a character view" />
    <script type="application/ld+json">
      {
        "@id": "#product",
        "@type": "WebApplication",
        "@context": "http://schema.org/",
        "name": "{{ config('app.name') }}",
        "description": "{{ $metaDescription ?? __('front.home.seo.meta-description') }}",
        "url": "{{ config('app.url') }}",
        "applicationCategory": "Game, Note taking",
        "operatingSystem": "all",
        "image": ["https://images.kanka.io/app/Kerln0-2BWKISMgR-n-KvMXOY3o=/1920x1024/smart/src/images%2Ffront%2Fpreview-background.png"],
        "screenshot": "https://images.kanka.io/app/xbbBJtRB3dtY-NMTtXNylNk1-UM=/600x320/smart/src/images%2Ffront%2Fpreview-background.png",
        "creator": {
          "@type": "Organization",
          "@id": "#organization",
          "url": "{{ config('app.url') }}",
          "name": "{{ config('app.name') }}",
          "logo": { "@type": "ImageObject", "url": "https://kanka-app-assets.s3.amazonaws.com/images/logos/logo-small.png", "width": "226", "height": "205" }
        }
      }
    </script>@endif

    <title>{{ $title ?? __('front.meta.title', ['kanka' => config('app.name')]) }}@if (!isset($skipEnding)) - {{ config('app.name', 'Kanka') }}@endif</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/images/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon-180x180.png" />

@if (isset($englishCanonical) && $englishCanonical)
    <link rel="canonical" href="{{ LaravelLocalization::localizeURL(null, 'en') }}" />
@else
    <link rel="canonical" href="{{ LaravelLocalization::localizeURL(null, null) }}" />
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
@if ($localeCode == app()->getLocale())
@continue
@endif
    <link rel="alternate" href="{{ LaravelLocalization::localizeUrl(null, $localeCode) }}" hreflang="{{ $localeCode }}">
@endforeach
@endif
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//code.jquery.com">
    <link rel="dns-prefetch" href="//kit.fontawesome.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">

    <!--<link href="{{ mix('css/front/critical.css') }}" rel="stylesheet">-->
    <link href="{{ mix('css/front.css') }}" rel="stylesheet">

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"></noscript>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.css" media="print" onload="this.media='all'" />
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif

    @yield('styles')
</head>

<body id="page-top" class="@if(\App\Facades\DataLayer::groupB())ab-testing-second @else ab-testing-first @endif">
@include('layouts._tracking-fallback')
<noscript id="deferred-styles">
</noscript>

<a href="#main-content" class="skip-nav-link" tabindex="0">
    {{ __('crud.navigation.skip_to_content') }}
</a>
<div id="top"></div>
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ (auth()->check() ? route('front.home') : route('home')) }}">
            <img class="d-none d-lg-block" @if(\App\Facades\Img::nowebp()) src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback?webpfallback" @else src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback" @endif title="Kanka logo text white" alt="kanka logo text white" width="95" height="32" />
            <img class="d-xl-none d-lg-none" @if(\App\Facades\Img::nowebp()) src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png?webpfallback" @else src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png" @endif title="Kanka logo text blue" width="95" height="32" alt="Kanka logo text blue" />
        </a>

        <ul class="navbar-buttons ml-auto d-none d-sm-flex d-lg-none">
            @auth
                <li>
                    <a href="{{ route('home') }}" class="btn btn-default">
                        {{ __('front.menu.dashboard') }}
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="btn btn-default">
                        {{ __('front.menu.login') }}
                    </a>
                </li>
                @if(config('auth.register_enabled'))
                    <li class="ab-testing-a">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg ab-testing-a">
                            {{ __('front.menu.register') }}
                        </a>
                    </li>
                    <li class="ab-testing-b">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg ab-testing-b">
                            {{ __('front.menu.register_free') }}
                        </a>
                    </li>
                @endif
            @endauth
        </ul>

        <button class="navbar-toggler navbar-toggler-right ml-3" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'features') nav-active @endif" href="{{ route("front.features") }}">{{ __('front.menu.features') }}</a>
                </li>
                @if(config('services.stripe.enabled'))
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'pricing') nav-active @endif" href="{{ route("front.pricing") }}">{{ __('front.menu.pricing') }}</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'public-campaigns') nav-active @endif" href="{{ route("front.public_campaigns") }}">{{ __('front.menu.campaigns') }}</a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropLocale" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-language" aria-hidden="true"></i>
                        {{ LaravelLocalization::getCurrentLocaleNative() }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropLocale">
                        @php $locale = 'en-US'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            US English
                        </a>
                        @php $locale = 'en'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            UK English
                        </a>
                        @php $locale = 'pt-BR'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Português do Brasil
                        </a>
                        @php $locale = 'es'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Español
                        </a>
                        @php $locale = 'de'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Deutsch
                        </a>
                        <div class="dropdown-divider"></div>

                        @php $locale = 'fr'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Français
                        </a>
                        @php $locale = 'it'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Italiano
                        </a>
                        @php $locale = 'ru'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Pусский
                        </a>
                        @php $locale = 'pl'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Polska
                        </a>
                        @php $locale = 'nl'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Nederlands
                        </a>
                        <div class="dropdown-divider"></div>

                        @php $locale = 'hu'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Magyar
                        </a>
                        @php $locale = 'sk'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Slovenský
                        </a>
                        @php $locale = 'ca'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Català
                        </a>
                        @php $locale = 'gl'; @endphp
                        <a rel="alternate" hreflang="{{ $locale }}" href="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                            Galego
                        </a>
                    </div>
                </li>
            </ul>


            <div class="d-md-none">
                @auth
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        {{ __('front.menu.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        {{ __('front.menu.login') }}
                    </a>
                    @if(config('auth.register_enabled'))
                    <a href="{{ route('register') }}" class="btn btn-primary text-white ab-testing-a">
                        {{ __('front.menu.register') }}
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary text-white ab-testing-b">
                        {{ __('front.menu.register_free') }}
                    </a>
                    @endif
                @endauth
            </div>
        </div>

        <ul class="navbar-buttons ml-auto d-none d-lg-flex">
            @auth
                <li>
                    <a href="{{ route('home') }}" class="btn btn-default text-white">
                        {{ __('front.menu.dashboard') }}
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('login') }}" class="btn btn-default text-white">
                        {{ __('front.menu.login') }}
                    </a>
                </li>
                @if(config('auth.register_enabled'))
                    <li class="ab-testing-a">
                        <a href="{{ route('register') }}" class="btn btn-primary text-white">
                            {{ __('front.menu.register') }}
                        </a>
                    </li>
                    <li class="ab-testing-b">
                        <a href="{{ route('register') }}" class="btn btn-primary text-white">
                            {{ __('front.menu.register_free') }}
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>

<div id="main-content"></div>
@yield('content')

@include('front.footer')

<!-- Bootstrap core JavaScript -->
<script
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
        crossorigin="anonymous"></script>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>

<script src="{{ mix('js/front.js') }}" async></script>
@if (config('fontawesome.kit'))
<script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.js" async></script>
<script>
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#0E2231"
                },
                "button": {
                    "background": "#2e8893"
                }
            },
            "theme": "classic",
            "content": {
                "message": "{{ __('front.cookie.message') }}",
                "dismiss": "{{ __('front.cookie.dismiss') }}",
                "link": "{{ __('front.cookie.link') }}"
            }
        })});
</script>
<script>
    function init() {
        var vidDefer = document.getElementsByTagName('iframe');
        for (var i=0; i<vidDefer.length; i++) {
            if(vidDefer[i].getAttribute('data-src')) {
                vidDefer[i].setAttribute('src',vidDefer[i].getAttribute('data-src'));
            } } }
    window.onload = init;
</script>
@include('layouts._tracking', ['frontLayout' => true, 'noads' => true])
@yield('scripts')
</body>
</html>
