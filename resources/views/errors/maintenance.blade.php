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
        <a class="navbar-brand" href="{{ (auth()->check() ? route('front.home') : route('home')) }}">
            <img class="d-none d-lg-block" @if(\App\Facades\Img::nowebp()) src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback?webpfallback" @else src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback" @endif title="Kanka logo text white" alt="kanka logo text white" width="95" height="32" />
            <img class="d-xl-none d-lg-none" @if(\App\Facades\Img::nowebp()) src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png?webpfallback" @else src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png" @endif title="Kanka logo text blue" width="95" height="32" alt="Kanka logo text blue" />
        </a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            {{ __('front.menu.title') }}
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

<section class="error" id="error-503">
    <div class="container">
        <div class="section-body">
            <h1 class="display-4" id="maintenance">{{ __('errors.503.title') }}</h1>

            <p class="lead">{{ __('errors.503.body.1') }}</p>
            <p class="lead">{{ __('errors.503.body.2') }}</p>

            <p>{!! __('errors.footer', ['discord' => link_to(config('social.discord'), 'Discord')]) !!}</p>

            <p><a href="/">{{ __('dashboard.setup.actions.back_to_dashboard') }}</a>.</p>
        </div>
    </div>
</section>

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
</body>
</html>
