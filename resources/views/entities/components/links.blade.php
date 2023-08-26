<?php /** @var \App\Models\EntityAsset $asset */?>

<div class="sidebar-section-box entity-links overflow-hidden flex flex-col gap-2">
    <div class="sidebar-section-title cursor-pointer text-lg user-select border-b" data-toggle="collapse" data-target="#sidebar-link-elements">
        <i class="fa-solid fa-chevron-right" style="display: none" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>

        {{ __('entities/pins.links') }}
    </div>
    <div class="sidebar-elements collapse !visible in" id="sidebar-link-elements">
        <div class="flex flex-col gap-2">
            @foreach ($model->entity->assets->where('type_id', \App\Models\EntityAsset::TYPE_LINK) as $asset)
                <a href="{{ route('entities.entity_assets.go', [$campaign, 'entity' => $model->entity->id, 'entity_asset' => $asset]) }}"
                    title="{!! $asset->name !!}"
                    target="_blank" rel="noreferrer nofollow"
                    data-target="{{ $asset->id }}"
                    data-visibility="{{ $asset->visibility_id }}"
                    class="entity-link flex gap-2">
                    <i class="{{ $asset->icon() }} text-xl flex-0" aria-hidden="true"></i>
                    <span class="grow">
                        {!! $asset->name !!}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
