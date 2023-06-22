<div class="field-hidden-attribute">
    <div class="row attribute_row">
        <div class="col-xs-12 col-sm-4">
            <dt>{{ $attribute->name }}</dt>
        </div>
        @if ($attribute->isCheckbox())
            <i class="@if($attribute->value == 1)fa-solid fa-check-square @else fa-solid fa-square @endif mr-2 fa-2x" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="@if($attribute->isPinned()) {{ __('entities/attributes.visibility.entry') }} @else  {{ __('entities/attributes.visibility.tab') }} @endif"></i>
        @else
            {{ $attribute->value }}
        @endif
    </div>
</div>
