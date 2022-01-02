<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model', null);
$source = Arr::get($options, 'source', null);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old($fieldId);
if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\OrganisationMember $member */
    foreach ($model->races as $race) {
        if (\App\Facades\EntityPermission::canView($race->entity)) {
            // If this is a copy, we need to add the member's real id. Also no copying of roles in this constellation
            if (!empty($source)) {
                $selectedOption[$race->id] = strip_tags($race->name);
            } else {
                $selectedOption['r_' . $race->id] = strip_tags($race->name);
            }
        }
    }
}
?>
<label>{{ __('characters.fields.races') }}</label>

<select multiple="multiple" name="races[]" id="races" class="form-control select2" data-tags="true" style="width: 100%" data-url="{{ route('races.find') }}" data-allow-clear="true" data-placeholder=" ">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>
