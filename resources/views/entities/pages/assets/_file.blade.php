<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="entity-asset asset-file flex gap-2 items-center lg:w-80">
    <a href="{{ $asset->url() }}" target="_blank"
       class="flex-none w-32 h-20 cover-background  icon rounded flex items-center align-center justify-center bg-black/10 text-3xl " @if($asset->isImage()) style="background-image: url({{ $asset->imageUrl() }})"@endif>
        @if (!$asset->isImage())
            <x-icon :class="$asset->previewIcon()" />
        @endif
    </a>
    <div class="grow text flex flex-col gap-1 overflow-hidden">
        <div class="asset-name truncate" data-toggle="tooltip" data-title="{{ $asset->name }}">
            {!! $asset->name !!}
        </div>

        <div class="text-lg">
        @can('update', $entity)
            <a href="#" data-toggle="dialog-ajax" data-target="asset-update-dialog" data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}">
                <x-icon class="pencil" title="{{ __('crud.edit') }}" tooltip />
            </a>
        @endif
        @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
        </div>
    </div>
</div>
