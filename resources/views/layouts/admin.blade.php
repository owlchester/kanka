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
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    @yield('styles')
</head>
<body class="skin-black sidebar-mini">
@include('layouts._tracking-fallback')
    <div id="app" class="wrapper">
        @include('layouts.admin.header')

        @include('layouts.admin.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12 content-header">
                        <h1>
                            Admin - {{ $title ?? "Page Title" }}
                            @if (!empty($headerExtra))
                                {!! $headerExtra !!}
                            @endif
                        </h1>
                    </div>
                </div>
                <ol class="breadcrumb">
                    <li><a href="{{route('home')}}"><i class="fa-solid fa-dashboard"></i> {{ __('dashboard.title') }}</a></li>
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

            <section class="content">
                @include('partials.success')
                @yield('content')
            </section>
        </div>

        @include('layouts.footer')

    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="delete-confirm-text">{!! __('crud.delete_modal.description', ['tag' => '<b><span id="delete-confirm-name"></span></b>']) !!}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger delete-confirm-submit"><span class="fa-solid fa-trash"></span> {{ __('crud.delete_modal.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="click-confirm" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.click_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="click-confirm-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.delete_modal.close') }}</button>
                    <a href="" type="button" class="btn btn-danger" id="click-confirm-url">{{ __('crud.click_modal.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>

@yield('modals')
<div class="modal modal-danger fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                <button type="button" class="btn btn-outline delete-confirm-submit">
                    <span class="fa-solid fa-trash"></span>
                    <span class="delete-button-label">{{ __('crud.delete_modal.delete') }}</span>
                    <span class="remove-button-label" style="display: none">{{ __('crud.remove') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/admin/admin.js') }}" async></script>
@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    @yield('scripts')
</body>
</html>
