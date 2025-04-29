<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="">
    <div class="entity-asset asset-link flex justify-center items-center overflow-hidden mb-4">
        <a href="{{ route('entities.entity_assets.go', [$campaign, $entity, $asset]) }}" target="_blank" class="w-1/2 h-20 text-center icon rounded flex items-center align-center justify-center bg-black/10 ">
            <i class="text-3xl {{ $asset->icon() }}" aria-hidden="true"></i>
        </a>
        <div class="w-1/2 text truncate p-2">
            {!! $asset->name !!}<br />
            <div class="url">{{ $asset->metadata['url'] }}</div>

            <div class="text-lg">
            @if(auth()->check() && auth()->user()->can('update', $entity))
                <a href="#" data-toggle="dialog-ajax" data-target="asset-update-dialog" data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}">
                    <i class="fa-regular fa-pencil" aria-hidden="true" aria-label="{{ __('crud.edit') }}"></i>
                </a>
            @endif
            @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
            </div>

        </div>
    </div>
</div>
