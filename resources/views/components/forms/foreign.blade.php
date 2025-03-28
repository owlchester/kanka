
<x-forms.field
    field="{{ $key }}"
    :required="$required"
    :label="__($label)"
    :helper="$helper"
    tooltip>

    <select
            @if ($multiple) multiple="multiple" @endif
            name="{{ $name }}"
            id="{{ $id }}"
            class="w-full select2 join-item"
            style="width: 100%"
            data-url="{{ $route }}"
            data-placeholder="{!! $placeholder ?? __('crud.placeholders.parent') !!}"
            data-allow-new="{{ $dynamicNew ? 'true' : 'false' }}"
            data-new-tag="{{ __('crud.actions.new') }}"
            data-language="{{ LaravelLocalization::getCurrentLocale() }}"
            data-allow-clear="{{ $allowClear ? 'true' : 'false' }}"
            @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif
            @if ($dynamicNew) data-new-tag="{{ $dynamicTag ?? __('crud.actions.new') }}" @endif
    >
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" selected="selected">{!! $value !!}</option>
        @endforeach
    </select>

    @if ($canNew && !$dynamicNew)
        <x-slot name="action">
            <a class="quick-creator-subform text-xs cursor-pointer" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => $entityTypeID, 'origin' => 'entity-form', 'target' => $id]) }}" aria-label="Create a new element" tabindex="0">
                <x-icon class="plus" />
                {{ __('crud.actions.new') }}
            </a>
        </x-slot>
    @endif
</x-forms.field>
