<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="entity-asset asset-alias flex gap-2 items-center lg:w-80" data-id="{{ $asset->id }}" data-asset-type="alias">
    <div  class="flex-none w-32 h-20 text-center icon rounded flex items-center align-center justify-center bg-black/10 ">
        <x-icon class="text-3xl fa-regular fa-masks-theater " />
    </div>
    <div class="grow text flex flex-col gap-1 overflow-hidden">
        <div class="asset-name truncate" data-toggle="tooltip" data-title="{{ $asset->name }}">
            {{ $asset->name }}
        </div>

        <div class="text-lg">
        @can('update', $entity)
            <a href="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}" data-toggle="dialog" data-target="asset-update-dialog" data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}">
                <i class="fa-regular fa-pencil" aria-hidden="true" aria-label="{{ __('crud.edit') }}"></i>
            </a>
        @endif
        @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
        </div>
    </div>
</div>
