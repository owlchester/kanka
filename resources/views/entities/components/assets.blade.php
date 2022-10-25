<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
?>
@foreach ($model->entity->pinnedFiles as $asset)
    <li class="list-group-item pinned-asset data-asset="{{ $asset->name }}" data-target="{{ $asset->id }}">
        <a href="{{ Storage::url($asset->metadata['path']) }}" target="_blank" class="child icon" >
            {{ $asset->name }}
        </a>
    </li>
@endforeach
