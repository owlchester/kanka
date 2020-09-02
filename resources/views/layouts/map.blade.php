<?php /**
 * @var \App\Models\Map $map
 */
?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts._tracking', ['noads' => true])
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
    <link href="{{ mix('css/freyja.css') }}" rel="stylesheet">
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />

@if (auth()->check() && !empty(auth()->user()->theme))
        <link href="{{ mix('css/' . auth()->user()->theme . '.css') }}" rel="stylesheet">
    @endif
    @yield('styles')
</head>
<body id="map-body" class="map-page skin-black skin-map sidebar-mini sidebar-collapse">
@include('layouts._tracking-fallback')

    <div id="app" class="wrapper">
        <!-- Header -->
        @include('layouts.header')

        <aside class="main-sidebar">
            <section class="sidebar" style="height: auto">

                <div id="sidebar-content">
                    <div id="sidebar-map">
                        <div class="marker-details">
                            <h3 class="marker-name">{{ $map->name }}</h3>
                            <div class="marker-entry">{!! \App\Facades\Mentions::map($map) !!}</div>
                        </div>

                        <div class="marker-actions text-center">
                            @can('update', $map)
                                <a href="{{ route('maps.edit', [$map]) }}" class="btn btn-primary">
                                    <i class="fa fa-map"></i> {{ __('maps.actions.edit') }}
                                </a>
                            @endcan
                        </div>


                        <div class="map-legend">
                            @include('maps.explore.legend')
                        </div>

                        <div class="map-legend text-center">
                            <a href="{{ $map->getLink() }}" class="btn btn-primary">{{ __('maps.actions.back', ['name' => $map->name]) }}</a>
                        </div>
                    </div>
                    <div id="sidebar-marker">
                    </div>
                </div>

            </section>
        </aside>

        <div class="content-wrapper">
        @yield('content')
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="delete-confirm-text">
                        {!! trans('crud.delete_modal.description', ['tag' => '<b><span id="delete-confirm-name"></span></b>']) !!}
                    </p>
                    <div id="delete-confirm-mirror" class="form-group" style="display: none">
                        <label>
                            <input type="checkbox" id="delete-confirm-mirror-chexkbox" name="delete-mirror">
                            {{ __('crud.delete_modal.mirrored') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="delete-confirm-submit"><span class="fa fa-trash"></span> {{ trans('crud.delete_modal.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="https://kit.fontawesome.com/d7f0be4a8d.js" crossorigin="anonymous"></script>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="//unpkg.com/leaflet@1.6.0/dist/leaflet.js"
        integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
        crossorigin=""></script>
<script src="/js/vendor/leaflet/leaflet-polyline-measure.js"></script>

<script src="{{ mix('js/location/map-v3.js') }}" defer></script>
@yield('scripts')

@yield('modals')
</body>
</html>
