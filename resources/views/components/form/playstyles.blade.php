<?php
use Illuminate\Support\Arr;
use App\Models\Playstyle;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOptions = [];

$model = Arr::get($options, 'model');
$playstyles = Playstyle::get();

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('playstyles');
$fieldUniqIdentifier = 'playstyles_' . uniqid();

if (!empty($previous)) {
    foreach ($previous as $id) {
        $selectedOptions[$id] = true;
    }
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\Playstyle $playstyle */
    foreach ($model->playstyles as $playstyle) {
        $selectedOptions[$playstyle->id] = __('playstyles.' . $playstyle->slug);
    }
}
?>

<select multiple="multiple" name="playstyles[]" class="w-full select2 join-item campaign-playstyles" style="width: 100%" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($playstyles as $playstyle)
        <option value="{{ $playstyle->id }}" @if (!empty($selectedOptions[$playstyle->id])) selected="selected" @endif>{{ __('playstyles.' . $playstyle->slug) }}</option>
    @endforeach
</select>
