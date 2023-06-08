<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Attribute $attribute
 */
$attributes = isset($entity) ? $entity->starredAttributes() : $model->entity->starredAttributes();
?>
@if (count($attributes) > 0)
    @foreach ($attributes as $attribute)
        <li class="pinned-attribute mb-2  @if ($attribute->isSection()) border-t pt-2 pinned-attribute-section text-center @elseif ($attribute->value == null) pinned-attribute-empty @endif" data-attribute="{{ $attribute->name }}" data-target="{{ $attribute->id }}" @if ($attribute->is_private) data-private="true" @endif>
            @if ($attribute->isCheckbox())
                @if ($attribute->value)
                    <x-icon class="fa-solid fa-check pull-right"></x-icon>
                @else
                    <span class="pull-right">{{ __('general.no') }}</span>
                @endif
            @endif
            <strong title="{{ __('entities/attributes.fields.is_star') }}">{!! $attribute->name() !!}</strong>
            @if ($attribute->isText())
                <p>{!! nl2br($attribute->mappedValue()) !!}</p>
            @elseif (!$attribute->isCheckbox() && !$attribute->isSection())
                <span class="pull-right">{!! $attribute->mappedValue() !!}</span>
                <br class="clear-both" />
            @endif
        </li>
    @endforeach
@endif
