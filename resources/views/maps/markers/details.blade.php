<?php
/**
 * @var \App\Models\MapMarker $marker
 * @var \App\Models\Campaign $campaign
 */
$boosted = $campaign->boosted();
$class = $backgroundImage = null;
$markerNameCss = "py-3";
if ($marker->entity && $marker->entity->hasImage($boosted)) {
    $class = 'with-image cover-background';
    $backgroundImage = "background-image: url('" . \App\Facades\Avatar::entity($marker->entity)->size(400, 200)->thumbnail();
    $markerNameCss = 'py-6';
}
?>
@if (!request()->has('mobile'))
<div class="marker-header flex {{ $class }}" style="{{ $backgroundImage }}">

    <div class="marker-header-fade grow flex gap-2">
        <div class="marker-header-lower grow self-end">
            <div class="marker-name overflow-hidden text-2xl text-bold grow p-2 {{ $markerNameCss }}">
            @if ($marker->entity)
                <a href="{{ $marker->entity->url() }}" target="_blank" class="text-sidebar-content">
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
        <div class="marker-top px-1 py-1">
            <span class="marker-close" title="{{ __('crud.click_modal.close') }}"><i class="fa-solid fa-close"></i></span>
        </div>
    </div>
</div>
@endif

@if ($marker->entity)
    @if($marker->entity->isMap())
        <div class="marker-map-link text-center m-3">
            <a href="{{ $marker->entity->url('explore') }}" target="_blank" class="btn2 btn-primary btn-sm">
                <x-icon class="map" />
                {{ __('maps.actions.explore') }}
            </a>
        </div>
    @endif

    @if($marker->entity->isLocation() && !$marker->entity->child->maps->isEmpty())
        <div class="marker-explore-links text-center m-3">
            @foreach ($marker->entity->child->maps as $map)
                <a href="{{ route('maps.explore', [$campaign, $map]) }}" class="btn2 btn-block btn-primary btn-sm" target="_blank">
                    <x-icon class="map" />
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
        {!! $marker->entity->child->parsedEntry() !!}
    </div>
@endif

@can('update', $marker->map)
    <div class="marker-actions text-center sm:rounded-t">
        <div class="join">
            <a href="{{ route('maps.map_markers.edit', [$campaign, $marker->map, $marker, 'from' => 'explore']) }}" class="btn2 btn-ghost btn-sm join-item">
                <x-icon class="fa-solid fa-map-pin" />
                {{ __('maps/markers.actions.update') }}
            </a>

            <x-button.delete-confirm css="join-item" target="#delete-marker-confirm-form-{{ $marker->id }}" />
        </div>
    </div>
    <x-form method="DELETE" :action="['maps.map_markers.destroy', $campaign, $marker->map, $marker]" id="delete-marker-confirm-form-{{ $marker->id }}">
    <input name="from" type="hidden" value="explore" />
    </x-form>

@endcan
