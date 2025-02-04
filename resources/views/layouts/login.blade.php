<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts.tracking.tracking')
    <meta charset="utf-8">
    <title>{{ $title ?? __('default.page_title') }} - {{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="robots" content="noindex">
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
    @include('layouts.links.icons')

    @vite('resources/sass/auth.scss')
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
</head>
<body class="hold-transition register-page">
    <div class="login-box mx-auto">

        <!-- Content Header (Page header) -->
        <div class="bg-white dark:bg-slate-800 md:rounded-xl p-5 md:mt-28 dark:text-slate-400 m-5 rounded-xl">
            <div class="text-center w-full login-logo mb-5">
                <a href="{{ route('home') }}" tabindex="-1">
                    <img src="https://th.kanka.io/DRTLkY7Tkqz9WqPC_PzgfW0IfUY=/80x72/smart/src/app/logos/kanka-logo-large.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="w-20 inline dark:hidden" />
                    <img src="https://th.kanka.io/ibvg9Hwlnd3yYMUgyYJAcHlwjxU=/80x72/smart/src/app/logos/logo-small-white.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="w-20 inline hidden dark:inline" />
                </a>
            </div>
            @yield('content')
        </div>
    </div>

@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    @vite(['resources/js/auth.js', 'resources/js/cookieconsent.js'])
@yield('scripts')

@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
</body>
</html>
