<div class="field-hidden-attribute w-full grid grid-cols-2">
    <span>{{ $attribute->name }}</span>
    <span>
    @if ($attribute->isCheckbox())
        <i class="@if($attribute->value == 1)fa-regular fa-check-square @else fa-regular fa-square @endif mr-2 fa-2x" data-tab="{{ __('entities/attributes.visibility.tab') }}" data-entry="{{ __('entities/attributes.visibility.entry') }}" title="@if($attribute->isPinned()) {{ __('entities/attributes.visibility.entry') }} @else  {{ __('entities/attributes.visibility.tab') }} @endif"></i>
    @else
        {{ $attribute->value }}
    @endif
    </span>
</div>
