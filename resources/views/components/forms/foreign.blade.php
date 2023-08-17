<div class="field-foreign @if ($required) required @endif {{ $key }}" >
    @if (!empty($label))
        <label>{!! __($label) !!}
            @if(!empty($helper))
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" data-title="{{ $helper }}" aria-hidden="true"></i>
            @endif
        </label>
    @endif

    @if ($canNew)
        <div class="join w-full">
    @endif

    <select name="{{ $name }}" id="{{ $id }}"
            class="form-control select2 join-item"
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
            <a class="quick-creator-subform btn2 join-item btn-primary btn-outline btn-sm" data-url="{{ route('entity-creator.form', [$campaign, 'type' => $entityType, 'origin' => 'entity-form', 'target' => $id]) }}">
                <x-icon class="plus"></x-icon>
                <span class="sr-only">{{ __('crud.create') }}</span>
            </a>
        </div>
    @endif

    @if (!empty($helper))
        <p class="help-block visible-xs visible-sm">
            {{ $helper }}
        </p>
    @endif
</div>
