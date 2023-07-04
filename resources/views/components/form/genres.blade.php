<?php
use Illuminate\Support\Arr;
use App\Models\Genre;
/**
 * We want to pre-load the data from the model, or what has been sent with the form.
 */
$selectedOption = [];

$model = Arr::get($options, 'model');
$genres = Genre::get();

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
        $selectedOptions[$genre->id] = __('genres.' . $genre->slug);
    }
}
?>
<label>{{ __('campaigns.fields.genre') }}</label>

<select multiple="multiple" name="genres[]" class="form-control select2 join-item campaign-genres" style="width: 100%" data-placeholder="" id="{{ $fieldUniqIdentifier }}">
    @foreach ($genres as $genre)
        <option value="{{ $genre->id }}" @if (!empty($selectedOptions[$genre->id])) selected="selected" @endif>{{ __('genres.' . $genre->slug) }}</option>
    @endforeach
</select>
