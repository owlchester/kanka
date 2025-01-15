<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];
$dropdownParent = Arr::get($options, 'dropdownParent');

?>
<select name="user"
        id="user"
        @if (isset($multiple) && $multiple) multiple @endif
        data-allow-clear="false"
        class=" select2 form-role w-100" data-url="{{ route('users.find', $campaign) }}"
        @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif data-placeholder="{{ __('crud.placeholders.user') }}">
</select>
