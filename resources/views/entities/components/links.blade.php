<?php /** @var \App\Rules\EntityAsset $asset */?>

<div class="sidebar-section-box entity-links">
    <div class="sidebar-section-title cursor-pointer text-lg user-select" data-toggle="collapse" data-target="#sidebar-link-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>

        {{ __('entities/pins.links') }}
    </div>
    <div class="sidebar-elements collapse in" id="sidebar-link-elements">
        <ul class="list-unstyled">
            @foreach ($model->entity->assets->where('type_id', \App\Models\EntityAsset::TYPE_LINK) as $asset)
                <li data-target="{{ $asset->id }}" data-visibility="{{ $asset->visibility }}">
                    <a href="{{ route('entities.entity_assets.go', [$campaign, 'entity' => $model->entity->id, 'entity_asset' => $asset]) }}" title="{!! $asset->name !!}" target="_blank" rel="noreferrer nofollow" class="entity-link">
                        <i class="{{ $asset->icon() }} mr-2"></i> {!! $asset->name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
