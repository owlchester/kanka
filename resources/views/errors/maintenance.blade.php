<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts._tracking', ['noads' => true])

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title') }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    <title>{{ __('errors.503.title') }} - {{ config('app.name', 'Kanka') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="icon" type="image/png" href="/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="page-top">
@include('layouts._tracking-fallback')
<!-- Custom styles for this template -->
<link href="{{ mix('css/front.css') }}" rel="stylesheet">
<noscript id="deferred-styles">
</noscript>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            {{ __('front.menu.title') }}
            <i class="fa fa-bars"></i>
        </button>
    </div>
</nav>

<header class="masthead reduced-masthead" id="about">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-7 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5" id="maintenance">{{ __('errors.503.title') }}</h1>

                    <p class="mb-5">{{ __('errors.503.body.1') }}</p>
                    <p class="mb-5">{{ __('errors.503.body.2') }}</p>

                    <p>{!! __('errors.footer', ['discord' => link_to(config('social.discord'), 'Discord')]) !!}</p>

                    <p><a href="/">{{ __('dashboard.setup.actions.back_to_dashboard') }}</a>.</p>
                </div>
            </div>
            <div class="col-lg-3 my-auto text-right">
                @if (!auth()->check())
                    <p>
                        <a href="/login" class="btn btn-outline btn-xl">{{ __('front.menu.login') }}</a>
                    </p>@if(config('auth.register_enabled'))
                        <p>
                            <a href="/register" class="btn btn-outline btn-xl">{{ __('front.menu.register') }}</a>
                        </p>@endif
                @endif

                <p>
                    <a href="/" class="btn btn-outline btn-xl">{{ __('front.menu.home') }}</a>
                </p>
            </div>
        </div>
    </div>
</header>
@yield('content')


<!-- Bootstrap core JavaScript -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>
