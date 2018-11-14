@extends('layouts.app', [
    'title' => trans('locations.map.points.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ]
])

@section('content')
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
                <div class="map-admin">
                @can('update', $location)
                    <a href="{{ $location->getLink() }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> {{ trans('locations.map.points.return', ['name' => $location->name]) }}
                    </a>
                    <button id="map-admin-mode" class="btn btn-primary" title="{{ __('locations.map.helpers.admin') }}" data-toggle="tooltip" data-placement="bottom">
                        <i class="fa fa-pencil"></i> {{ __('locations.map.actions.admin_mode') }}
                    </button>
                    <button id="map-view-mode" class="btn btn-primary" title="{{ __('locations.map.actions.view_mode') }}" data-toggle="tooltip" data-placement="bottom" style="display: none">
                        <i class="fa fa-eye"></i> {{ __('locations.map.actions.view_mode') }}
                    </button>
                @endcan
                </div>
                <div class="map-helper">
                    <p>{{ __('locations.map.helpers.view') }}</p>
                </div>
                <div class="map">
                    <div id="draggable-map">
                        <div class="map-container">
                            <img src="{{ Storage::url($location->map) }}" alt="{{ $location->name }}" id="location-map-image" data-url="{{ route('locations.map_points.create', $location) }}" @if ($location->isMapSvg()) style="width: 100%;" @endif />
                            @foreach ($location->mapPoints()->with(['targetEntity', 'location'])->get() as $point)
                                @include('locations.map._point')
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


        <!-- Modal -->
        <div class="modal fade" id="point-location" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}" title="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans('locations.map.points.modal') }}</h4>
                    </div>
                    <div class="modal-body" id="map-point-body">

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
@endsection

@section('styles')
    <link href="{{ mix('css/map.css') }}" rel="stylesheet">
@endsection