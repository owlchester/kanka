@php
$menus = [
        'features',
        'pricing',
        'about',
        'news',
        'contact'
    ];
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts._tracking')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title') }} - {{ config('app.name') }}">
    <meta property="og:site_name" content="{{ config('app.site_name') }}">
@yield('og')
    <title>{{ $title ?? __('front.meta.title') }} - {{ config('app.name', 'Kanka') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="/favicon.ico">

@if (isset($englishCanonical) && $englishCanonical)
    <link rel="canonical" href="{{ LaravelLocalization::localizeURL(null, 'en') }}" />
@else
    <link rel="canonical" href="{{ LaravelLocalization::localizeURL(null, null) }}" />
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <link rel="alternate" href="{{ LaravelLocalization::localizeUrl(null, $localeCode) }}" hreflang="{{ $localeCode }}">
    @endforeach
@endif

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css?v=4.4" rel="stylesheet">
    @yield('styles')
</head>

<body id="page-top">
@include('layouts._tracking-fallback')
<!-- Custom styles for this template -->
<link href="/css/front/new-age.min.css" rel="stylesheet">
<link href="{{ mix('css/front.css') }}" rel="stylesheet">
<noscript id="deferred-styles">
</noscript>

<!-- Navigation -->
<div class="topbar">
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
                <li class="d-none d-sm-inline-block">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('front.menu.register') }}</a>
                </li>
            @endauth
            <li>
                <a href="{{ config('patreon.url') }}" target="patreon" title="Patreon" rel="noreferrer">
                    <i class="fab fa-patreon"></i>
                </a>
            </li>
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
        <a class="navbar-brand js-scroll-trigger" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
        @auth
        @else
            <a href="{{ route('login') }}" class="d-sm-none">
                {{ __('front.menu.login') }}
            </a>
            <a class="d-sm-none" href="{{ route('register') }}">
                {{ __('front.menu.register') }}
            </a>
        @endauth
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @foreach ($menus as $menu)
                <li class="nav-item">
                    <a class="nav-link @if(!empty($active) && $active == $menu) nav-active @endif" href="{{ route("front.$menu") }}">{{ __('front.menu.' . $menu) }}</a>
                </li>
                @endforeach

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
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="/vendor/jquery-easing/jquery.easing.min.js" async></script>

<!-- Custom scripts for this template -->
<script src="/js/front/new-age.min.js" async></script>

<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
<script>
    WebFont.load({
        google: {
            families: ['Lato', 'Catamaran:100,200,300,400,500,600,700,800,900', 'Muli']
        }
    });
    var loadDeferredStyles = function() {
        var addStylesNode = document.getElementById("deferred-styles");
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode.textContent;
        document.body.appendChild(replacement);
        addStylesNode.parentElement.removeChild(addStylesNode);
    };
    var raf = requestAnimationFrame || mozRequestAnimationFrame ||
        webkitRequestAnimationFrame || msRequestAnimationFrame;
    if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
    else window.addEventListener('load', loadDeferredStyles);
</script>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
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
@yield('scripts')
</body>
</html>
