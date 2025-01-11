<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($entity->pinnedFiles as $asset)
    @if ($asset->hiddenImage()) @continue @endif
    <a href="{{ $asset->url() }}" target="_blank" class="pinned-asset child icon" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
        {{ $asset->name }}
    </a>
@endforeach
@php $firstAlias = true @endphp
@foreach ($entity->pinnedAliases as $asset)
    <div class="pinned-asset flex gap-2" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}" data-visibility="{{ $asset->visibility_id }}">
        @if ($firstAlias)<div class="flex-none font-extrabold">
            {{ __('entities/assets.actions.alias') }}
        </div>@php $firstAlias = false; @endphp
       @endif
        <span class="grow text-right">
            <a href="#" data-clipboard="[{{ $entity->entityType->code }}:{{ $entity->id }}|alias:{{ $asset->id }}]" data-toast="{{ __('entities/assets.copy_alias.success') }}">
                {{ $asset->name }}
            </a>
        </span>
        <br class="clear-both" />
    </div>
@endforeach
