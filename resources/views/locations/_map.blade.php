@if ($model->map)
    @can('update', $model)
        <p>
            <a href="{{ route('locations.map', ['location' => $model]) }}" class="btn btn-primary"><i class="fa fa-map-marker"></i> {{ trans('locations.map.actions.points') }}</a>
        </p>
    @endcan
    <div class="map-zoom">
        <button id="map-zoom-in" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_in') }}"><i class="fa fa-plus"></i></button>
        <button id="map-zoom-out" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_out') }}"><i class="fa fa-minus"></i></button>
        <button id="map-toggle-hide" class="btn btn-default" title="{{ trans('locations.map.actions.toggle_hide') }}"><i class="fa fa-eye-slash"></i></button>
        <button id="map-toggle-show" class="btn btn-default" style="display: none;" title="{{ trans('locations.map.actions.toggle_show') }}"><i class="fa fa-eye"></i></button>
    </div>
    <div class="map">
        <div id="draggable-map">
            <img src="/storage/{{ $model->map }}" alt="{{ $model->name }}" id="location-map-image" />
            @foreach ($model->mapPoints()->with('location')->get() as $point)
                @can('view', $point->target)
                <a class="point" style="top: {{ $point->axis_y }}px; left: {{ $point->axis_x }}px; background-color: {{ $point->colour }}" data-top="{{ $point->axis_y }}" data-left="{{ $point->axis_x }}" href="{{ route('locations.show', [$point->target, (!empty($point->target->map) ? '#tab_map' : null)]) }}" title="{{ $point->target->tooltip() }}" data-toggle="tooltip">
                    <i class="fa fa-map-marker"></i>
                </a>
                @endcan
            @endforeach
            </div>
    </div>
@else
<p>{{ trans('locations.map.no_map') }}</p>
@endif