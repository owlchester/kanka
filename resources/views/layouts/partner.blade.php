<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts.tracking.tracking')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? "" }} - {{ config('app.name') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="icon" type="image/png" href="/favicon.ico">

    <!-- Styles -->
    <link href="/css/bootstrap.css?v={{ config('app.version') }}" rel="stylesheet">
    @vite([
    'resources/sass/vendor.scss',
    'resources/sass/app.scss',
    ])
    @yield('styles')
</head>
<body class="">
    <div id="app" class="wrapper h-full relative overflow-x-hidden overflow-y-auto mt-12">
        <!-- Sidebar -->
        @include('layouts.partner.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header mb-5">
                <h1>
                    {{ $title ?? "Page Title" }}
                    <span class="text-sm text-green-500">{{ $description ?? null }}</span>
                    @if (!empty($headerExtra))
                        {!! $headerExtra !!}
                    @endif
                </h1>
                <ol class="breadcrumb">
                    @if (isset($breadcrumbs))
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li>
                            @if (!empty($breadcrumb['url']))
                            <a href="{{ $breadcrumb['url'] }}" title="{{ $breadcrumb['label'] }}">
                                @if (strlen($breadcrumb['label']) > 22)
                                    {{ substr($breadcrumb['label'], 0, 20) . '...' }}
                                @else
                                    {{ $breadcrumb['label'] }}
                                @endif
                                </a>
                            @else
                                @if (strlen($breadcrumb) > 22)
                                    <span title="{{ $breadcrumb }}">{{ substr($breadcrumb, 0, 20) . '...' }}</span>
                                @else
                                    {{ $breadcrumb }}
                                @endif
                            @endif
                        </li>
                    @endforeach
                    @endif
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @include('partials.success')
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        @include('layouts.footer')

    </div>

@yield('modals')
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
    @yield('scripts')
</body>
</html>
