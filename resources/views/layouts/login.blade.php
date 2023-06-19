<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts.tracking.tracking', ['noads' => true])
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? __('default.page_title') }} - {{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="robots" content="noindex">
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

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

    @if (request()->has('bs'))
    <link href="/css/bootstrap.css?v={{ config('app.version') }}" rel="stylesheet">
    @endif

    @vite('resources/sass/auth.scss')
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
</head>
<body class="hold-transition register-page">
@include('layouts.tracking.fallback')
    <div class="login-box mx-auto">

        <!-- Content Header (Page header) -->
        <div class="bg-white dark:bg-slate-800 md:rounded-xl p-5 md:mt-28 dark:text-slate-400">
            <div class="text-center w-full login-logo mb-5">
                <a href="{{ route('home') }}" tabindex="-1">
                    <img src="https://th.kanka.io/HuIIn1gIw3VLch1JNwosVd7j0YU=/80x72/smart/app/logos/kanka-logo-large.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="w-20 inline dark:hidden" />
                    <img src="https://th.kanka.io/h6Pj0-5cdT8PyJj2mBF1m6fB1Uk=/80x72/smart/app/logos/logo-small-white.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}" class="w-20 inline hidden dark:inline" />
                </a>
            </div>
            @yield('content')
        </div>
    </div>

@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    @vite('resources/js/auth.js')
@yield('scripts')
</body>
</html>
