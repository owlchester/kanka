<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];


?>
<select name="role" id="role" class="form-control select2 form-role" style="width: 100%" data-url="{{ route('roles.find') }}">
</select>
