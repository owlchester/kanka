<?php /** @var \App\Rules\EntityAsset $asset */?>

<div class="sidebar-section-box entity-links my-1 mx-0">
    <div class="sidebar-section-title cursor-pointer text-lg user-select" data-toggle="collapse" data-target="#sidebar-link-elements">
        <i class="fa-solid fa-chevron-right" style="display: none" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>

        {{ __('entities/pins.links') }}
    </div>
    <div class="sidebar-elements grid my-1 collapse in" id="sidebar-link-elements">
        <ul class="list-none m-0 p-0 pt-2">
            @foreach ($model->entity->assets->where('type_id', \App\Models\EntityAsset::TYPE_LINK) as $asset)
                <li data-target="{{ $asset->id }}" data-visibility="{{ $asset->visibility_id }}" class="p-0 m-0 mb-2 ">
                    <a href="{{ route('entities.entity_assets.go', ['entity' => $model->entity->id, 'entity_asset' => $asset]) }}" title="{!! $asset->name !!}" target="_blank" rel="noreferrer nofollow"
                       class="entity-link flex gap-2">
                        <i class="{{ $asset->icon() }} text-xl flex-0" aria-hidden="true"></i>
                        <span class="grow">
                            {!! $asset->name !!}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
