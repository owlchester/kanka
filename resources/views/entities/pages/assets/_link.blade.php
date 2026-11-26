<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="entity-asset asset-link group relative flex flex-col bg-base-100 rounded-lg overflow-hidden shadow-xs hover:shadow-md transition-shadow">
    <a href="{{ route('entities.entity_assets.go', [$campaign, $entity, $asset]) }}" target="_blank" rel="noreferrer nofollow"
       class="relative aspect-square w-full overflow-hidden bg-base-200 flex items-center justify-center">
        <x-icon class="{{ $asset->icon() }} text-5xl md:text-6xl text-base-content/40 group-hover:text-primary transition-colors" />
        <span class="absolute bottom-2 right-2 text-xs text-base-content/40 group-hover:text-primary transition-colors">
            <x-icon class="fa-regular fa-arrow-up-right-from-square" />
        </span>
    </a>

    @if (! $asset->isVisibleAll())
        <div class="absolute top-2 left-2 z-10 flex items-center gap-1">
            <div class="rounded-full bg-base-100/90 text-base-content w-7 h-7 flex items-center justify-center text-xs shadow-xs">
                @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
            </div>
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
        <a href="{{ route('entities.entity_assets.go', [$campaign, $entity, $asset]) }}" target="_blank" rel="noreferrer nofollow"
           class="asset-name truncate font-medium text-sm text-base-content group-hover:text-primary transition-colors"
           data-toggle="tooltip" data-title="{{ $asset->name }}">
            {!! $asset->name !!}
        </a>
        <div class="asset-url text-xs text-base-content/60 truncate" data-toggle="tooltip" data-title="{{ $asset->metadata['url'] }}">
            {{ $asset->urlDomain() ?: \Illuminate\Support\Str::after($asset->metadata['url'], '//') }}
        </div>
    </div>
</div>
