<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts._tracking')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? trans('default.page_title') }} - {{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="robots" content="noindex">
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    <link rel="icon" type="image/png" href="/favicon.ico">

    <!-- Styles -->
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/front.css') }}" rel="stylesheet">
</head>
<body  class="hold-transition register-page @nowebp webpfallback @endnowebp">
@include('layouts._tracking-fallback')
    <div class="login-box">
        <div class="login-logo">
            <h1>
                <a href="{{ route('home') }}"><img src="/images/kanka_transparent_small.png" alt="{{ config('app.name') }}" title="{{ config('app.name') }}"/> {{ config('app.name') }}</a>
            </h1>
        </div>

        <!-- Content Header (Page header) -->
        <div class="login-box-body">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/d7f0be4a8d.js" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
@yield('scripts')
</body>
</html>
