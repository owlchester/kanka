<?php
/**
 * @var \App\Models\Map $map
 */
$map = $widget->entity->child;
?>


@if(empty($map->image))
    <div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
        <div class="panel-heading">
            <h3 class="panel-title">
                <a href="{{ $model->getLink() }}">
                    @if ($model->is_private)
                        <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                    @endif

                    {{ $widget->entity->name }}
                </a>
            </h3>
        </div>
        <div class="panel-body">
            <p class="help-block">{{ __('maps.errors.dashboard.missing') }}</p>
        </div>
    </div>
    @php return @endphp
@endif

<div class="panel panel-default widget-preview widget-map" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-body">
        <div class="map map-dashboard" id="map{{ $map->id }}" style="width: 100%; height: 100%;">
            <a href="{{ route('maps.explore', $model) }}" target="_blank" class="btn btn-primary btn-xs btn-map-explore"><i class="fa fa-map"></i> {{ __('maps.actions.explore') }}</a>
        </div>
    </div>
</div>



@section('scripts')
    @parent
    <script type="text/javascript">
        var markers = [];
@foreach ($map->markers as $marker)
        var marker{{ $marker->id }} = {!! $marker->exploring()->marker() !!};
        markers.push('marker' + {{ $marker->id }});
@endforeach
    </script>

    @include('maps._setup')

    <script type="text/javascript">
@foreach ($map->markers as $marker)
    @if (empty($marker->group_id))
        marker{{ $marker->id }}.addTo(map{{ $map->id }});
    @endif
@endforeach
    </script>
@endsection



@section('styles')
    @parent
    <style>
@foreach ($map->markers as $marker)
        .marker-{{ $marker->id }}  {
            background-color: {{ $marker->backgroundColour() }};
@if ($marker->entity && $marker->icon == 4)
            background-image: url({{ $marker->entity->child->getImageUrl(400) }});
@endif
        }
@endforeach
    </style>
@endsection
