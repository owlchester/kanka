<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$dynamicNew = Arr::get($options, 'dynamicNew', false);

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('characters[]');
$fieldUniqIdentifier = 'characters_' . uniqid();

if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model) ) {
    /** @var \App\Models\Character $character */
    foreach ($model->members() as $character) {
        $selectedOption[$character->character->id] = strip_tags($character->character->name);
    }
}
?>

<x-forms.field
    field="characters"
    :required="$required"
    :label="\App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))">

<select multiple="multiple" name="characters[]" class="w-full select2 join-item" data-tags="true" style="width: 100%" data-url="{{ route('search-list', [$campaign, config('entities.ids.character')]) }}" data-new-tag="{{ __('crud.actions.new') }}" data-allow-clear="true" data-allow-new="{{ $dynamicNew ? 'true' : 'false' }}" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

</x-forms.field>


