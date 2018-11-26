<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109130951-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109130951-1');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ trans('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <title>{{ $title or trans('front.meta.title') }} - {{ config('app.name', 'Kanka') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="icon" type="image/png" href="/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>

<body id="page-top">
<!-- Custom styles for this template -->
<link href="/css/front/new-age.min.css" rel="stylesheet">
<link href="{{ mix('css/front.css') }}" rel="stylesheet">
<noscript id="deferred-styles">
</noscript>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            {{ trans('front.menu.title') }}
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @foreach ($menus as $menu)
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#{{ $menu }}">{{ trans('front.menu.' . $menu) }}</a>
                </li>
                @endforeach
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ trans('front.menu.dashboard') }}</a>
                    </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ trans('front.menu.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ trans('front.menu.register') }}</a>
                </li>
                @endauth

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="drop3" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-globe"></i>
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

<footer id="footer">
    <div class="container">
        <div class="row h-100 footer-links">
            <div class="col-md-3 col-sm-4 col-xs-6">
                <p class="first">
                    <i class="fa fa-envelope"></i> hello@kanka.io
                </p>
                <p>{!! __('footer.copyright', ['year' => date('Y')]) !!}</p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <h4>{{ __('front.footer.navigation') }}</h4>
                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ trans('front.menu.home') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('public_campaigns') }}">{{ trans('front.menu.campaigns') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-2 col-xs-6">
                <h4>{{ __('front.footer.resources') }}</h4>
                <ul>
                    <li>
                        <a href="{{ route('community') }}">{{ trans('front.menu.community') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}">{{ trans('front.menu.faq') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('help') }}">{{ trans('front.menu.help') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('privacy') }}">{{ trans('front.menu.privacy') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6">
                <h4>{{ __('front.footer.app') }}</h4>
                <ul>
                    <li>
                        <a href="{{ route('about') }}">{{ trans('front.menu.about') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('releases.index') }}">{{ trans('front.menu.releases') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('roadmap') }}">{{ trans('front.menu.roadmap') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12 footer-social">
                <h4>{{ __('front.footer.social') }}</h4>
                <ul>
                    <li>
                        <a href="//www.patreon.com/kankaio" target="patreon" title="Patreon" rel="noreferrer">
                            <i class="fab fa-patreon"></i>
                        </a>
                    </li>
                    <li>
                        <a href="//discord.gg/rhsyZJ4" target="discord" title="Discord" rel="noreferrer"><i class="fab fa-discord"></i></a>
                    </li>
                    <li>
                        <a href="//reddit.com/r/kanka" target="reddit" title="Reddit" rel="noreferrer"><i class="fab fa-reddit"></i></a>
                    </li>
                    <li>
                        <a href="//www.facebook.com/kanka.io.ch" target="facebook" title="Facebook" rel="noreferrer"><i class="fab fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="//twitter.com/kankaio" target="twitter" title="Twitter" rel="noreferrer"><i class="fab fa-twitter"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

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
                "message": "{{ trans('front.cookie.message') }}",
                "dismiss": "{{ trans('front.cookie.dismiss') }}",
                "link": "{{ trans('front.cookie.link') }}"
            }
        })});
</script>
</body>
</html>
