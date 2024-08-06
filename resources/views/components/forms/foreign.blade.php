
<x-forms.field
    field="{{ $key }}"
    :required="$required"
    :label="__($label)"
    :helper="$helper"
    tooltip>

    @if ($canNew)
        <div class="join w-full">
    @endif

    <select
            @if ($multiple) multiple="multiple" @endif
            name="{{ $name }}"
            id="{{ $id }}"
            class="w-full select2 join-item"
            style="width: 100%"
            data-url="{{ $route }}"
            data-placeholder="{!! $placeholder ?? __('crud.placeholders.parent') !!}"
            data-allow-new="{{ $allowNew ? 'true' : 'false' }}"
            data-language="{{ LaravelLocalization::getCurrentLocale() }}"
            data-allow-clear="{{ $allowClear ? 'true' : 'false' }}"
            @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif
    >
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" selected="selected">{!! $value !!}</option>
        @endforeach
    </select>

    @if ($canNew)
            <a class="quick-creator-subform btn2 join-item btn-sm" data-url="{{ route('entity-creator.form', [$campaign, 'type' => $entityType, 'origin' => 'entity-form', 'target' => $id]) }}">
                <x-icon class="plus" />
                <span class="sr-only">{{ __('crud.create') }}</span>
            </a>
        </div>
    @endif
</x-forms.field>
