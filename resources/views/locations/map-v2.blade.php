@extends('layouts.app', [
    'title' => trans('locations.map.points.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ],
])

@section('content')
    @if ($location->map)
        <div id="location-map">
            <location-map
                :id="{{ $location->id }}"
                :map="'{{ Img::url($location->map) }}'"

            >

            </location-map>
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
    <script src="{{ mix('js/location/map-v2.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/map-v2.css') }}" rel="stylesheet">
@endsection
