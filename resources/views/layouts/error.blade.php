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

    <title>{{ $error }} - {{ config('app.name', 'Kanka') }}</title>

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
                    <h1 class="mb-5" id="{{ $error }}">{{ __('errors.' . $error . '.title') }}</h1>
                    @if (is_array(__('errors.' . $error . '.body')))
                        @foreach (__('errors.' . $error . '.body') as $text)
                            <p class="mb-5">{{ $text }}</p>
                        @endforeach

                        @if($error == 503)
{{--                                <p class="text-warning">This downtime will last until roughly 09:00 AM UTC as we fix some issues with the servers.</p>--}}
                        @endif
                    @else
                    <p class="mb-5">{{ __('errors.' . $error . '.body') }}</p>
                    @endif


                    <p>{!! __('errors.footer', ['discord' => link_to(config('social.discord'), 'Discord')]) !!}</p>

                    <p><a href="/">{{ __('dashboard.setup.actions.back_to_dashboard') }}</a>.</p>
                </div>
            </div>
            @if ($error !== 503)
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
            @endif
        </div>
    </div>
</header>

<div id="main-content"></div>
@yield('content')

@includeWhen(Route::has('home'), 'front.footer')

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

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
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
</body>
</html>
