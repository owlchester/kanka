<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109130951-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109130951-1');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title or "Page Titel" }} - {{ config('app.name', 'Kanka') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Font Awesome Icons -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
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
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v={{ setting('kanka.version') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{ setting('kanka.version') }}"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js" async></script>
</head>
<body class="skin-black sidebar-mini @if (Session::has('campaign_id')) @else layout-top-nav @endif">
<div id="app" class="wrapper">
    <!-- Header -->
    @include('layouts.header')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-12 content-header">
                    <h1>
                        {{ $title or "Page Title" }}
                        <small>{{ $description or null }}</small>
                        @if (!empty($headerExtra))
                            {!! $headerExtra !!}
                        @endif
                    </h1>
                </div>
            </div>

                    <!-- You can dynamically generate breadcrumbs here -->
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
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.delete_modal.close') }}</button>
                <button type="button" class="btn btn-danger" id="delete-confirm-submit">{{ trans('crud.delete_modal.delete') }}</button>
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
<!-- new foreign model -->
<div class="modal fade" id="new-entity-modal" tabindex="-1" role="dialog" aria-labelledby="newEntityModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newEntityModalLabel">{{ trans('crud.new_entity.title') }}</h4>
            </div>
            {!! Form::open(['url' => route('entities.create'), 'method' => 'POST', 'id' => 'new-entity-form']) !!}
            <div class="modal-body">
                <div class="form-group required">
                    <label>{{ trans('crud.new_entity.fields.name') }}</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'new-entity-name']) !!}
                </div>
                <p class="text-red" id="new-entity-errors" style="display:none">{{ trans('crud.new_entity.error') }}</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="new-entity-save">{{ trans('crud.save') }}</button>
            </div>
            {{ csrf_field() }}
            {!! Form::hidden('target', null, ['id' => 'new-entity-type']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
</body>
</html>
