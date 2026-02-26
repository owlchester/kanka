<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$dynamicNew = Arr::get($options, 'dynamicNew', false);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('families[]');
$fieldUniqIdentifier = 'families_' . uniqid();

if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\Family $family */
    foreach ($model->characterFamilies as $family) {
        $selectedOption[$family->family->id] = strip_tags($family->family->name);
    }
}
?>

<x-forms.field
    field="families"
    :label="\App\Facades\Module::plural(config('entities.ids.family'), __('entities.families'))">


<select multiple="multiple" name="families[]" class="w-full select2 join-item" data-tags="true" style="width: 100%" data-url="{{ route('search-list', [$campaign, config('entities.ids.family')]) }}" data-new-tag="{{ __('crud.actions.new') }}" data-allow-clear="true" data-allow-new="{{ $dynamicNew ? 'true' : 'false' }}" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

</x-forms.field>

