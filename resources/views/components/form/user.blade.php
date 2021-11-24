<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];
$dropdownParent = Arr::get($options, 'dropdown-parent');

?>
<select name="user" id="user"
    class="form-control select2 form-user" style="width: 100%" data-url="{{ route('users.find') }}"
    @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif>
</select>
