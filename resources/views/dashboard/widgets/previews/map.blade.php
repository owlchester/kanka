<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\Map $map
 * @var \App\Models\Entity $entity
 */
$map = $entity->child;
?>


@if(!$map->explorable())
    <x-alert type="warning">
        <a href="{{ $entity->url() }}" class="text-link">{!! $entity->name !!}</a>
        <p class="">{{ $map->tilingRunning() ? __('maps.errors.dashboard.tiling') : __('maps.errors.dashboard.missing') }}</p>
    </x-alert>
    @php return @endphp
@endif

<div class="widget-map">
    <div class="map map-dashboard rounded overflow-hidden" id="map{{ $map->id }}" style="width: 100%; height: 100%; position: relative;">
        <div
            class="js-map-preview absolute inset-0"
            data-api="{{ route('entities.map-api', [$campaign, $map->entity]) }}"
            data-explore-url="{{ route('entities.map', [$campaign, $map->entity]) }}"
            data-loading="{{ __('maps/explorer.loading') }}"
            data-error="{{ __('maps/explorer.errors.load') }}"
        ></div>
        <a href="{{ route('entities.map', [$campaign, $map->entity]) }}" class="btn2 btn-primary btn-xs btn-map-explore z-820 absolute bottom-3 right-3">
            <x-icon class="map" />
            {{ __('maps.actions.explore') }}
        </a>
    </div>
</div>
