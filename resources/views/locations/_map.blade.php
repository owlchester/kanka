@if ($model->map)
    @can('update', $model)
        <p class="text-right">
            <a href="{{ route('locations.map', ['location' => $model]) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> {{ trans('locations.map.actions.points') }}</a>
        </p>
    @endcan
    <div class="map">
        <img src="/storage/{{ $model->map }}" alt="{{ $model->name }}" />
        @foreach ($model->mapPoints()->with('location')->get() as $point)
            <a class="point" style="top: {{ $point->axis_y }}%; left: {{ $point->axis_x }}%"  href="{{ route('locations.show', [$point->target, (!empty($point->target->map) ? '#map' : null)]) }}" title="{{ $point->target->name }}"></a>
        @endforeach
    </div>
@else
<p>{{ trans('location.map.helper') }}</p>
@endif