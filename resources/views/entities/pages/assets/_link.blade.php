<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="entity-asset asset-link flex gap-2 items-center lg:w-80 ">
    <a href="{{ route('entities.entity_assets.go', [$campaign, $entity, $asset]) }}" target="_blank"
       class="flex-none w-32 h-20 text-center icon rounded flex items-center align-center justify-center bg-black/10 ">
        <x-icon class="text-3xl {{ $asset->icon() }}" />
    </a>
    <div class="grow text flex flex-col gap-1 overflow-hidden">
        <div class="asset-name truncate" data-toggle="tooltip" data-title="{{ $asset->name }}">
            {!! $asset->name !!}
        </div>
        <div class="asset-url truncate" data-toggle="tooltip" data-title="{{ $asset->metadata['url'] }}">
            {{ \Illuminate\Support\Str::after($asset->metadata['url'], '//') }}
        </div>

        <div class="text-lg">
        @can('update', $entity)
            <a href="#" data-toggle="dialog" data-target="asset-update-dialog" data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}">
                <i class="fa-regular fa-pencil" aria-hidden="true" aria-label="{{ __('crud.edit') }}"></i>
            </a>
        @endif
        @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
        </div>

    </div>
</div>
