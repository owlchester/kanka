<div class="field-foreign form-group @if ($required) required @endif">
    @if (!empty($label))
        <label>{!! __($label) !!}
            @if(!empty($helper))
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ $helper }}" aria-hidden="true"></i>
            @endif
        </label>
    @endif

    @if ($canNew)
        <div class="input-group input-group-sm w-full">
    @endif

    <select name="{{ $name }}" id="{{ $id }}"
            class="form-control select2 w-full"
            style="width: 100%"
            data-url="{{ $route }}"
            data-placeholder="{!! $placeholder ?? __('crud.placeholders.parent') !!}"
            data-allow-new="{{ $allowNew ? 'true' : 'false' }}"
            data-language="{{ LaravelLocalization::getCurrentLocale() }}"
            data-allow-clear="{{ $allowClear ? 'true' : 'false' }}"
            @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif
    >
        @foreach ($options as $key => $value)
            <option value="{{ $key }}">{!! $value !!}</option>
        @endforeach
    </select>

    @if ($canNew)
            <div class="input-group-btn">
                <a class="quick-creator-subform btn btn-tab-form" data-url="{{ route('entity-creator.form', ['type' => $entityType, 'origin' => 'entity-form', 'target' => $id]) }}">
                    <x-icon class="plus"></x-icon>
                    <span class="sr-only">{{ __('crud.create') }}</span>
                </a>
            </div>
        </div>
    @endif

    @if (!empty($helper))
        <p class="help-block visible-xs visible-sm">
            {{ $helper }}
        </p>
    @endif
</div>
