<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @php AdCache::adless() @endphp
    @include('layouts.tracking.tracking')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title', ['kanka' => config('app.name')]) }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    <title>{{ __('errors.503.title') }} - {{ config('app.name', 'Kanka') }}</title>

    <!-- CSRF Token -->
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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppin">
</head>

<body id="page-top">
<!-- Custom styles for this template -->
@vite('resources/sass/front.scss')
<noscript id="deferred-styles">
</noscript>

@include('layouts.front.nav', ['minimal' => true])

<section class="bg-purple text-white gap-16">
    <div class="px-6 py-20 lg:max-w-7xl mx-auto text-center flex flex-col gap-8">
        <h2 id="maintenance">Server maintenance</h2>

        <p class="lg:max-w-2xl mx-auto text-center">Kanka is currently unavailable due to planned server maintenance.</p>
{{--       <p class="lg:max-w-2xl mx-auto text-center">This maintenance is planned to last until <a href="https://everytimezone.com/s/78b7fbd3" target="_blank" class="link-light"><i class="fa-solid fa-external-link"></i> 16:00 UTC</a>.</p>--}}

        <p class="lg:max-w-2xl mx-auto text-center">Join us over on our <a href="https://kanka.io/go/discord" class="link-light">Discord</a> to be notified as soon as the maintenance is over.</p>

        <div class="hidden">
            <h2 id="maintenance">{{ __('errors.503.title') }}</h2>

            <p class="lg:max-w-2xl mx-auto text-center">{{ __('errors.503.body.1') }}</p>
            <p  class="lg:max-w-2xl mx-auto text-center">{{ __('errors.503.body.2') }}</p>
        </div>
    </div>
</section>

<section class="max-w-2xl mx-auto flex flex-col gap-10 lg:gap-10 py-10 lg:py-12 px-4 xl:px-0 text-dark">
    <img src="/images/errors/maintenance.jpeg" alt="Maintenance" class="rounded-2xl" />
</section>

@yield('content')

@includeWhen(Route::has('home'), 'front.footer')
</body>
</html>
