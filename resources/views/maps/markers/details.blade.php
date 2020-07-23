<?php /** @var \App\Models\MapMarker $marker */?>
<div class="marker-details">
    @if (!request()->has('mobile'))
    <h3 class="marker-name">{{ $marker->name }}<span class="pull-right marker-close" title="{{ __('crud.click_modal.close') }}"><i class="fa fa-close"></i></span></h3>
    <div class="marker-entry">
        {!! \App\Facades\Mentions::mapAny($marker) !!}
    </div>
    @endif

    @if ($marker->entity)
        <div class="marker-entity  entity-title">
            <a href="{{ $marker->entity->url() }}" target="_blank">
                <span class="entity-image" style="background-image: url('{{ $marker->entity->child->getImageUrl(40) }}');" title="{{ $marker->entity->name }}"></span>

                <span class="entity-name">{{ $marker->entity->name }}</span>
            </a>
        </div>
        {!! $marker->entity->child->entry() !!}



        @if($marker->entity->typeId() == config('entities.ids.map'))
            <div class="text-center">
                <a href="{{ $marker->entity->url('explore') }}" target="_blank" class="btn btn-primary">
                    <i class="fa fa-map"></i> {{ __('maps.actions.explore') }}
                </a>
            </div>
        @endif
    @endif


    <div class="marker-actions text-center">
        @can('update', $marker->map)
            <div class="btn-group">
                <a href="{{ route('maps.map_markers.edit', [$marker->map, $marker]) }}" class="btn btn-primary" target="_blank">
                    <i class="fa fa-map-pin"></i> {{ __('maps/markers.actions.update') }}
                </a>
                <a href="{{ route('maps.edit', [$marker->map]) }}" class="btn btn-primary">
                    <i class="fa fa-map"></i> {{ __('maps.actions.edit') }}
                </a>
                <button class="btn btn-danger delete-confirm" data-name="{{ $marker->name }}" data-toggle="modal" data-target="#delete-confirm" data-delete-target="delete-marker-confirm-form-{{ $marker->id }}">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('maps/markers.actions.remove') }}
                </button>
                {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_markers.destroy', $marker->map_id, $marker->id, 'from' => 'map'], 'style' => 'display:inline', 'id' => 'delete-marker-confirm-form-' . $marker->id]) !!}
                {!! Form::close() !!}
            </div>
        @endcan
    </div>
</div>
