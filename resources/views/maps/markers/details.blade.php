<?php
/**
 * @var \App\Models\MapMarker $marker
 * @var \App\Models\Campaign $campaign
 */
$boosted = $campaign->boosted();
$class = $backgroundImage = null;
if ($marker->entity && $marker->entity->hasImage($boosted)) {
    $class = 'with-image';
    $backgroundImage = "background-image: url('" . $marker->entity->getEntityImageUrl($boosted, 400, 200) . "');";
}
?>
@if (!request()->has('mobile'))
<div class="marker-header {{ $class }}" style="{{ $backgroundImage }}">
    <div class="marker-top text-right">
        <span class="marker-close" title="{{ __('crud.click_modal.close') }}"><i class="fa-solid fa-close"></i></span>
    </div>

    <div class="marker-header-lower">
        <div class="marker-name">
        @if ($marker->entity)
            <a href="{{ $marker->entity->url() }}" target="_blank">
                @if (!empty($marker->name))
                    {!! $marker->name !!}
                @else
                    {!! $marker->entity->name !!}
                @endif
            </a>
        @else
                {{ $marker->name }}
        @endif
    </div>
    </div>
</div>

@endif

@if ($marker->entity)
    @if($marker->entity->typeId() === config('entities.ids.map'))
        <div class="marker-map-link text-center m-3">
            <a href="{{ $marker->entity->url('explore') }}" target="_blank" class="btn btn-primary">
                <i class="fa-solid fa-map" aria-hidden="true"></i> {{ __('maps.actions.explore') }}
            </a>
        </div>
    @endif

    @if($marker->entity->typeID() === config('entities.ids.location') && !$marker->entity->child->maps->isEmpty())
        <div class="marker-explore-links text-center m-3">
            @foreach ($marker->entity->child->maps as $map)
                <a href="{{ route('maps.explore', $map) }}" class="btn btn-block btn-primary" target="_blank">
                    <i class="fa-solid fa-map" aria-hidden="true"></i>
                    {{ __('maps.actions.explore') }} {!! $map->name !!}
                </a>
            @endforeach
        </div>
    @endif
@endif

@if ($marker->hasEntry())
    <div class="marker-entry entity-content">
        {!! \App\Facades\Mentions::mapAny($marker) !!}
    </div>
@endif
@if ($marker->entity && $marker->entity->child->hasEntry())
    <div class="marker-entry entity-content">
        {!! $marker->entity->child->entry() !!}
    </div>
@endif

@can('update', $marker->map)
    <div class="marker-actions text-center">
        <div class="btn-group">
            <a href="{{ route('maps.map_markers.edit', [$marker->map, $marker]) }}" class="btn btn-primary">
                <i class="fa-solid fa-map-pin"></i> {{ __('maps/markers.actions.update') }}
            </a>
            <button class="btn btn-danger delete-confirm" data-name="{{ $marker->markerTitle() }}" data-toggle="modal" data-target="#delete-confirm" data-delete-target="delete-marker-confirm-form-{{ $marker->id }}">
                <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('maps/markers.actions.remove') }}
            </button>
        </div>
    </div>

    {!! Form::open(['method' => 'DELETE', 'route' => ['maps.map_markers.destroy', $marker->map_id, $marker->id, 'from' => 'map'], 'style' => 'display:inline', 'id' => 'delete-marker-confirm-form-' . $marker->id]) !!}
    {!! Form::close() !!}
@endcan
