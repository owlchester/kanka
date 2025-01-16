<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];
$dropdownParent = Arr::get($options, 'dropdownParent');
$multiple = Arr::get($options, 'multiple');
?>
<select name="{{ $multiple ? 'roles[]' : 'role'}}" id="{{ $multiple ? 'roles' : 'role'}}"
    class="select2 form-role w-100"
    @if (isset($multiple) && $multiple) multiple @endif
    data-url="{{ route('roles.find', $campaign) }}"
    @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif>
</select>
