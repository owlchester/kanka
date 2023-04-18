<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts._tracking', ['noads' => true])

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title', ['kanka' => config('app.name')]) }} - {{ config('app.name') }}" />
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
@vite('resources/sass/front.scss')
<noscript id="deferred-styles">
</noscript>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ (auth()->check() ? route('front.home') : route('home')) }}">
            <img class="d-none d-lg-block" src="https://images.kanka.io/app/lYYwvb1TENQSosFKdgDCLd2oLdU=/228x77/src/images%2Flogos%2Ftext-white.png?webpfallback" title="Kanka logo text white" alt="kanka logo text white" width="95" height="32" />
            <img class="d-xl-none d-lg-none" src="https://images.kanka.io/app/G2bnfyER8xMuMzPX4LM0Phdrjew=/228x77/src/images%
2Flogos%2Ftext-blue.png" title="Kanka logo text blue" width="95" height="32" alt="Kanka logo text blue" />
        </a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

<section class="error" id="error-503">
    <div class="container">
        <div class="section-body mt-5">
            <div class="row">
                <div class="col-12 col-sm-6" style="display: none">
                    <h1 class="display-4" id="maintenance">Server maintenance</h1>

                    <p class="lead">Kanka is currently unavailable due to planned server maintenance.</p>
                    <p class="lead">This maintenance is planned to last from <a href="https://everytimezone.com/s/fce7c091" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link"></i> 14:00 UTC</a> to 16:00 UTC.</p>

                    <p class="lead">Join us over on our {!! link_to(config('social.discord'), 'Discord') !!} to be notified as soon as the maintenance is over.</p>
                </div>

                <div class="col-12 col-sm-6">

                    <h1 class="display-4" id="maintenance">{{ __('errors.503.title') }}</h1>

                    <p class="lead">{{ __('errors.503.body.1') }}</p>
                    <p class="lead">{{ __('errors.503.body.2') }}</p>
                </div>
                <div class="col-12 col-sm-6">
                    <img src="/images/svgs/503.svg" alt="Error 503 image" />
                </div>
            </div>
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
            families: ['Lato', 'Catamaran:100,200,300,400,500,600,700,800,900']
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
