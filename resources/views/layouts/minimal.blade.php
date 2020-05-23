<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts._tracking')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? trans('default.page_title') }} - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
@yield('og')

    <link rel="icon" type="image/png" href="/favicon.ico">
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @if (auth()->check() && !empty(auth()->user()->theme))
        <link href="{{ mix('css/' . auth()->user()->theme . '.css') }}" rel="stylesheet">
    @endif
    @yield('styles')
</head>
<body class="skin-black sidebar-mini layout-top-nav">
@include('layouts._tracking-fallback')
    <div id="app" class="wrapper">

        <div class="content-wrapper">
            <section class="content-header margin-bottom">
            </section>

            <section class="content">
                @yield('content')
            </section>
        </div>

        @include('layouts.footer')

    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/d7f0be4a8d.js" crossorigin="anonymous"></script>
    @yield('scripts')
</body>
</html>
