<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts._tracking', ['noads' => true])
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
@include('layouts._tracking-fallback')
    <div id="app" class="wrapper">
        <!-- Sidebar -->
        @include('layouts.partner.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <h1>
                            {{ $title ?? "Page Title" }}
                            <small>{{ $description ?? null }}</small>
                            @if (!empty($headerExtra))
                                {!! $headerExtra !!}
                            @endif
                        </h1>
                    </div>
                </div>
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

    </div><!-- ./wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{!! __('crud.delete_modal.description_v2', ['tag' => '<b><span id="target-name"></span></b>']) !!}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger delete-confirm-submit"><span class="fa-solid fa-trash" aria-hidden="true"></span> {{ __('crud.delete_modal.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

@yield('modals')

    <!-- Scripts -->
    <script src="/js/vendor.js" defer></script>
    @vite('resources/js/app.js')
    @yield('scripts')
</body>
</html>
