@php
 /** @var \App\Models\Map $map */
if (!$map->explorable()) {
    return '';
}
if ($map->isChunked()) {
    if ($map->chunkingError()) {
        return '<i class="fa-solid fa-exclamation-triangle" data-toggle="tooltip" data-title="' .
            __('maps.errors.chunking.error', ['discord' => 'Discord']) . '"></i>';
    } elseif ($map->chunkingRunning()) {
        return '<i class="fa-solid fa-spin fa-spinner" data-toggle="tooltip" data-title="' .
        __('maps.tooltips.chunking.running') . '"></i>';
    }
}
@endphp
<a href="{{ route('maps.explore', [$campaign, $map->id]) }}" target="_blank"
   data-toggle="tooltip" data-title="{{ __('maps.actions.explore') }}">
    <x-icon class="map" />
</a>
