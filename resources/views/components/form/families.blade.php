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
    foreach ($model->families as $family) {
        $selectedOption[$family->id] = strip_tags($family->name);
    }
}
?>
<label>{{ __('characters.fields.families') }}</label>

<select multiple="multiple" name="families[]" class="form-control select2" data-tags="true" style="width: 100%" data-url="{{ route('families.find') }}" data-allow-clear="true" data-allow-new="false" data-placeholder="">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>
