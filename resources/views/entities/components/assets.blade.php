<?php
/**
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($entity->pinnedFiles as $asset)
    @if ($asset->hiddenImage()) @continue @endif
    <a href="{{ $asset->url() }}" target="_blank" class="pinned-asset child icon" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
        {!! $asset->name !!}
    </a>
@endforeach
