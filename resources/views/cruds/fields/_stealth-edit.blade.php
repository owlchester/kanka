@php
    $stealthHelper = !empty($postContext)
        ? __('crud.fields.stealth_edit_post_helper')
        : __('crud.fields.stealth_edit_helper');
@endphp
<div class="px-2 py-2 hover:bg-base-200 rounded-xl text-xs" data-dropdown-option>
    <label class="flex items-center gap-2 cursor-pointer text-base-content">
        <input type="checkbox" name="stealth" value="1" data-dropdown-option-checkbox @checked(old('stealth', false)) />
        <span class="leading-none">{{ __('crud.fields.stealth_edit') }}</span>
        <i
            class="fa-regular fa-question-circle text-link"
            role="button"
            tabindex="0"
            data-dropdown-option-help-toggle
            aria-label="{{ $stealthHelper }}"
        ></i>
    </label>
    <p data-dropdown-option-help class="hidden text-2xs text-neutral-content">
        {{ $stealthHelper }}
    </p>
</div>
