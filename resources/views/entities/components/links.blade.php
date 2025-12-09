<?php /** @var \App\Models\EntityAsset $asset */?>

<div class="sidebar-section-box entity-links overflow-hidden flex flex-col gap-2">
    <div class="sidebar-section-title cursor-pointer group user-select border-b element-toggle" data-animate="collapse" data-target="#sidebar-link-elements">
        <x-icon class="fa-regular fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
        <x-icon class="fa-regular fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
        <span class="text-lg">{{ __('entities/pins.links') }}</span>
    </div>
    <div class="sidebar-elements overflow-hidden" id="sidebar-link-elements">
        <div class="flex flex-col gap-2">
            @foreach ($entity->assets->where('type_id', \App\Enums\EntityAssetType::link) as $asset)
                <a
                    href="{{ route('entities.entity_assets.go', [$campaign, 'entity' => $entity, 'entity_asset' => $asset]) }}"
                    title="{!! $asset->name !!}"
                    target="_blank" rel="noreferrer nofollow"
                    data-target="{{ $asset->id }}"
                    data-visibility="{{ $asset->visibility_id }}"
                    class="entity-link flex gap-2 text-link">
                    <x-icon class="{{ $asset->icon() }} text-xl flex-0" />
                    <span class="grow">
                        {!! $asset->name !!}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
