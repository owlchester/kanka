<?php
/** @var \App\Models\Attribute $attribute */
$id = isset($resetAttributeId) ? -$attribute->id : $attribute->id;

$placeholder = __('entities/attributes.placeholders.attribute');
if ($attribute->isSection()) {
    $placeholder = __('entities/attributes.placeholders.section');
} elseif ($attribute->isNumber()) {
    $placeholder = __('entities/attributes.placeholders.number');
} elseif ($attribute->isText()) {
    $placeholder = __('entities/attributes.placeholders.block');
} elseif ($attribute->isCheckbox()) {
    $placeholder = __('entities/attributes.placeholders.checkbox');
}
?>

<div class="flex flex-wrap md:flex-no-wrap items-start gap-1 attribute_row ">
    <div class="sortable-handler p-2 cursor-move">
        <x-icon class="fa-solid fa-grip-vertical" />
    </div>
    <div class="field">
        <label class="sr-only">{{ __('entities/attributes.labels.' . ($attribute->isSection() ? 'section' : 'name')) }}</label>
        @if($attribute->name == '_layout')
            {!! Form::text('attr_name[' . $id . ']', $attribute->name, [
            'placeholder' => __('entities/attributes.placeholders.attribute'),
            'class' => 'w-full',
            'maxlength' => 191,
            'disabled' => 'disabled'
        ]) !!}
            {!! Form::hidden('attr_name[' . $id . ']', $attribute->name) !!}
        @else
        {!! Form::text('attr_name[' . $id . ']', $attribute->name, [
            'placeholder' => $placeholder,
            'class' => 'w-full',
            'maxlength' => 191,
            'aria-label' => __('entities/attributes.labels.name')
        ]) !!}
        @endif
    </div>
    <div class="grow field">
        <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
        @if ($attribute->isCheckbox())
            {!! Form::hidden('attr_value[' . $id . ']', 0) !!}
            {!! Form::checkbox('attr_value[' . $id . ']', 1, $attribute->value) !!}
        @elseif ($attribute->isText())
            {!! Form::textarea('attr_value[' . $id . ']', $attribute->value, [
                'placeholder' => __('entities/attributes.placeholders.value'),
                'class' => 'w-full kanka-mentions',
                'rows' => 4,
                'data-remote' => route('search.live', $campaign),
                'aria-label' => __('entities/attributes.fields.value')
            ]) !!}
        @elseif ($attribute->isSection())
            {!! Form::hidden('attr_value[' . $id . ']', $attribute->value) !!}
        @elseif($attribute->name == '_layout')
            {!! Form::hidden('attr_value[' . $id . ']', $attribute->value) !!}
            <div class="rounded bg-base-200 p-2">
            {{ $attribute->value }}
            </div>
        @elseif ($attribute->isNumber())
            {!! Form::number('attr_value[' . $id . ']', $attribute->value, ['placeholder' => __('entities/attributes.placeholders.number'), 'class' => 'w-full', 'maxlength' => 191]) !!}
        @else
            {!! Form::text('attr_value[' . $id . ']', $attribute->value, [
                'placeholder' => __('entities/attributes.placeholders.value'),
                'class' => 'w-full kanka-mentions',
                'maxlength' => 191,
                'data-remote' => route('search.live', $campaign),
                'aria-label' => __('entities/attributes.labels.value')
            ]) !!}
        @endif
    </div>
    <div class="flex gap-3">
        {!! Form::hidden('attr_is_pinned[' . $id . ']', $attribute->isPinned()) !!}
        <i class="cursor-pointer fa-star @if($attribute->isPinned()) fa-solid @else fa-regular @endif fa-2x" data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="@if($attribute->isPinned()) {{ __('entities/attributes.visibility.entry') }} @else  {{ __('entities/attributes.visibility.tab') }} @endif"
        data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
        ></i>

        @if ($isAdmin)
        {!! Form::hidden('attr_is_private[' . $id . ']', $attribute->is_private) !!}
        <i class="cursor-pointer fa-solid @if($attribute->is_private) fa-lock @else fa-unlock-alt @endif fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
           data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
        ></i>
        @endif
        @if (!isset($model) || auth()->user()->can('attribute', [$model, 'delete']))
            <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                <x-icon class="trash" size="fa-2x" />
                <span class="sr-only">{{ __('crud.remove') }}</span>
            </a>
        @endcan
    </div>

    {!! Form::hidden('attr_type[' . $id . ']', $attribute->type_id) !!}
</div>
