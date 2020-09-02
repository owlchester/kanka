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

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/png" href="/favicon.ico">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Styles -->
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body class="skin-black sidebar-mini">
@include('layouts._tracking-fallback')
    <div id="app" class="wrapper">
        <!-- Header -->
        @include('layouts.admin.header')

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12 content-header">
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
                    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> {{ trans('dashboard.title') }}</a></li>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="delete-confirm-text">{!! trans('crud.delete_modal.description', ['tag' => '<b><span id="delete-confirm-name"></span></b>']) !!}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="delete-confirm-submit"><span class="fa fa-trash"></span> {{ trans('crud.delete_modal.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="click-confirm" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ trans('crud.click_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="click-confirm-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.delete_modal.close') }}</button>
                    <a href="" type="button" class="btn btn-danger" id="click-confirm-url">{{ trans('crud.click_modal.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>

@yield('modals')


    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
