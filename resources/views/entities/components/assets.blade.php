<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($model->entity->pinnedFiles as $asset)
    <li class="list-group-item pinned-asset" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
        <a href="{{ Storage::url($asset->metadata['path']) }}" target="_blank" class="child icon" >
            {{ $asset->name }}
        </a>
    </li>
@endforeach
@foreach ($model->entity->pinnedAliases as $asset)
    <li class="list-group-item pinned-asset" data-asset="{{ \Illuminate\Support\Str::slug($asset->name) }}" data-target="{{ $asset->id }}">
        <strong>
            {{ __('entities/assets.actions.alias') }}
        </strong>
        <span class="pull-right">
            {!! $model->tooltipedLink($asset->name) !!}
        </span>
        <br class="clear-both" />
    </li>
@endforeach