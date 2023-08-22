<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($model->entity->pinnedFiles as $asset)
    <li class="pinned-asset mb-2" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
        <a href="{{ Storage::url($asset->metadata['path']) }}" target="_blank" class="child icon" >
            {{ $asset->name }}
        </a>
    </li>
@endforeach
@foreach ($model->entity->pinnedAliases as $asset)
    <li class="pinned-asset mb-2" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}" data-visibility="{{ $asset->visibility_id }}">
        <strong>
            {{ __('entities/assets.actions.alias') }}
        </strong>
        <span class="pull-right">
            <a href="#" data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|alias:{{ $asset->id }}]" data-toast="{{ __('entities/assets.copy_alias.success') }}">
                {{ $asset->name }}
            </a>
        </span>
        <br class="clear-both" />
    </li>
@endforeach
