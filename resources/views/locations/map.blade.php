<?php /** @var \App\Models\Location $location */ ?>
@extends('layouts.app', [
    'title' => trans('locations.map.points.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ],
    'mainTitle' => false,
])

@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{ $location->getLink() }}" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> <span class="hidden-xs">{{ trans('locations.map.points.return', ['name' => $location->name]) }}</span>
            </a>
            @if ($location->map)
                @can('update', $location)
                    @notEnv('shadow')
                    <button id="map-admin-mode" class="btn btn-primary" title="{{ __('locations.map.helpers.admin') }}" data-toggle="tooltip" data-placement="bottom">
                        <i class="fa fa-edit"></i> <span class="hidden-xs">{{ __('locations.map.actions.admin_mode') }}</span>
                    </button>
                    <button id="map-view-mode" class="btn btn-primary" title="{{ __('locations.map.actions.view_mode') }}" data-toggle="tooltip" data-placement="bottom" style="display: none">
                        <i class="fa fa-eye"></i> <span class="hidden-xs">{{ __('locations.map.actions.view_mode') }}</span>
                    </button>
                    @endenv
                @endcan
            @endif
        </div>
    </div>
    @if ($location->map)
        <div class="row">
            <div class="col-md-12" id="location-map-main">
                <div class="map-zoom">
                    <button id="map-zoom-in" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_in') }}"><i class="fa fa-plus"></i></button>
                    <button id="map-zoom-out" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_out') }}"><i class="fa fa-minus"></i></button>
                    <button id="map-zoom-reset" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_reset') }}"><i class="fa fa-undo"></i></button>
                    <button id="map-toggle-hide" class="btn btn-default" title="{{ trans('locations.map.actions.toggle_hide') }}"><i class="fa fa-eye-slash"></i></button>
                    <button id="map-toggle-show" class="btn btn-default" style="display: none;" title="{{ trans('locations.map.actions.toggle_show') }}"><i class="fa fa-eye"></i></button>
                    <a href="{{ Storage::url($location->map) }}" target="_blank" class="btn btn-default" title="{{ trans('locations.map.actions.download') }}" download><i class="fa fa-download"></i></a>
                </div>
                <div class="map-helper hidden-xs">
                    <p>{{ __('locations.map.helpers.view') }}</p>
                </div>
                <div class="map">
                    <div class="loading-map text-center">
                        <i class="fa fa-spin fa-spinner fa-4x"></i>
                    </div>

                    <div id="draggable-map">
                        <div class="map-container">
                            <img src="{{ Img::url($location->map) }}" alt="{{ $location->name }}" id="location-map-image" data-url="{{ route('locations.map_points.create', $location) }}" @if ($location->isMapSvg()) style="width: {{ $location->mapWidth()}};" @endif />
                            @foreach ($location->mapPoints()->with(['targetEntity', 'location'])->get() as $point)
                                <?php /** @var \App\Models\MapPoint $point */?>
                                @if ($point->visible())
                                    {!! $point->makePin() !!}
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden col-md-3 col-sm-4" id="location-map-panel">
                <div id="location-map-panel-loading" class="text-center" style="display: none">
                    <h1><i class="fa fa-spinner fa-spin"></i></h1>
                </div>

                <div id="location-map-panel-target"></div>
            </div>
        </div>

        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">{{ __('locations.map.legend') }}</h4>
            </div>
            <div class="box-body">
                <div class="row">
                @foreach ($location->legend() as $point)
                    <div class="col-md-3">
                        @if ($point->visible())
                            <a href="#map-point-{{ $point->id }}" class="map-point-legend">@if ($point->label()) {{ $point->label() }} @else <i> {{ __('locations.map.points.empty_label') }} </i> @endif</a>
                        @endif
                    </div>
                @endforeach
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="point-location" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}" title="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans('locations.map.points.modal') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-loading text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                        </div>
                        <div id="map-point-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="panel panel-default">
            <div class="panel-body">
                <p class="help-block">{{ trans('locations.map.no_map') }}</p>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ mix('js/location/map.js') }}" defer></script>
    <script src="{{ asset('js/vendor/jquery.ui.touch-punch.min.js') }}" defer></script>
    <script src="/vendor/spectrum/spectrum.js" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/map.css') }}" rel="stylesheet">
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">
@endsection
