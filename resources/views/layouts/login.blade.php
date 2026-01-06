<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts.tracking.tracking')
    <meta charset="utf-8">
    <title>{{ $title ?? __('default.page_title') }} - {{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="robots" content="noindex, follow">
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
    @include('layouts.links.icons')

    @vite('resources/css/auth.css')
    @includeWhen(!config('fontawesome.kit'), 'layouts.styles.fontawesome')
</head>
<body class="hold-transition register-page">
    <div class="login-box mx-auto">

        <!-- Content Header (Page header) -->
        <div class="bg-white dark:bg-slate-800 md:rounded-xl p-5 md:mt-28 dark:text-slate-400 m-5 rounded-xl flex flex-col gap-4 md:gap-5">
            <div class="text-center w-full login-logo">
                <a href="{{ route('home') }}" tabindex="-1">
                    <img src="https://th.kanka.io/DRTLkY7Tkqz9WqPC_PzgfW0IfUY=/80x72/smart/src/app/logos/kanka-logo-large.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="w-20 inline dark:hidden" />
                    <img src="https://th.kanka.io/ibvg9Hwlnd3yYMUgyYJAcHlwjxU=/80x72/smart/src/app/logos/logo-small-white.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="w-20 inline hidden dark:inline" />
                </a>
            </div>
            @yield('content')
        </div>
    </div>

    @includeWhen(config('fontawesome.kit'), 'layouts.scripts.fontawesome')
    @vite(['resources/js/auth.js'])
@yield('scripts')

@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
</body>
</html>
