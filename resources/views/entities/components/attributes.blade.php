<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Attribute $attribute
 */
$attributes = isset($entity) ? $entity->starredAttributes() : $model->entity->starredAttributes();
?>
@if (count($attributes) > 0)
    @foreach ($attributes as $attribute)
        <div class="pinned-attribute flex gap-2 flex-wrap @if ($attribute->isSection()) border-t pinned-attribute-section text-center @elseif ($attribute->value == null) pinned-attribute-empty @endif" data-attribute="{{ $attribute->name }}" data-target="{{ $attribute->id }}" @if ($attribute->is_private) data-private="true" @endif>
            @if ($attribute->isCheckbox())
                @if ($attribute->value)
                    <x-icon class="fa-solid fa-check pull-right"></x-icon>
                @else
                    <span class="pull-right">{{ __('general.no') }}</span>
                @endif
            @endif
            <strong title="{{ __('entities/attributes.fields.is_star') }}">
                {!! $attribute->name() !!}
            </strong>
            @if ($attribute->isText())
                <p class="m-0 grow w-full">
                    {!! nl2br($attribute->mappedValue()) !!}
                </p>
            @elseif (!$attribute->isCheckbox() && !$attribute->isSection())
                <p class="text-right m-0">
                    {!! $attribute->mappedValue() !!}
                </p>
            @endif
        </div>
    @endforeach
@endif
