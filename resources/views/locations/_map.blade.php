@if ($model->map)
    <p>
        <a href="{{ route('locations.map.admin', ['location' => $model]) }}" class="btn btn-default">
            <i class="fa fa-arrows-alt"></i> {{ trans('locations.map.actions.big') }}
        </a>

        @can('update', $model)
            <a href="{{ route('locations.map.admin', ['location' => $model]) }}" class="btn btn-primary">
                <i class="fa fa-map-marker"></i> {{ trans('locations.map.actions.points') }}
            </a>
        @endcan
    </p>
    @include('locations.map._map')
@else
<p>{{ trans('locations.map.no_map') }}</p>
@endif