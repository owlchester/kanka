<div class="map-zoom">
    <button id="map-zoom-in" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_in') }}"><i class="fa fa-plus"></i></button>
    <button id="map-zoom-out" class="btn btn-default" title="{{ trans('locations.map.actions.zoom_out') }}"><i class="fa fa-minus"></i></button>
    <button id="map-toggle-hide" class="btn btn-default" title="{{ trans('locations.map.actions.toggle_hide') }}"><i class="fa fa-eye-slash"></i></button>
    <button id="map-toggle-show" class="btn btn-default" style="display: none;" title="{{ trans('locations.map.actions.toggle_show') }}"><i class="fa fa-eye"></i></button>
    <a href="{{ Storage::url($model->map) }}" target="_blank" class="btn btn-default" title="{{ trans('locations.map.actions.download') }}"><i class="fa fa-download"></i></a>
</div>
@can('update', $location)
    <div class="map-admin">
        <button id="map-add" class="btn btn-primary" title="{{ __('locations.map.actions.add') }}">
            <i class="fa fa-map-pin"></i> {{ __('locations.map.actions.add') }}
        </button>
    </div>
@endcan
<div class="map">
    <div id="draggable-map">
        <div class="map-container">
            <img src="{{ Storage::url($model->map) }}" alt="{{ $model->name }}" id="location-map-image" />
            @foreach ($model->mapPoints()->with('location')->get() as $point)
                @if ($point->hasTarget())
                    @if (Auth::check())
                        @can('view', $point->target)
                            {!! $point->makePin() !!}
                        @endcan
                    @else
                        @if (!empty($point->target()->acl(null)->first()))
                            {!! $point->makePin() !!}
                        @endif
                    @endif
                @else
                    {!! $point->makePin() !!}
                @endif
            @endforeach
        </div>
    </div>
</div>