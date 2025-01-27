<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];
$model = Arr::get($options, 'model');
$roles = Arr::get($options, 'roles', false);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('userRoles[]');
$fieldUniqIdentifier = 'user_roles_' . uniqid();

if(!empty($model) && !empty($roles)) {
    foreach ($roles as $role) {
        if ($campaignUser->user->hasCampaignRole($role->id)) {
            $selectedOption[$role->id] = strip_tags($role->name);
        }
    }
}

$dropdownParent = Arr::get($options, 'dropdownParent');
$multiple = Arr::get($options, 'multiple');
?>
<select name="{{ $multiple ? 'roles[]' : 'role'}}" id="{{ $multiple ? 'roles' : 'role'}}"
    class="select2 form-role w-100"
    @if (isset($multiple) && $multiple) multiple @endif
    data-url="{{ route('roles.find', ['campaign' => $campaign, 'with-admin' => true]) }}"
    @if (!empty($dropdownParent)) data-dropdown-parent="{{ $dropdownParent }}" @endif>

    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>
