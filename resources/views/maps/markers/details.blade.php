<?php
/**
 * @var \App\Models\MapMarker $marker
 * @var \App\Models\Campaign $campaign
 */
$class = $backgroundImage = null;
$hasImage = $marker->entity && $marker->entity->hasImage();
if ($hasImage) {
    $class = 'with-image cover-background';
    $backgroundImage = "background-image: url('" . \App\Facades\Avatar::entity($marker->entity)->size(400, 200)->thumbnail();
}
?>
@if (!request()->has('mobile'))
<div class="marker-header flex flex-col gap-2 {{ $class }}" style="{{ $backgroundImage }}">

        <div class="p-1 text-right">
            <span class="marker-close" data-tooltip data-title="{{ __('crud.actions.close') }}">
                <x-icon class="fa-solid fa-close" />
            </span>
        </div>
    <div class="marker-header-fade grow flex p-2 items-end">
        <div class="marker-header-lower grow flex gap-2">
            <div class="marker-name overflow-hidden grow text-xl">
                @if ($marker->entity)
                    <a href="{{ $marker->entity->url() }}" class="text-sidebar-content">
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
            <div class="flex-none marker-actions flex gap-3 items-center text-2xl">
                @if($marker->entity && $marker->entity->isMap())
                    <a href="{{ $marker->entity->url('explore') }}" class="marker-map-link text-sidebar-content" data-tooltip data-title="{{  __('maps.actions.explore') }}">
                        <x-icon class="map" />
                    </a>
                @endif
                @can('update', $marker->map)
                    <a href="{{ route('maps.map_markers.edit', [$campaign, $marker->map, $marker, 'from' => 'explore']) }}" class="marker-edit-link text-sidebar-content" data-tooltip data-title="{{ __('maps/markers.actions.update') }}">
                        <x-icon class="edit" />
                    </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endif

@if ($marker->entity)
    @if(!$hasImage && $marker->entity->isMap())
        <div class="marker-map-link text-center m-3">
            <a href="{{ $marker->entity->url('explore') }}" class="btn2 btn-primary btn-sm">
                <x-icon class="map" />
                {{ __('maps.actions.explore') }}
            </a>
        </div>
    @endif

    @if($marker->entity->isLocation() && !$marker->entity->child->maps->isEmpty())
        <div class="marker-explore-links text-center m-3">
            @foreach ($marker->entity->child->maps as $map)
                <a href="{{ route('maps.explore', [$campaign, $map]) }}" class="btn2 btn-block btn-primary btn-sm">
                    <x-icon class="map" />
                    {{ __('maps.actions.explore') }} {!! $map->name !!}
                </a>
            @endforeach
        </div>
    @endif
@endif

<div class="flex flex-col gap-3 md:px-3">
    @if ($marker->entity && $marker->entity->tags->isNotEmpty())
        <div class="marker-tags flex flex-wrap gap-2">
            @foreach ($marker->entity->visibleTags as $tag)
                @if (!$tag->entity) @continue @endif
                <a href="{{ $tag->getLink() }}" class="tooltip-tag" data-id="{{ $tag->entity->id }}" data-tag-slug="{{ $tag->slug }}" title="{{ $tag->name }}">
                    @include ('tags._badge')
                </a>
            @endforeach
        </div>
    @endif
    @if ($marker->hasEntry())
        <div class="marker-entry entity-content marker-custom-entry">
            {!! \App\Facades\Mentions::mapAny($marker) !!}
        </div>
    @endif
    @if ($marker->entity && $marker->entity->hasEntry())
        @if ($marker->hasEntry())
        <span class="marker-entity-entry text-xl">
            {{ __('maps/markers.details.from-entity') }}
        </span>
        @endif
        <div class="marker-entry entity-content marker-entity-entry">
            {!! $marker->entity->parsedEntry() !!}
        </div>
    @endif

    @can('update', $marker->map)
        <div class="marker-actions text-center sm:rounded-t">
            <x-button.delete-confirm  target="#delete-marker-confirm-form-{{ $marker->id }}" />
        </div>
        <x-form method="DELETE" :action="['maps.map_markers.destroy', $campaign, $marker->map, $marker]" id="delete-marker-confirm-form-{{ $marker->id }}">
        <input name="from" type="hidden" value="explore" />
        </x-form>
    @endcan
</div>
