<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
$assets = $model->entity->assets->where('is_pinned', 1)->where('type_id', 1);
?>
@if (count($assets) > 0)
    @foreach ($assets as $asset)
        <li class="list-group-item pinned-asset data-asset="{{ $asset->name }}" data-target="{{ $asset->id }}">
            <a href="{{ Storage::url($asset->metadata['path']) }}" target="_blank" class="child icon" >
                {{ $asset->name }}
            </a>
            </strong>
        </li>
    @endforeach
@endif
