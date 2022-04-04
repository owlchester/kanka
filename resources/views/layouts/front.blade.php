<!doctype html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'he') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content='width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no'>
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="description" content="{{ $metaDescription ?? __('front.home.seo.meta-description') }}">
    <meta name="keywords" content="{{  $metaKeywords ?? __('front.seo.keywords') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title') }}@if (!isset($skipEnding)) - {{ config('app.name') }} @endif">
    <meta property="og:site_name" content="{{ config('app.site_name') }}">
    <meta property="og:type" content="website" />
@if(config('services.facebook.client_id'))  <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />@endif

    @yield('og')
    <meta property="og:image" content="https://kanka-app-assets.s3.amazonaws.com/images/logos/logo-blue-white.png" />

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
@if(app()->getLocale() == 'he')
        <link href="{{ mix('css/front-rtl.css') }}" rel="stylesheet">
    @endif
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.css" media="print" onload="this.media='all'" />
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif

    @yield('styles')
</head>

<body id="page-top">
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
                    <a href="{{ route('home') }}" class="btn btn-outline-light">
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
                    <li>
                        <a href="{{ route('register') }}" class="btn btn-primary text-white">
                            {{ __('front.menu.register') }}
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
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'contact') nav-active @endif" href="{{ route("front.contact") }}">{{ __('front.menu.contact') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if(!empty($active) && $active == 'about') nav-active @endif" href="#"  id="navbarDropAbout" role="button" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true">
                        {{ __('front.menu.about') }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropAbout">
                        <a href="{{ route('front.about') }}" class="dropdown-item">
                            {{ __('teams.index.title') }}
                        </a>

                        <a href="{{ route('front.hall-of-fame') }}" class="dropdown-item">
                            {{ __('front/hall-of-fame.title') }}
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="https://blog.kanka.io" class="dropdown-item" target="_blank" rel="noopener noreferrer">
                            {{ __('front.menu.news') }} <i class="fa fa-external-link"></i>
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropLocale" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ LaravelLocalization::getCurrentLocaleNative() }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropLocale">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if ($localeCode != App::getLocale())
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="dropdown-item">
                                {{ ucfirst($properties['native']) }}
                            </a>
                        @endif
                    @endforeach
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
                    <a href="{{ route('register') }}" class="btn btn-primary text-white">
                        {{ __('front.menu.register') }}
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
                    <li>
                        <a href="{{ route('register') }}" class="btn btn-primary text-white">
                            {{ __('front.menu.register') }}
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
