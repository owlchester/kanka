
<x-forms.field
    field="{{ $key }}"
    :required="$required"
    :label="__($label)"
    :helper="$helper"
    :tooltip="true">

    @if ($canNew)
        <div class="join w-full">
    @endif

    <select 
            multiple="$multiple"
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
            :dropdownParent="request()->ajax() ? '#primary-dialog' : null"

    >
        @foreach ($options as $key => $value)
            @if ($multiple)
                <option value="{{ $key }}">{!! $value !!}</option>
            @else
                <option value="{{ $key }}" class="select2-entity" selected="selected">{{ $entity->name }}</option>
            @endif
        @endforeach
    </select>

    @if ($canNew)
            <a class="quick-creator-subform btn2 join-item btn-sm" data-url="{{ route('entity-creator.form', [$campaign, 'type' => $entityType, 'origin' => 'entity-form', 'target' => $id]) }}">
                <x-icon class="plus"></x-icon>
                <span class="sr-only">{{ __('crud.create') }}</span>
            </a>
        </div>
    @endif
</x-forms.field>
