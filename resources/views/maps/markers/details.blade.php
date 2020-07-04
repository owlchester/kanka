<?php /** @var \App\Models\MapMarker $marker */?>
<div class="marker-details">
    <h3 class="marker-name">{{ $marker->name }}<span class="pull-right marker-close" title="{{ __('crud.click_modal.close') }}"><i class="fa fa-close"></i></span></h3>
    <div class="marker-entry">
        {!! \App\Facades\Mentions::mapAny($marker) !!}
    </div>

    @if ($marker->entity)
        <div class="marker-entity  entity-title">
            <a href="{{ $marker->entity->url() }}" target="_blank">
                <span class="entity-image" style="background-image: url('{{ $marker->entity->child->getImageUrl(40) }}');" title="{{ $marker->entity->name }}"></span>

                <span class="entity-name">{{ $marker->entity->name }}</span>
            </a>
        </div>
    @endif


    <div class="marker-actions text-center">
        @can('update', $marker->map)
            <div class="btn-group">
                <a href="{{ route('maps.map_markers.edit', [$marker->map, $marker]) }}" class="btn btn-primary">
                    <i class="fa fa-map-pin"></i> {{ __('maps/markers.actions.update') }}
                </a>
                <a href="{{ route('maps.edit', [$marker->map]) }}" class="btn btn-primary">
                    <i class="fa fa-map"></i> {{ __('maps.actions.edit') }}
                </a>
            </div>
        @endcan
    </div>
</div>
