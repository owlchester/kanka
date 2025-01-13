<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="">
    <div class="entity-asset asset-alias flex justify-center items-center overflow-hidden mb-4" data-id="{{ $asset->id }}" data-asset-type="alias">
        <div href="#" class="w-1/2 h-20 text-center icon rounded flex items-center align-center justify-center bg-black/10 ">
            <i class="text-3xl fa-solid fa-arrow-right" aria-hidden="true"></i>
        </div>
        <div class="w-1/2 text truncate p-2">
            {{ $asset->name }}<br />

            <div class="text-lg">
            @if(auth()->check() && auth()->user()->can('update', $entity))
                <a href="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}" data-toggle="dialog-ajax" data-target="asset-update-dialog" data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}">
                    <i class="fa-solid fa-pencil" aria-hidden="true" aria-label="{{ __('crud.edit') }}"></i>
                </a>
            @endif
            @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
            </div>
        </div>
    </div>
</div>
