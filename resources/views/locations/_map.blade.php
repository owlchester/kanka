@if ($model->map)
    @can('update', $model)
        <p class="text-right">
            <a href="{{ route('locations.map', ['location' => $model]) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> {{ trans('locations.map.actions.points') }}</a>
        </p>
    @endcan
    <div class="map">
        <img src="/storage/{{ $model->map }}" alt="{{ $model->name }}" />
        @foreach ($model->mapPoints()->with('location')->get() as $point)
            @can('view', $point->target)
            <a class="point" style="top: {{ $point->axis_y }}px; left: {{ $point->axis_x }}px"  href="{{ route('locations.show', [$point->target, (!empty($point->target->map) ? '#tab_map' : null)]) }}" title="{{ $point->target->name }}">
                <i class="fa fa-map-marker"></i>
            </a>
            @endcan
        @endforeach
    </div>
@else
<p>{{ trans('locations.map.no_map') }}</p>
@endif