<?php
use Illuminate\Support\Arr;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');

// Try to load what was sent with the form first, in case there was a form validation error
$previous = old('genres[]');
$fieldUniqIdentifier = 'genres_' . uniqid();

if (!empty($previous)) {
    //dd($previous);
}
// If we didn't get anything, and there is a model sent, use that
elseif(!empty($model)) {
    /** @var \App\Models\Genre $genre */
    foreach ($model->genres as $genre) {
        $selectedOption[$genre->id] = __('genres.' . $genre->slug);
    }
}
?>
<label>{{ __('entities.families') }}</label>

<select multiple="multiple" name="genres[]" class="form-control select2 join-item" data-tags="true" style="width: 100%" data-url="{{ route('genres.find') }}" data-allow-clear="true" data-allow-new="false" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($selectedOption as $key => $val)
        <option value="{{ $key }}" selected="selected">{{ $val }}</option>
    @endforeach
</select>

