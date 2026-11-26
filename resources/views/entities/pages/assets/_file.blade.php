<?php /** @var \App\Models\EntityAsset $asset */?>
@php
    $fileExtension = $asset->fileExtension();
    $fileSize = $asset->fileSize();
@endphp
<div class="entity-asset asset-file group relative flex flex-col bg-base-100 rounded-lg overflow-hidden shadow-xs hover:shadow-md transition-shadow">
    <a href="{{ $asset->url() }}" target="_blank" rel="noopener"
       class="relative aspect-square w-full overflow-hidden bg-base-200 flex items-center justify-center">
        @if ($asset->isImage())
            <img loading="lazy" src="{{ $asset->imageUrl() }}" alt="{{ $asset->name }}"
                 class="w-full h-full object-cover transition-transform duration-200 group-hover:scale-105" />
        @else
            <x-icon :class="$asset->previewIcon() . ' text-5xl md:text-6xl text-base-content/40 group-hover:text-primary transition-colors'" />
            @if ($fileExtension)
                <span class="absolute bottom-2 left-2 rounded bg-base-100/90 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-base-content/70">
                    {{ $fileExtension }}
                </span>
            @endif
        @endif
    </a>

    @if ($asset->isPinned() || ! $asset->isVisibleAll())
        <div class="absolute top-2 left-2 z-10 flex items-center gap-1">
            @if ($asset->isPinned())
                <div class="rounded-full bg-base-100/90 text-base-content w-7 h-7 flex items-center justify-center text-xs shadow-xs">
                    <x-icon class="fa-regular fa-thumbtack" :title="__('crud.fields.is_star')" tooltip />
                </div>
            @endif
            @if (! $asset->isVisibleAll())
                <div class="rounded-full bg-base-100/90 text-base-content w-7 h-7 flex items-center justify-center text-xs shadow-xs">
                    @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
                </div>
            @endif
        </div>
    @endif

    @can('update', $entity)
        <a href="#"
           data-toggle="dialog"
           data-target="asset-update-dialog"
           data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}"
           class="absolute top-2 right-2 z-10 rounded-full bg-base-100/90 hover:bg-base-100 text-base-content hover:text-primary w-7 h-7 flex items-center justify-center text-xs shadow-xs transition-colors"
           aria-label="{{ __('crud.edit') }}">
            <x-icon class="pencil" :title="__('crud.edit')" tooltip />
        </a>
    @endcan

    <div class="p-3 flex flex-col gap-0.5 min-w-0">
        <a href="{{ $asset->url() }}" target="_blank" rel="noopener"
           class="asset-name truncate font-medium text-sm text-base-content group-hover:text-primary transition-colors"
           data-toggle="tooltip" data-title="{{ $asset->name }}">
            {!! $asset->name !!}
        </a>

        @if ($fileSize)
            <div class="text-xs text-base-content/60 truncate">
                {{ \Illuminate\Support\Number::fileSize($fileSize) }}
            </div>
        @endif

        @if ($asset->isAudio())
            <audio controls preload="none" class="music-player w-full h-8 mt-1.5" onloadstart="this.volume=0.25">
                <source src="{{ $asset->url() }}" type="{{ $asset->metadata['type'] ?? 'audio/mpeg' }}">
            </audio>
        @endif
    </div>
</div>
