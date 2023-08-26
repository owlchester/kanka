<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($model->entity->pinnedFiles as $asset)
    <a href="{{ Storage::url($asset->metadata['path']) }}" target="_blank" class="pinned-asset child icon" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
        {{ $asset->name }}
    </a>
@endforeach
@foreach ($model->entity->pinnedAliases as $asset)
    <div class="pinned-asset mb-2" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}" data-visibility="{{ $asset->visibility_id }}">
        <strong>
            {{ __('entities/assets.actions.alias') }}
        </strong>
        <span class="pull-right">
            <a href="#" data-clipboard="[{{ $model->getEntityType() }}:{{ $model->entity->id }}|alias:{{ $asset->id }}]" data-toast="{{ __('entities/assets.copy_alias.success') }}">
                {{ $asset->name }}
            </a>
        </span>
        <br class="clear-both" />
    </div>
@endforeach
