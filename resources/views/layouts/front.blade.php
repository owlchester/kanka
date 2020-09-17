<!doctype html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'he') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="description" content="{{ $metaDescription ?? __('front.home.seo.description') }}">
    <meta name="keywords" content="{{  $metaKeywords ?? __('front.seo.keywords') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title') }}@if (!isset($skipEnding)) - {{ config('app.name') }} @endif">
    <meta property="og:site_name" content="{{ config('app.site_name') }}">
@yield('og')
    <title>{{ $title ?? __('front.meta.title') }} @if (!isset($skipEnding)) - {{ config('app.name', 'Kanka') }}@endif</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="icon" type="image/png" href="/favicon.ico?v=3">

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
    <link rel="dns-prefetch" href="//maxcdn.bootstrapcdn.com">
    <link rel="dns-prefetch" href="//code.jquery.com">
    <link rel="dns-prefetch" href="//kit.fontawesome.com">

    <link href="{{ mix('css/front.css') }}" rel="stylesheet">
    @if(app()->getLocale() == 'he')
        <link href="{{ mix('css/front-rtl.css') }}" rel="stylesheet">
    @endif
    @yield('styles')
</head>

<body id="page-top">
@include('layouts._tracking-fallback')
<noscript id="deferred-styles">
</noscript>

<!-- Navigation -->
<div class="topbar d-none d-sm-block">
    <div class="container">
        <ul class="topbar-list">
            @auth
                <li>
                    <a class="nav-link" href="{{ route('home') }}">{{ __('front.menu.dashboard') }}</a>
                </li>
            @else
                <li class="login d-none d-sm-inline-block">
                    <a href="{{ route('login') }}">
                        {{ __('front.menu.login') }}
                    </a>
                </li>
                @if(config('auth.register_enabled'))
                <li class="d-none d-sm-inline-block">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('front.menu.register') }}</a>
                </li>
                @endif
            @endauth
            <li>
                <a href="{{ config('social.discord') }}" target="discord" title="Discord" rel="noreferrer">
                    <i class="fab fa-discord"></i>
                </a>
            </li>
            <li>
                <a href="{{ config('social.facebook') }}" target="facebook" title="Facebook" rel="noreferrer">
                    <i class="fab fa-facebook"></i>
                </a>
            </li>
            <li>
                <a href="{{ config('social.instagram') }}" target="instagram" title="Instagram" rel="noreferrer">
                    <i class="fab fa-instagram"></i>
                </a>
            </li>
            <li>
                <a href="{{ config('social.reddit') }}" target="reddit" title="Reddit" rel="noreferrer"><i class="fab fa-reddit"></i></a>
            </li>
        </ul>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="d-none d-lg-block" @if(\App\Facades\Img::nowebp()) src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback?webpfallback" @else src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback" @endif title="Kanka logo text white" alt="kanka logo text white" />
            <img class="d-xl-none d-lg-none" @if(\App\Facades\Img::nowebp()) src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png?webpfallback" @else src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png" @endif title="Kanka logo text blue" alt="Kanka logo text blue" />
        </a>
        @auth
        @else
            <a href="{{ route('login') }}" class="d-lg-none">
                {{ __('front.menu.login') }}
            </a>@if(config('auth.register_enabled'))
            <a href="{{ route('register') }}" class="d-lg-none">
                {{ __('front.menu.register') }}
            </a>@endif
        @endauth
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'features') nav-active @endif" href="{{ route("front.features") }}">{{ __('front.menu.features') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'pricing') nav-active @endif" href="{{ route("front.pricing") }}">{{ __('front.menu.pricing') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://blog.kanka.io" target="_blank">{{ __('front.menu.news') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'contact') nav-active @endif" href="{{ route("front.contact") }}">{{ __('front.menu.contact') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == 'about') nav-active @endif" href="{{ route("front.about") }}">{{ __('front.menu.about') }}</a>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="drop3" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ LaravelLocalization::getCurrentLocaleNative() }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu navbar-nar" aria-labelledby="drop3">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @if ($localeCode != App::getLocale())
                                <li class="nav-item">
                                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true).(auth()->guest() ? '' : '?updateLocale=true') }}" class="nav-link">
                                        {{ ucfirst($properties['native']) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')

@include('front.footer')

<!-- Bootstrap core JavaScript -->
<script
        src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
        crossorigin="anonymous"></script>

<!--<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->
<script src="{{ mix('js/front.js') }}" async></script>

<script src="https://kit.fontawesome.com/d7f0be4a8d.js" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" media="print" onload="this.media='all'" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js" async></script>
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
<!-- Async Bootstrap Loading - add this to your footer -->
<script async>
    var cb = function () {
        var l = document.createElement('link');
        l.rel = 'stylesheet';
        l.href = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css';
        var h = document.getElementsByTagName('head')[0];
        h.parentNode.insertBefore(l, h);
    };
    var raf = requestAnimationFrame || mozRequestAnimationFrame || webkitRequestAnimationFrame || msRequestAnimationFrame;
    if (raf) raf(cb);
    else window.addEventListener('load', cb);
</script>
<noscript>
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
</noscript>
@include('layouts._tracking', ['frontLayout' => true, 'noads' => true])
@yield('scripts')
</body>
</html>
