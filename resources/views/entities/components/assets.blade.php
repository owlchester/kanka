<?php
/**
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($entity->pinnedFiles as $asset)
    @if ($asset->hiddenImage()) @continue @endif
    @if ($asset->isAudio())
        <div class="pinned-asset child icon" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
                <x-icon class="fa-regular fa-file-music" />
                {!! $asset->name !!}
            <audio controls preload="none" class="music-player w-full h-8" onloadstart="this.volume=0.25">
                <source src="{{ $asset->url() }}" type="{{ $asset->metadata['type'] }}">
            </audio>
        </div>
    @else
        <a href="{{ $asset->url() }}" target="_blank" class="pinned-asset child icon" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
            {!! $asset->name !!}
        </a>
    @endif
@endforeach
