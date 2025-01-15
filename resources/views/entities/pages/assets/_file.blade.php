<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="">
    <div class="entity-asset asset-file flex justify-center items-center overflow-hidden mb-4">
        <a href="{{ $asset->url() }}" target="_blank" class="w-1/2 block h-20 cover-background icon rounded flex items-center align-center justify-center bg-black/10 " @if($asset->isImage()) style="background-image: url({{ $asset->imageUrl() }})"@endif>
            @if (!$asset->isImage())
            <i class="text-3xl fa-regular fa-file" aria-hidden="true"></i>
            @endif
        </a>
        <div class="w-1/2 text truncate p-2">
            {!! $asset->name !!}<br />

            <div class="text-lg">
            @if(auth()->check() && auth()->user()->can('update', $entity))
                <a href="#" data-toggle="dialog-ajax" data-target="asset-update-dialog" data-url="{{ route('entities.entity_assets.edit', [$campaign, $entity, $asset]) }}">
                    <x-icon class="pencil" title="{{ __('crud.edit') }}" tooltip />
                </a>
            @endif
            @include('icons.visibility', ['icon' => $asset->visibilityIcon()])
            </div>
        </div>
    </div>
</div>
