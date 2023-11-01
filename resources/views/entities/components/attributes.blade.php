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
            <strong>
                {!! $attribute->name() !!}
            </strong>
            @if ($attribute->isCheckbox())
                <span class="grow text-right">
                @if ($attribute->value)
                    <x-icon class="fa-solid fa-check "></x-icon>
                @else
                    <span class="">
                        {{ __('general.no') }}
                    </span>
                @endif
                </span>
            @elseif ($attribute->isText())
                <p class="m-0 grow w-full">
                    {!! nl2br($attribute->mappedValue()) !!}
                </p>
            @elseif (!$attribute->isCheckbox() && !$attribute->isSection())
                <p class="text-right grow m-0 inline-block">
                    {!! $attribute->mappedValue() !!}
                </p>
            @endif
        </div>
    @endforeach
@endif
