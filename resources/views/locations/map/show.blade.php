@extends('layouts.app', [
    'title' => trans('locations.map.points.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ]
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <a href="{{ route('locations.show', [$location, '#tab_map']) }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> {{ trans('locations.map.points.return', ['name' => $location->name]) }}
                </a>

                @can('update', $location)
                    <a href="{{ route('locations.map.admin', ['location' => $location]) }}" class="btn btn-primary">
                        <i class="fa fa-map-marker"></i> {{ trans('locations.map.actions.points') }}
                    </a>
                @endcan
            </p>

            @include('locations.map._map', ['model' => $location])
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('js/location/map.js') }}"></script>
@endsection
