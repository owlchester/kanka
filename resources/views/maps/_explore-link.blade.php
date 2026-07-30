@php
 /** @var \App\Models\Map $map */
if (!$map->explorable()) {
    return '';
}
if ($map->tilingError()) {
    return '<i class="fa-regular fa-exclamation-triangle" data-toggle="tooltip" data-title="' .
        __('maps.errors.tiling.error', ['discord' => 'Discord']) . '"></i>';
} elseif ($map->tilingRunning()) {
    return '<i class="fa-solid fa-spin fa-spinner" data-toggle="tooltip" data-title="' .
    __('maps.tooltips.tiling.running') . '"></i>';
}
@endphp
<a href="{{ route('entities.map', [$campaign, $map->entity]) }}" target="_blank"
   data-toggle="tooltip" data-title="{{ __('maps.actions.explore') }}" class="text-link">
    <x-icon class="map" />
</a>
