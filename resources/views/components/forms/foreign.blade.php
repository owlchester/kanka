
<x-forms.field
    field="{{ $key }}"
    :required="$required"
    :label="__($label)"
    :helper="$helper"
>

    <select
            @if ($multiple) multiple="multiple" @endif
            name="{{ $name }}"
            id="{{ $id }}"
            class="w-full select2 join-item"
            style="width: 100%"
            data-url="{{ $route }}"
            data-placeholder="{!! $placeholder ?? __('crud.placeholders.parent') !!}"
            data-allow-new="{{ ($canNew || $dynamicNew) ? 'true' : 'false' }}"
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

</x-forms.field>
