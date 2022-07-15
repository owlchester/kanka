<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityAsset $asset
 */
$attributes = $model->entity->assets->where('is_pinned', 1)->where('type_id', 1);
?>
@if (count($attributes) > 0)
    @foreach ($attributes as $attribute)
        <li class="list-group-item pinned-attribute data-attribute="{{ $attribute->name }}" data-target="{{ $attribute->id }}">
            <strong title="{{ __('entities/attributes.fields.is_star') }}">
                <a href="{{ Storage::url($attribute->metadata['path']) }}" target="_blank" class="child icon" >
                    {{ $attribute->name }}
                </a>
            </strong>
        </li>
    @endforeach
@endif
