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
        <x-icon class="fa-regular fa-grip-vertical" />
    </div>
    <div class="field @if ($attribute->isSection()) grow @endif ">
        <label class="sr-only">{{ __('entities/attributes.labels.' . ($attribute->isSection() ? 'section' : 'name')) }}</label>
        @if($attribute->name == '_layout')
            <input type="text" name="attr_ignore[{{ $id }}]" value="{{ $attribute->name }}" placeholder="{{ __('entities/attributes.placeholders.attribute') }}" class="w-full" maxlength="191" disabled="disabled" />
            <input type="hidden" name="attr_name[{{ $id }}]" value="{{ $attribute->name }}" />
        @else
            <input type="text" name="attr_name[{{ $id }}]" value="{{ $attribute->name }}" placeholder="{{ $placeholder }}" class="w-full" maxlength="191" aria-label="{{ __('entities/attributes.labels.name') }}" />
        @endif
    </div>
    @if ($attribute->isSection())
        <input type="hidden" name="attr_value[{{ $id }}]" value="{{ $attribute->value }}" />
    @else
    <div class="grow field">
        <label class="sr-only">{{ __('entities/attributes.labels.value') }}</label>
        @if ($attribute->isCheckbox())
            <input type="hidden" name="attr_value[{{ $id }}]" value="0" />
            <input type="checkbox" name="attr_value[{{ $id }}]" value="1" @if ($attribute->value) checked="checked" @endif />
        @elseif ($attribute->isText())
            <textarea name="attr_value[{{ $id }}]" placeholder="{{ __('entities/attributes.placeholders.value') }}" class="w-full  kanka-mentions" rows="4" aria-label="{{ __('entities/attributes.labels.value') }}" data-remote="{{ route('search.live', $campaign) }}">{{ $attribute->value }}</textarea>
        @elseif ($attribute->isSection())
            <input type="hidden" name="attr_value[{{ $id }}]" value="{{ $attribute->value }}" />
        @elseif($attribute->name == '_layout')
            <input type="hidden" name="attr_value[{{ $id }}]" value="{{ $attribute->value }}" />
            <div class="rounded bg-base-200 p-2">
            {{ $attribute->value }}
            </div>
        @elseif ($attribute->isNumber())
            <input type="number" name="attr_value[{{ $id }}]" value="{{ $attribute->value }}" placeholder="{{ __('entities/attributes.placeholders.number') }}" class="w-full" maxlength="191" aria-label="{{ __('entities/attributes.labels.value') }}" />
        @else
            <input type="text" name="attr_value[{{ $id }}]" value="{{ $attribute->value }}" placeholder="{{ __('entities/attributes.placeholders.value') }}" class="w-full  kanka-mentions" maxlength="191" aria-label="{{ __('entities/attributes.labels.value') }}" data-remote="{{ route('search.live', $campaign) }}" />
        @endif
    </div>
    @endif
    <div class="flex gap-3">
        <input type="hidden" name="attr_is_pinned[{{ $id }}]" value="{{ $attribute->isPinned() }}" />
        <i class="cursor-pointer fa-star @if($attribute->isPinned()) fa-solid @else fa-regular @endif fa-2x" data-toggle="star" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="@if($attribute->isPinned()) {{ __('entities/attributes.visibility.entry') }} @else  {{ __('entities/attributes.visibility.tab') }} @endif"
        data-pin="{{ __('entities/attributes.toasts.pin') }}" data-unpin="{{ __('entities/attributes.toasts.unpin') }}"
        ></i>

        @if ($isAdmin)
            <input type="hidden" name="attr_is_private[{{ $id }}]" value="{{ $attribute->is_private }}" />
        <i class="cursor-pointer fa-solid @if($attribute->is_private) fa-lock @else fa-unlock-alt @endif fa-2x" data-toggle="private" data-private="{{ __('entities/attributes.visibility.private') }}" data-public="{{ __('entities/attributes.visibility.public') }}"
           data-lock="{{ __('entities/attributes.toasts.lock') }}" data-unlock="{{ __('entities/attributes.toasts.unlock') }}"
        ></i>
        @endif
        @if (!isset($entity) || auth()->user()->can('update', $entity))
            <a class="text-error attribute_delete" title="{{ __('crud.remove') }}">
                <x-icon class="trash" size="fa-2x" />
                <span class="sr-only">{{ __('crud.remove') }}</span>
            </a>
        @endcan
    </div>

    @dd('who is calling this')
    <input type="hidden" name="attr_type[{{ $id }}]" value="{{ $attribute->type_id }}" />
</div>
